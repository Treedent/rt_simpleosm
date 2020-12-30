<?php
defined('TYPO3_MODE') || die();

// Register plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'SYRADEV.RtSimpleosm',
	'Sosm',
	'Simple OSM'
);

$pluginSignature = str_replace( '_', '', 'rt_simpleosm' ) . '_sosm';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][ $pluginSignature ] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][ $pluginSignature ] = 'pi_flexform';

$flexformXml = isset($GLOBALS['TYPO3_LOADED_EXT']['tt_address']) ? 'FILE:EXT:rt_simpleosm/Configuration/FlexForms/flexform_simpleosm_tt_address.xml' : 'FILE:EXT:rt_simpleosm/Configuration/FlexForms/flexform_simpleosm.xml';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue( $pluginSignature, $flexformXml );
