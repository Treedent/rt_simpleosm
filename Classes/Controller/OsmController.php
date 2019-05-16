<?php

namespace CMSPACA\RtSimpleosm\Controller;

/***
 *
 * This file is part of the "Simple OpenStreetMap" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Regis TEDONE <regis.tedone@gmail.com>, CMS-PACA
 *
 ***/

use CMSPACA\RtSimpleosm\Domain\Model\Osm;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use CMSPACA\RtSimpleosm\Domain\Repository\OsmRepository;

/**
 * OsmController
 */
class OsmController extends ActionController {

	/**
	 * Expose the pageRenderer
	 *
	 * @var $pageRenderer
	 */
	protected $pageRenderer;

	/**
	 * osmRepository
	 * @var OsmRepository $osmRepository
	 */
	protected $osmRepository;

	/**
	 * Osm Repository injector
	 *
	 * @param OsmRepository $osmRepository
	 */
	public function injectOsmRepository( OsmRepository $osmRepository ) {
		$this->osmRepository = $osmRepository;
	}

	/**
	 * action displayMap
	 *
	 * @return void
	 */
	public function displayMapAction() {
		
		// Skip rendering of the map if settings are not provided
		if (empty($this->settings)) {
			return;
		}

		//Get Flexform data
		$mapWidth                = $this->settings['MapWidth'];
		$mapHeight               = $this->settings['MapHeight'];
		$displayZoomButtons      = $this->settings['DisplayZoomButtons'];
		$displayFullScreenButton = $this->settings['DisplayFullScreenButton'];
		$displayMiniMap          = $this->settings['DisplayMiniMap'];
		$displayCaptionMenu      = $this->settings['DisplayCaptionMenu'];
		$zoom                    = $this->settings['Zoom'];
		$scrollWheelZoom         = $this->settings['ScrollWheelZoom'];
		$borderRadiusMap         = $this->settings['BorderRadiusMap'];
		$mapStyle                = $this->settings['MapStyle'];
		$popupOptions            = (int) $this->settings['PopupOptions'];

		// Get current event plugin uid
		$cObj = $this->configurationManager->getContentObject();
		$cUid = $cObj->data['uid'];

		// Initiate the page renderer
		$this->pageRenderer = GeneralUtility::makeInstance( PageRenderer::class );

		// Get Osm records IDs
		preg_match_all( '/tx_rtsimpleosm_domain_model_osm_(\d+),?/', $this->settings['MapRecord'], $mapRecords );

		// Get all OSM Objects with those IDs
		$markersOsm = array_map( array( $this->osmRepository, "findByUid" ), $mapRecords[1] );

		$markersTtAddress = [];
		if(isset($GLOBALS['TYPO3_LOADED_EXT']['tt_address'])) {
			// Get tt_address records IDs
			preg_match_all( '/tt_address_(\d+),?/', $this->settings['MapRecord'], $ttAddressRecords );
			// Get all tt_address Objects with those IDs and convert them to Osm objects
			$markersTtAddress = $this->osmRepository->findByTtAddressUid($ttAddressRecords[1]);
		}

		// Remove empty markers (in case findByUid returns null)
		$markers = array_filter( array_merge($markersOsm, $markersTtAddress) );

		if(is_array($markers)) {

			if ( $displayCaptionMenu === '1' ) {
				$markers = $this->osmRepository->setMapMarkersUids( $markers, $cUid );
			}

			// Define Map Style
			switch ( $mapStyle ) {
				//  OpenStreetMap Mapnik
				default:
				case 0:
					$tileLayer   = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
					$attribution = '{ attribution: \'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors\'}';
					$minZoom     = 0;
					$maxZoom     = 18;
					break;

				// OpenStreetMap black and white
				case 1:
					$tileLayer   = 'https://tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png';
					$attribution = '{ attribution: \'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors\'}';
					$minZoom     = 0;
					$maxZoom     = 18;
					break;

				// OpenStreetMap hot
				case 2:
					$tileLayer   = 'https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png';
					$attribution = '{ attribution: \'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Tiles style by <a href="https://www.hotosm.org/" target="_blank">Humanitarian OpenStreetMap Team</a> hosted by <a href="https://openstreetmap.fr/" target="_blank">OpenStreetMap France</a>\'}';
					$minZoom     = 1;
					$maxZoom     = 18;
					break;

				// Stamen Design toner light
				case 3:
					$tileLayer   = 'https://stamen-tiles-{s}.a.ssl.fastly.net/toner-lite/{z}/{x}/{y}{r}.png';
					$attribution = '{ attribution: \'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors\'}';
					$minZoom     = 0;
					$maxZoom     = 18;
					break;

				// Stamen Design terrain
				case 4:
					$tileLayer   = 'https://stamen-tiles-{s}.a.ssl.fastly.net/terrain/{z}/{x}/{y}{r}.png';
					$attribution = '{ attribution: \'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors\'}';
					$minZoom     = 0;
					$maxZoom     = 17;
					break;

				// Stamen Design watercolor + Hydda roads and labels
				case 5:
					$tileLayer    = 'https://stamen-tiles-{s}.a.ssl.fastly.net/watercolor/{z}/{x}/{y}.png';
					$attribution  = '{ attribution: \'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors\'}';
					$tileLayer2   = 'https://{s}.tile.openstreetmap.se/hydda/roads_and_labels/{z}/{x}/{y}.png';
					$attribution2 = '{ attribution: \'Tiles courtesy of <a href="http://openstreetmap.se/" target="_blank">OpenStreetMap Sweden</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors\'}';
					$minZoom      = 1;
					$maxZoom      = 16;
					break;

				// MTB Map (Europe only)
				case 6:
					$tileLayer   = 'http://tile.mtbmap.cz/mtbmap_tiles/{z}/{x}/{y}.png';
					$attribution = '{ attribution: \'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &amp; USGS\'}';
					$minZoom     = 1;
					$maxZoom     = 18;
					break;

				// ESRI World Street Map
				case 7:
					$tileLayer   = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}';
					$attribution = '{ attribution: \'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012\'}';
					$minZoom     = 0;
					$maxZoom     = 18;
					break;

				// Carto DB Positron
				case 8:
					$tileLayer   = 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';
					$attribution = '{ attribution: \'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>\'}';
					$minZoom     = 0;
					$maxZoom     = 18;
					break;

				// Hydda full
				case 9:
					$tileLayer   = 'https://{s}.tile.openstreetmap.se/hydda/full/{z}/{x}/{y}.png';
					$attribution = '{ attribution: \'Tiles courtesy of <a href="http://openstreetmap.se/" target="_blank">OpenStreetMap Sweden</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors\'}';
					$minZoom     = 0;
					$maxZoom     = 18;
					break;

				// ESRI world imagery + Stamen toner labels
				case 10:
					$tileLayer    = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
					$attribution  = '{ attribution: \'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community\'}';
					$tileLayer2   = 'https://stamen-tiles-{s}.a.ssl.fastly.net/toner-labels/{z}/{x}/{y}{r}.png';
					$attribution2 = '{ attribution: \'Map labels by <a href="http://stamen.com">Stamen Design</a>\'}';
					$minZoom      = 0;
					$maxZoom      = 18;
					break;

				// OpenStreetMap Deutschland
				case 11:
					$tileLayer   = 'https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png';
					$attribution = '{ attribution: \'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors\'}';
					$minZoom     = 0;
					$maxZoom     = 18;
					break;

				// OpenStreetMap France
				case 12:
					$tileLayer   = 'https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png';
					$attribution = '{ attribution: \'&copy; Openstreetmap France | &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors\'}';
					$minZoom     = 0;
					$maxZoom     = 18;
					break;

				// OpenTopoMap
				case 13:
					$tileLayer   = 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png';
					$attribution = '{ attribution: \'Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)\'}';
					$minZoom     = 0;
					$maxZoom     = 17;
					break;

				// OpenMapSurfer Roads
				case 14:
					$tileLayer   = 'https://maps.heigit.org/openmapsurfer/tiles/roads/webmercator/{z}/{x}/{y}.png';
					$attribution = '{ attribution: \'Imagery from <a href="http://giscience.uni-hd.de/">GIScience Research Group @ University of Heidelberg</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors\'}';
					$minZoom     = 0;
					$maxZoom     = 18;
					break;
			}

			$mapConf = '{
	            zoomControl: false,     
	            minZoom: ' . $minZoom . ',
	            maxZoom: ' . $maxZoom . ',
	            animate: true,
	            scrollWheelZoom: ' . $scrollWheelZoom . '
	         }
			';

			// Get extension configuration
			$extConf = '';
			if ( version_compare( TYPO3_version, '9.0', '<' ) ) {
				$extConf = unserialize( $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['rt_simpleosm'] );
			} elseif ( version_compare( TYPO3_version, '9.0', '>=' ) ) {
				$extConf = GeneralUtility::makeInstance( \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class )->get( 'rt_simpleosm' );
			}

			// Inject leaflet CSS
			if ( $extConf['useCdn'] === '1' ) {
				$this->pageRenderer->addCssLibrary(
					'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.4.0/leaflet.css',
					'stylesheet',
					'all',
					'LeafletCss', /* title */
					false, /* compress */
					true, /* force on top */
					'', /* allwrap */
					true /* exlude from concatenation */
				);
			} else {
				$this->pageRenderer->addCssLibrary(
					'/typo3conf/ext/rt_simpleosm/Resources/Public/Css/leaflet.min.css',
					'stylesheet',
					'all',
					'LeafletCss', /* title */
					true, /* compress */
					true, /* force on top */
					'', /* allwrap */
					true /* exlude from concatenation */
				);
			}

			// Inject OSM fullscreen plugin CSS
			if ( $displayFullScreenButton === '1' ) {
				if ( $extConf['useCdn'] === '1' ) {
					$this->pageRenderer->addFooterData(
						'<link rel="stylesheet" href="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css" />'
					);
				} else {
					$this->pageRenderer->addFooterData(
						'<link rel="stylesheet" href="/typo3conf/ext/rt_simpleosm/Resources/Public/Css/leaflet.fullscreen.min.css" />'
					);
				}
			}

			// Inject leaflet MiniMap CSS
			if($displayMiniMap === '1') {
				if ( $extConf['useCdn'] === '1' ) {
					$this->pageRenderer->addFooterData(
						'<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-minimap/3.6.1/Control.MiniMap.min.css" />'
					);
				} else {
					$this->pageRenderer->addFooterData(
						'<link rel="stylesheet" href="/typo3conf/ext/rt_simpleosm/Resources/Public/Css/Control.MiniMap.min.css" />'
					);
				}
			}

			// Inject External Caption Menu CSS
			if ( $displayCaptionMenu === '1' ) {
				$this->pageRenderer->addFooterData(
					'<link rel="stylesheet" href="/typo3conf/ext/rt_simpleosm/Resources/Public/Css/captionmenu.css" />'
				);
			}

			// Inject map css
			$mapCss = '
		        #map_' . $cUid . ' {
		            width: ' . $mapWidth . ';
					height: ' . $mapHeight . ';
					border-radius: ' . $borderRadiusMap . ';
				}
			';

			$this->pageRenderer->addCssInlineBlock( 'mapCss_' . $cUid, $mapCss, true );

			// Inject Leaflet JS lib
			if ( $extConf['useCdn'] === '1' ) {
				$this->pageRenderer->addJsFooterLibrary(
					'leafletJS', /* name */
					'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.4.0/leaflet.js',
					'text/javascript', /* type */
					false, /* compress*/
					true, /* force on top */
					'', /* allwrap */
					true /* exlude from concatenation */
				);
			} else {
				$this->pageRenderer->addJsFooterLibrary(
					'leafletJS', /* name */
					'/typo3conf/ext/rt_simpleosm/Resources/Public/JavaScript/leaflet.min.js',
					'text/javascript', /* type */
					true, /* compress*/
					true, /* force on top */
					'', /* allwrap */
					true /* exlude from concatenation */
				);
			}

			// Inject OSM fullscreen plugin JS lib
			if ( $displayFullScreenButton === '1' ) {
				if ( $extConf['useCdn'] === '1' ) {
					$this->pageRenderer->addJsFooterLibrary(
						'leafletFullscreenJS',  /* name */
						'https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js',
						'text/javascript', /* type */
						false, /* compress*/
						false, /* force on top */
						'', /* allwrap */
						true /* exlude from concatenation */
					);
				} else {
					$this->pageRenderer->addJsFooterLibrary(
						'leafletFullscreenJS',  /* name */
						'/typo3conf/ext/rt_simpleosm/Resources/Public/JavaScript/Leaflet.fullscreen.min.js',
						'text/javascript', /* type */
						true, /* compress*/
						false, /* force on top */
						'', /* allwrap */
						true /* exlude from concatenation */
					);
				}
			}

			// Inject Leaflet Minimap JS Lib
			if($displayMiniMap === '1') {
				if( $extConf['useCdn'] === '1' ) {
					$this->pageRenderer->addJsFooterLibrary(
						'leafletMiniMapJS',  /* name */
						'https://cdnjs.cloudflare.com/ajax/libs/leaflet-minimap/3.6.1/Control.MiniMap.min.js',
						'text/javascript', /* type */
						false, /* compress*/
						false, /* force on top */
						'', /* allwrap */
						true /* exlude from concatenation */
					);
				} else {
					$this->pageRenderer->addJsFooterLibrary(
						'leafletMiniMapJS',  /* name */
						'/typo3conf/ext/rt_simpleosm/Resources/Public/JavaScript/Control.MiniMap.min.js',
						'text/javascript', /* type */
						true, /* compress*/
						false, /* force on top */
						'', /* allwrap */
						false /* exlude from concatenation */
					);
				}
			}

			// Define map and title layer 1
			$leafletScript = '
					window[\'map_' . $cUid . '\'] = new L.map(\'map_' . $cUid . '\', ' . $mapConf . ');
					L.tileLayer(\'' . $tileLayer . '\', ' . $attribution . ').addTo(window[\'map_' . $cUid . '\']);
			';

			// Zoom control options
			if ( $displayZoomButtons === '1' ) {
				$leafletScript .= '
			         window[\'zoomOptions_' . $cUid . '\'] = { zoomInTitle: \'' . LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang.xlf:map.label.zoomIn', 'rt_simpleosm' ) . '\', zoomOutTitle: \'' . LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang.xlf:map.label.zoomOut', 'rt_simpleosm' ) . '\', position:\'topleft\' };
			         L.control.zoom(window[\'zoomOptions_' . $cUid . '\']).addTo(window[\'map_' . $cUid . '\']);
			     ';
			}

			// Add Title layer 2
			if ( ! empty( $tileLayer2 ) && ! empty( $attribution2 ) ) {
				$leafletScript .= '
	                 L.tileLayer(\'' . $tileLayer2 . '\', ' . $attribution2 . ').addTo(window[\'map_' . $cUid . '\']);
				';
			}

			// Add markers
			$markers_data = array_map( function( Osm $map ) {
				return '{   latlng: ['   . $map->getLatitude() . ',' . $map->getLongitude() . '], '.
				            'popup: \''  . addslashes( $this->getPopupContent($map) ) . '\',' .
				            'icon: \''   . PathUtility::getAbsoluteWebPath(GeneralUtility::getFileAbsFileName($GLOBALS['TCA']['tx_rtsimpleosm_domain_model_osm']['columns']['markericon']['config']['items'][$map->getMarkericon()][2])) . '\',' .
				            'shadow: \'' . PathUtility::getAbsoluteWebPath(GeneralUtility::getFileAbsFileName($GLOBALS['TCA']['tx_rtsimpleosm_domain_model_osm']['columns']['markericon']['config']['items'][$map->getMarkericon()][3])) . '\'' .
				       ' }';
			}, $markers );
			$leafletScript .= '
				let markers_' . $cUid . '_data = [' . join( ',', $markers_data ) . '], group_' . $cUid . ' = new L.featureGroup([]), marker_' . $cUid . ', i_' . $cUid . '=0;
				window[\'mapMarkers_' . $cUid . '\'] = [];
				while (marker_' . $cUid . ' = markers_' . $cUid . '_data[i_' . $cUid . '++]) {
					let LeafIcon = L.Icon.extend({ options: { shadowUrl: marker_' . $cUid . '.shadow, iconSize: [25, 41], shadowSize: [60, 74], iconAnchor: [12, 41], shadowAnchor: [31, 51], popupAnchor: [0, -40] } });				
					let customMarker = new LeafIcon({iconUrl: marker_' . $cUid . '.icon});
					let mapMarker = new L.marker(marker_' . $cUid . '.latlng, {icon: customMarker});
					mapMarker' . ( ( $popupOptions > 1 ) ? '.bindPopup(marker_' . $cUid . '.popup)' : '' ) . ';
					group_' . $cUid . '.addLayer(mapMarker);
					window[\'mapMarkers_' . $cUid . '\'].push(mapMarker);
				}
				window[\'map_' . $cUid . '\'].fitBounds(group_' . $cUid . '.getBounds(), {padding: [25,25], maxZoom: ' . $zoom . '})' . ( ( $popupOptions > 0 ) ? '.addLayer(group_' . $cUid . ')' : '') . ';
			';

			if($displayMiniMap === '1') {
				$leafletScript .= '
					let osm2_' . $cUid . ' = new L.TileLayer(\''.$tileLayer.'\');
					let miniMap_' . $cUid . ' = new L.Control.MiniMap(osm2_' . $cUid . ', {toggleDisplay: true}).addTo(window[\'map_' . $cUid . '\']);
				';
			}
			
			// Add full screen button
			if ( $displayFullScreenButton === '1' ) {
				$leafletScript .= '
					window[\'map_' . $cUid . '\'].addControl(new L.Control.Fullscreen({
	                    title: {
	                        \'false\': \'' . LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang.xlf:map.label.viewFullscreen', 'rt_simpleosm' ) . '\',
	                        \'true\': \'' . LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang.xlf:map.label.exitFullscreen', 'rt_simpleosm' ) . '\'
	                    }
					}));
				';
			}

			// Add External Caption Menu JS
			if ( $displayCaptionMenu === '1' ) {
				$leafletScript .= '
					let captionLinks_' . $cUid . ' = document.querySelectorAll(\'[id^="mapMarker-' . $cUid . '"]\');
					for (let cl=0; cl<captionLinks_' . $cUid . '.length; cl++) {
						 captionLinks_' . $cUid . '[cl].addEventListener("click", function() {
						     window[\'mapMarkers_' . $cUid . '\'][cl].openPopup();
						     window[\'map_' . $cUid . '\'].setView(window[\'mapMarkers_' . $cUid . '\'][cl].getLatLng());
						     if(this.blur)this.blur();
						 });
					}
				';
				$markersMenuItems = [];
				foreach ($markers as $markerMenuItem) {
					array_push($markersMenuItems, [
						'muid'   => $markerMenuItem->getMapmarkeruid(),
						'icon'  => PathUtility::getAbsoluteWebPath(GeneralUtility::getFileAbsFileName($GLOBALS['TCA']['tx_rtsimpleosm_domain_model_osm']['columns']['markericon']['config']['items'][$markerMenuItem->getMarkericon()][2])),
						'title' => $markerMenuItem->getTitle()
					]);
				}
				$this->view->assignMultiple( [
					'displayCaptionMenu' => $displayCaptionMenu,
					'markersMenuItems'   => $markersMenuItems,
					'popupOptions'      => $popupOptions
				]);
			}

			// Renders map leaflet script
			$this->pageRenderer->addJsFooterInlineCode( 'leafletScript_' . $cUid, $leafletScript, true );
			$this->view->assign( 'cUid', $cUid );
			
		} else {
			$this->pageRenderer->addCssLibrary(
				'/typo3conf/ext/rt_simpleosm/Resources/Public/Css/osmalert.css',
				'stylesheet',
				'all',
				'OsmAlert', /* title */
				true, /* compress */
				true, /* force on top */
				'', /* allwrap */
				false /* exlude from concatenation */
			);
			$this->view->assign( 'noValidMapRecordSelected', true );
		}
	}

	/**
	 * Returns marker popup content
	 * @param $map Osm
	 * @return string
	 */
	private function getPopupContent( Osm $map ) {
		if ( in_array($this->settings['PopupOptions'],['0','1']) ) {
			return '';
		}
		//Define popup content
		$popupContent = $map->getTitle();
		if( '3' === $this->settings['PopupOptions'] ) {
			$popupContent .= '<br />' . nl2br( $map->getAddress() );
		}
		return trim( str_replace( array( "\n\r", "\n", "\r" ), '', $popupContent ) );
	}
}