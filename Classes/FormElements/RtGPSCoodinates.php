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
class RtGPSCoodinates extends AbstractFormElement {

	public function render() {
        $color     = ( isset( $this->data['parameterArray']['fieldConf']['config']['parameters']['color'] ) ) ? $this->data['parameterArray']['fieldConf']['config']['parameters']['color'] : '#9ed284';
        $label1     = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_be.xlf:simpleosm.message.getLatLong.text', 'rt_simpleosm' );
        $label2     = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'LLL:EXT:rt_simpleosm/Resources/Private/Language/locallang_be.xlf:simpleosm.message.getLatLong2.text', 'rt_simpleosm' );
        $formField = '<div style="padding: 15px; background-color: ' . $color . ';">';
        $formField .= '<h4><a href="https://www.latlong.net/" onclick="if(this.blur)this.blur();" target="_blank">' . $label1 . '</a></h4>';
        $formField .= '<h4><a href="https://www.gps-coordinates.net/" onclick="if(this.blur)this.blur();" target="_blank">' . $label2 . '</a></h4>';
        $formField .= '</div>';

        $result = $this->initializeResultArray();
        $result['html'] = $formField;
        return $result;
	}
}