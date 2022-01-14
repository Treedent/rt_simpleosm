<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function() {

        // configure plugin
        $typo3Version = TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionStringToArray(TYPO3\CMS\Core\Utility\VersionNumberUtility::getNumericTypo3Version());
        $controllerName = $typo3Version['version_main'] >= 10 ? \SYRADEV\RtSimpleosm\Controller\OsmController::class : 'Osm';
        $extensionName = $typo3Version['version_main'] >= 10 ? 'RtSimpleosm' : 'SYRADEV.RtSimpleosm';
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extensionName,
            'Sosm',
            [
                $controllerName => 'displayMap'
            ],
            // non-cacheable actions
            [
                $controllerName => ''
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
	    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['Rtsimpleosm'] = 'SYRADEV\RtSimpleosm\Hooks\PageLayoutViewDrawItemHook';

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry']['1609276343'] = [
            'nodeName' => 'rtGPSCoordinates',
            'priority' => 40,
            'class' => \SYRADEV\RtSimpleosm\FormElements\RtGPSCoodinates::class
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry']['1609276344'] = [
            'nodeName' => 'rtCopyrigthsLogo',
            'priority' => 40,
            'class' => \SYRADEV\RtSimpleosm\FormElements\RtCopyrigthsLogo::class
        ];
    }
);
