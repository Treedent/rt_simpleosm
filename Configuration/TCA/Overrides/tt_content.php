<?php
defined('TYPO3_MODE') || die();

// Register plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'CMSPACA.RtSimpleosm',
	'Sosm',
	'Simple OSM'
);

$pluginSignature = str_replace( '_', '', 'rt_simpleosm' ) . '_sosm';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][ $pluginSignature ] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][ $pluginSignature ] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue( $pluginSignature, 'FILE:EXT:rt_simpleosm/Configuration/FlexForms/flexform_simpleosm.xml');
