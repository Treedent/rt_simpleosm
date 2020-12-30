<?php

namespace SYRADEV\RtSimpleosm\Domain\Model;

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

use \TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Osm
 */
class Osm extends AbstractEntity {
	/**
	 * Map title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * Map latitude
	 *
	 * @var string
	 */
	protected $latitude = '';

	/**
	 * Map longitude
	 *
	 * @var string
	 */
	protected $longitude = '';

	/**
	 * Marker address
	 *
	 * @var string
	 */
	protected $address = '';

	/**
	 * Marker icon
	 *
	 * @var integer
	 */
	protected $markericon = 0;

	/**
	 * Map Marker Unic Id
	 *
	 * @var string
	 */
	 protected $mapmarkeruid = '';

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 *
	 * @return void
	 */
	public function setTitle( $title ) {
		$this->title = $title;
	}

	/**
	 * Returns the latitude
	 *
	 * @return string $latitude
	 */
	public function getLatitude() {
		return $this->latitude;
	}

	/**
	 * Sets the latitude
	 *
	 * @param string $latitude
	 *
	 * @return void
	 */
	public function setLatitude( $latitude ) {
		$this->latitude = $latitude;
	}

	/**
	 * Returns the longitude
	 *
	 * @return string $longitude
	 */
	public function getLongitude() {
		return $this->longitude;
	}

	/**
	 * Sets the longitude
	 *
	 * @param string $longitude
	 *
	 * @return void
	 */
	public function setLongitude( $longitude ) {
		$this->longitude = $longitude;
	}

	/**
	 * Returns the address
	 *
	 * @return string $address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Sets the address
	 *
	 * @param string $address
	 *
	 * @return void
	 */
	public function setAddress( $address ) {
		$this->address = $address;
	}

	/**
	 * Sets the uid
	 *
	 * @param int $uid
	 *
	 * @return void
	 */
	public function setUid( $uid ) {
		$this->uid = $uid;
	}
	
	/**
	 * Returns the marker icon
	 *
	 * @return integer $markericon
	 */
	public function getMarkericon() {
		return $this->markericon;
	}

	/**
	 * Sets the marker icon
	 *
	 * @param integer $markericon
	 *
	 * @return void
	 */
	public function setMarkericon( $markericon ) {
		$this->markericon = $markericon;
	}

	/**
	 * Returns the map marker unic id
	 *
	 * @return string $mapmarkeruid
	 */
	public function getMapmarkeruid() {
		return $this->mapmarkeruid;
	}

	/**
	 * Sets the map marker unic id
	 *
	 * @param string $mapmarkeruid
	 *
	 * @return void
	 */
	public function setMapmarkeruid( $mapmarkeruid ) {
		$this->mapmarkeruid = $mapmarkeruid;
	}
}