<?php

namespace CMSPACA\RtSimpleosm\Hooks;

use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Hook to render preview widget of custom content elements in page module
 * @see \TYPO3\CMS\Backend\View\PageLayoutView::tt_content_drawItem()
 */
class PageLayoutViewDrawItemHook implements PageLayoutViewDrawItemHookInterface {

	/**
	 * @var string $osm_table : table storing OpenStreetMaps
	 */
	private $osm_table = 'tx_rtsimpleosm_domain_model_osm';

	/**
	 * @var string $beosm_template Simple OSM backend template
	 */
	private $beosm_template = 'EXT:rt_simpleosm/Resources/Private/Templates/Backend/Rtsimpleosm-Plugin-BackendTemplate.html';

	/**
	 * Rendering for custom content elements
	 *
	 * @param PageLayoutView $parentObject
	 * @param bool $drawItem
	 * @param string $headerContent
	 * @param string $itemContent
	 * @param array $row
	 */
	public function preProcess( PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row ) {

		$plugins = [ 'rtsimpleosm_sosm' ];

		if ( ! in_array( $row['list_type'], $plugins ) ) {
			return;
		}

		$drawItem = false;

		$noHeaderFound = LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_be.xlf:simpleosm.backend.noHeaderFound', 'rt_simpleosm' );

		$title         = empty( $row['header'] ) ? '[ ' . $noHeaderFound . ' ]' : $row['header'] . ' ' . LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_be.xlf:simpleosm.backend.headerLayout.' . $row['header_layout'], 'rt_simpleosm' );
		$headerContent = '<strong>' . htmlspecialchars( $title ) . '</strong><br />';

		// If no flexform data is provided, prevent to go further
		// @ToDo: create a better solution
		if ( !$row['pi_flexform'] ) {
			return;
		}

		$flexform = $this->cleanUpArray( GeneralUtility::xml2array( $row['pi_flexform'] ), array(
			'data',
			'lDEF',
			'vDEF'
		) );

		$flex = [];

		// Get extension configuration
		$extConf = '';
		if ( version_compare( TYPO3_version, '9.0', '<' ) ) {
			$extConf = unserialize( $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['rt_simpleosm'] );
		} elseif ( version_compare( TYPO3_version, '9.0', '>=' ) ) {
			$extConf = GeneralUtility::makeInstance( \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class )->get( 'rt_simpleosm' );
		}

		switch ( $extConf['backendPluginInterfaceBackground'] ) {
			case '0':
				$flex['background_style'] = 'background: url(\'' . $extConf['backendPluginInterfaceBackgroundImage'] . '\')';
				break;

			case '1':
				$flex['background_style'] = 'background-color: ' . $extConf['backendPluginInterfaceBackgroundColor'];
				break;
		}

		$flex['contents'] = [];

		//****************************
		// Plugin Simple OSM
		//****************************
		$fluidTmplFilePath    = GeneralUtility::getFileAbsFileName( $this->beosm_template );
		$flex['plugin_icon']  = 'rt_simpleosm-plugin-sosm';
		$flex['plugin_title'] = LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.name', 'rt_simpleosm' );

		$flex['contents']['markers'] = [];

		if ( !empty( $flexform['mapselection']['settings.MapRecord'] ) ) {
			//Get Map records
			preg_match_all( '/tx_rtsimpleosm_domain_model_osm_(\d+),?/', $flexform['mapselection']['settings.MapRecord'], $mapRecords );
			$mapRecordIds = array_map( 'intval', $mapRecords[1] );
			$selectedMarkers = [];

			if ( version_compare( TYPO3_version, '8.0', '<' ) ) {
				// Database connection
				global $TYPO3_DB;
				$fields       = "`uid`,`title`,`latitude`,`longitude`,`address`";
				$where_clause = "`uid` IN (" . join( ', ', $mapRecordIds ) . ")";
				$selectedMarkers  = $TYPO3_DB->exec_SELECTgetRows( $fields, $this->osm_table, $where_clause );

			} elseif ( version_compare( TYPO3_version, '8.0', '>=' ) ) {
				// Database connection
				$connectionPool   = GeneralUtility::makeInstance( \TYPO3\CMS\Core\Database\ConnectionPool::class );
				$pageQueryBuilder = $connectionPool->getQueryBuilderForTable( $this->osm_table );

				// Get OSM infos
				$selectedMarkers = $pageQueryBuilder
					->select( 'uid', 'title', 'latitude', 'longitude', 'address' )
					->from( $this->osm_table )
					->where(
						$pageQueryBuilder->expr()->in( 'uid', $pageQueryBuilder->createNamedParameter( $mapRecordIds, \TYPO3\CMS\Core\Database\Connection::PARAM_INT_ARRAY ) )
					)
					->execute()
					->fetchAll();
			}

			$markers = [];
			foreach ( $selectedMarkers as $selectedMarker ) {
				$markers[] = [
					'icon' => '../typo3conf/ext/rt_simpleosm/Resources/Public/Icons/user_plugin_sosm.svg',
					'uid' => $selectedMarker['uid'],
					'title' => $selectedMarker['title'],
					'latitude' => '<strong><em>' . LocalizationUtility::translate('LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rtsimpleosm_domain_model_osm.latitude', 'rt_simpleosm') . '</em></strong>: ' . $selectedMarker['latitude'] . '.<br />',
					'longitude' => '<strong><em>' . LocalizationUtility::translate('LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rtsimpleosm_domain_model_osm.longitude', 'rt_simpleosm') . '</em></strong>: ' . $selectedMarker['longitude'] . '.<br />',
					'address' => '<strong><em>' . LocalizationUtility::translate('LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rtsimpleosm_domain_model_osm.address', 'rt_simpleosm') . '</em></strong>: ' . $selectedMarker['address'] . '.<br />',
				];
			}
			$flex['contents']['markers'] = $markers;
		}

		if ( !empty( $flexform['styling']['settings.MapStyle'] || $flexform['styling']['settings.MapStyle'] === '0') ) {
			$flex['contents']['mapStyleImg']   = '../typo3conf/ext/rt_simpleosm/Resources/Public/maps/map_' . $flexform['styling']['settings.MapStyle'] . '.png';
			$flex['contents']['mapStyleLabel'] = '<strong><em>' . LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.mapStyle', 'rt_simpleosm' ) . '</em></strong>: ' . LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.mapStyle.' . $flexform['styling']['settings.MapStyle'], 'rt_simpleosm' ) . '.';
		}

		if ( !empty( $flexform['styling']['settings.MapWidth'] ) ) {
			$flex['contents']['mapWidth'] = '<strong><em>' . LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.mapWidth', 'rt_simpleosm' ) . '</em></strong>: ' . $flexform['styling']['settings.MapWidth'] . '.<br />';
		}

		if ( !empty( $flexform['styling']['settings.MapHeight'] ) ) {
			$flex['contents']['mapHeight'] = '<strong><em>' . LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.mapHeight', 'rt_simpleosm' ) . '</em></strong>: ' . $flexform['styling']['settings.MapHeight'] . '.<br />';
		}

		if ( !empty( $flexform['styling']['settings.BorderRadiusMap'] ) ) {
			$flex['contents']['borderRadiusMap'] = '<strong><em>' . LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.borderRadiusMap', 'rt_simpleosm' ) . '</em></strong>: ' . $flexform['styling']['settings.BorderRadiusMap'] . '.<br />';
		}

		if ( !empty( $flexform['options']['settings.Zoom'] ) ) {
			$flex['contents']['zoom'] = '<strong><em>' . LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.zoom', 'rt_simpleosm' ) . '</em></strong>: ' . $flexform['options']['settings.Zoom'] . '.<br />';
		}

		if ( !empty( $flexform['options']['settings.PopupOptions'] ) ) {
			$flex['contents']['popupOptions'] = '<strong><em>' . LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.popupOptions', 'rt_simpleosm' ) . '</em></strong>: ' . LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.popupOptions.' . $flexform['options']['settings.PopupOptions'], 'rt_simpleosm' ) . '.<br />';
		}

		if ( !empty( $flexform['options']['settings.ScrollWheelZoom'] ) ) {
			$flex['contents']['scrollWheelZoom'] = '<strong><em>' . LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.scrollWheelZoom', 'rt_simpleosm' ) . '</em></strong>: ' . $flexform['options']['settings.ScrollWheelZoom'] . '.<br />';
		}

		if ( !empty( $flexform['options']['settings.DisplayZoomButtons'] ) ) {
			$flex['contents']['displayZoomButtons'] = '<strong><em>' . LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.displayZoomButtons', 'rt_simpleosm' ) . '</em></strong>: ' . $flexform['options']['settings.DisplayZoomButtons'] . '.<br />';
		}

		if ( !empty( $flexform['options']['settings.DisplayFullScreenButton'] ) ) {
			$flex['contents']['displayFullScreenButton'] = '<strong><em>' . LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.displayFullScreenButton', 'rt_simpleosm' ) . '</em></strong>: ' . $flexform['options']['settings.DisplayFullScreenButton'] . '.<br />';
		}

		// HTML Template loading
		$fluidTmpl = GeneralUtility::makeInstance( 'TYPO3\CMS\Fluid\View\StandaloneView' );
		$fluidTmpl->setTemplatePathAndFilename( $fluidTmplFilePath );
		$fluidTmpl->assign( 'flex', $flex );

		// Render final content
		$itemContent = $parentObject->linkEditContent( $fluidTmpl->render(), $row );
	}

	/**
	 * @param array $cleanUpArray
	 * @param array $notAllowed
	 *
	 * @return array|mixed
	 */
	protected function cleanUpArray( array $cleanUpArray, array $notAllowed ) {
		$cleanArray = array();
		foreach ( $cleanUpArray as $key => $value ) {
			if ( in_array( $key, $notAllowed ) ) {
				return is_array( $value ) ? $this->cleanUpArray( $value, $notAllowed ) : $value;
			} else if ( is_array( $value ) ) {
				$cleanArray[ $key ] = $this->cleanUpArray( $value, $notAllowed );
			}
		}

		return $cleanArray;
	}
}