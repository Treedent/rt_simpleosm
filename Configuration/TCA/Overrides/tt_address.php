<?php
defined('TYPO3_MODE') || die();

if(isset($GLOBALS['TYPO3_LOADED_EXT']['tt_address'])) {
	/**
	 * TCA additional column for tt_address
	 */
	$tempColumns = [
		'markericon' => [
			'exclude' => false,
			'label' => 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.0',   0,  'EXT:rt_simpleosm/Resources/Public/Icons/marker-icon.png',         'EXT:rt_simpleosm/Resources/Public/Icons/marker-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.1',   1,  'EXT:rt_simpleosm/Resources/Public/Icons/map-marker-black.svg',    'EXT:rt_simpleosm/Resources/Public/Icons/marker-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.2',   2,  'EXT:rt_simpleosm/Resources/Public/Icons/map-marker-blue.svg',     'EXT:rt_simpleosm/Resources/Public/Icons/marker-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.3',   3,  'EXT:rt_simpleosm/Resources/Public/Icons/map-marker-deepblue.svg', 'EXT:rt_simpleosm/Resources/Public/Icons/marker-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.4',   4,  'EXT:rt_simpleosm/Resources/Public/Icons/map-marker-green.svg',    'EXT:rt_simpleosm/Resources/Public/Icons/marker-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.5',   5,  'EXT:rt_simpleosm/Resources/Public/Icons/map-marker-fuchsia.svg',  'EXT:rt_simpleosm/Resources/Public/Icons/marker-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.6',   6,  'EXT:rt_simpleosm/Resources/Public/Icons/map-marker-orange.svg',   'EXT:rt_simpleosm/Resources/Public/Icons/marker-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.7',   7,  'EXT:rt_simpleosm/Resources/Public/Icons/map-marker-purple.svg',   'EXT:rt_simpleosm/Resources/Public/Icons/marker-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.8',   8,  'EXT:rt_simpleosm/Resources/Public/Icons/map-marker-red.svg',      'EXT:rt_simpleosm/Resources/Public/Icons/marker-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.9',   9,  'EXT:rt_simpleosm/Resources/Public/Icons/map-marker-yellow.svg',   'EXT:rt_simpleosm/Resources/Public/Icons/marker-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.10',  10, 'EXT:rt_simpleosm/Resources/Public/Icons/map-pin-black.svg',       'EXT:rt_simpleosm/Resources/Public/Icons/pin-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.11',  11, 'EXT:rt_simpleosm/Resources/Public/Icons/map-pin-blue.svg',        'EXT:rt_simpleosm/Resources/Public/Icons/pin-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.12',  12, 'EXT:rt_simpleosm/Resources/Public/Icons/map-pin-deepblue.svg',    'EXT:rt_simpleosm/Resources/Public/Icons/pin-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.13',  13, 'EXT:rt_simpleosm/Resources/Public/Icons/map-pin-green.svg',       'EXT:rt_simpleosm/Resources/Public/Icons/pin-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.14',  14, 'EXT:rt_simpleosm/Resources/Public/Icons/map-pin-fuchsia.svg',     'EXT:rt_simpleosm/Resources/Public/Icons/pin-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.15',  15, 'EXT:rt_simpleosm/Resources/Public/Icons/map-pin-orange.svg',      'EXT:rt_simpleosm/Resources/Public/Icons/pin-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.16',  16, 'EXT:rt_simpleosm/Resources/Public/Icons/map-pin-purple.svg',      'EXT:rt_simpleosm/Resources/Public/Icons/pin-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.17',  17, 'EXT:rt_simpleosm/Resources/Public/Icons/map-pin-red.svg',         'EXT:rt_simpleosm/Resources/Public/Icons/pin-shadow.svg'],
					['LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.markerIcon.18',  18, 'EXT:rt_simpleosm/Resources/Public/Icons/map-pin-yellow.svg',      'EXT:rt_simpleosm/Resources/Public/Icons/pin-shadow.svg']
				],
				'showIconTable' => 1,
				'fieldWizard' => [
					'selectIcons' => [
						'disabled' => 0
					]
				],
				'default' => 0
			]
		]
	];

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_address',$tempColumns);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_address','markericon;;;;1-1-1','', 'after:longitude');
}