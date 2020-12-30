<?php
declare(strict_types = 1);
namespace SYRADEV\RtSimpleosm\FormElements;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
/***
 *
 * This file is part of the "Simple OpenStreetMap" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Regis TEDONE <regis.tedone@gmail.com>, SYRADEV
 *
 ***/
class RtCopyrigthsLogo extends AbstractFormElement {


	public function render() {
		$formField = '<div class="callout callout-warning">';
		$formField .= '<div class="media"><div class="media-left"><img src="/typo3conf/ext/rt_simpleosm/Resources/Public/syradev.png" alt="SYRADEV"></div>';
		$formField .= '<div class="media-body"><h4 class="callout-title">';
		$formField .= \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_be.xlf:about.SYRADEV.title', 'rt_simpleosm' );
		$formField .= '</h4><div class="callout-body">';
		$formField .= \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_be.xlf:about.SYRADEV.text', 'rt_simpleosm' );
		$formField .= '</div></div></div></div>';

        $result = $this->initializeResultArray();
        $result['html'] = $formField;
        return $result;
	}
}