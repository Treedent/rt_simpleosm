<?php

namespace CMSPACA\RtSimpleosm\Userfuncs;

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


class Tca {
	public function helperField($PA) {
		$color = (isset($PA['parameters']['color'])) ? $PA['parameters']['color'] : '#9ed284';
		$label =  \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_be.xlf:simpleosm.message.getLatLong.text','rt_simpleosm');
		$formField  = '<div style="padding: 15px; background-color: ' . $color . ';">';
		$formField .= '<h4><a href="https://www.latlong.net/" onclick="if(this.blur)this.blur();" target="_blank">'.$label.'</a></h4>';
		$formField .= '</div>';
		return $formField;
	}

	public function aboutField() {
		
		$formField  = '<div class="callout callout-warning">';
		$formField  .= '<div class="media"><div class="media-left"><img src="/typo3conf/ext/rt_simpleosm/Resources/Public/cms-paca.png" alt="CMS-PACA"></div>';
		$formField  .= '<div class="media-body"><h4 class="callout-title">';
		$formField  .= \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_be.xlf:about.CMSPACA.title','rt_simpleosm');
		$formField  .= '</h4><div class="callout-body">';
		$formField .= \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_be.xlf:about.CMSPACA.text','rt_simpleosm');
		$formField .= '</div></div></div></div>';
		
		return $formField;
	}

}