<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function() {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'CMSPACA.RtSimpleosm',
            'Sosm',
            [
                'Osm' => 'displayMap'
            ],
            // non-cacheable actions
            [
                'Osm' => ''
            ]
        );

	    // wizards
	    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
	        'mod {
	            wizards.newContentElement.wizardItems.plugins {
	                elements {
	                    sosm {
	                        iconIdentifier = rt_simpleosm-plugin-sosm
	                        title = LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.name
	                        description = LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_db.xlf:tx_rt_simpleosm_sosm.description
	                        tt_content_defValues {
	                            CType = list
	                            list_type = rtsimpleosm_sosm
	                        }
	                    }
	                }
	                show = *
	            }
	       }'
	    );

		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		
		$iconRegistry->registerIcon(
			'rt_simpleosm-plugin-sosm',
			\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
			['source' => 'EXT:rt_simpleosm/Resources/Public/Icons/user_plugin_sosm.svg']
		);

		// Page module hook for backend plugin display
	    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['Rtsimpleosm'] = 'CMSPACA\RtSimpleosm\Hooks\PageLayoutViewDrawItemHook';
    }
);
