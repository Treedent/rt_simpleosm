<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rtsimpleosm_domain_model_osm',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title,address,latitude,longitude',
        'iconfile' => 'EXT:rt_simpleosm/Resources/Public/Icons/tx_rtsimpleosm_domain_model_osm.png'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, address, latitude, longitude, markericon',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, address, helper, latitude, longitude, markericon, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_rtsimpleosm_domain_model_osm',
                'foreign_table_where' => 'AND tx_rtsimpleosm_domain_model_osm.pid=###CURRENT_PID### AND tx_rtsimpleosm_domain_model_osm.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
            ],
        ],

        'title' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rtsimpleosm_domain_model_osm.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'address' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rtsimpleosm_domain_model_osm.address',
            'config' => [
                'type' => 'text',
                'cols' => 20,
                'rows' => 8,
                'eval' => 'trim'
            ]
        ],
        'helper' => [
	        'label' => 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_be.xlf:simpleosm.message.getLatLong.title',
	        'config' => [
		        'type' => 'user',
                'renderType' => 'rtGPSCoordinates',
		        'parameters' => [
			        'color' => '#9ed284'
		        ]
	        ]
        ],
        'latitude' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rtsimpleosm_domain_model_osm.latitude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'longitude' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rtsimpleosm_domain_model_osm.longitude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
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
    ],
];
