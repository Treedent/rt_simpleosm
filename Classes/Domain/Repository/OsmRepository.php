<?php

namespace SYRADEV\RtSimpleosm\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use SYRADEV\RtSimpleosm\Domain\Model\Osm;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Regis TEDONE <regis.tedone@gmail.com>, SYRADEV
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * The repository for OpenStreetMaps
 */
class OsmRepository extends Repository {

	/**
	 * The table containing Addresses
	 *
	 * @var $ttAddress_table
	 */
	protected $ttAddress_table = 'tt_address';

	/**
	 * function find by tt_address Uid
	 * @var array $ttAddressUids
	 * @return array $OsmTtAddresses
	 */
	public function findByTtAddressUid($ttAddressUids) {
		
		$selectedTtAddressMarkers = [];

		if ( version_compare( TYPO3_version, '8.0', '<' ) ) {
			// Database connection
			global $TYPO3_DB;
			$fields       = "`uid`,``name`,`latitude`,`longitude`,`address`,`zip`,`city`,`country`,`markericon`";
			$where_clause = "`uid` IN (" . join( ', ', $ttAddressUids ) . ")";
			$selectedTtAddressMarkers  = $TYPO3_DB->exec_SELECTgetRows( $fields, $this->ttAddress_table, $where_clause );
		} elseif ( version_compare( TYPO3_version, '8.0', '>=' ) ) {
			// Database connection
			$connectionPool   = GeneralUtility::makeInstance( \TYPO3\CMS\Core\Database\ConnectionPool::class );
			$ttAddressQueryBuilder = $connectionPool->getQueryBuilderForTable( $this->ttAddress_table );
			// Get OSM infos
			$selectedTtAddressMarkers = $ttAddressQueryBuilder
				->select( 'uid', 'name', 'latitude', 'longitude', 'address', 'zip','city','country','markericon' )
				->from( $this->ttAddress_table )
				->where(
					$ttAddressQueryBuilder->expr()->in( 'uid', $ttAddressQueryBuilder->createNamedParameter( $ttAddressUids, \TYPO3\CMS\Core\Database\Connection::PARAM_INT_ARRAY ) )
				)
				->execute()
				->fetchAll();
		}

		// Convert tt_address to OSM
		$OsmTtAddresses = [];
		foreach($selectedTtAddressMarkers as $TtAddressMarker) {
			$Osm = GeneralUtility::makeInstance( Osm::class );
			$Osm->setUid($TtAddressMarker['uid']);
			$Osm->setTitle($TtAddressMarker['name']);
			$Osm->setLatitude($TtAddressMarker['latitude']);
			$Osm->setLongitude($TtAddressMarker['longitude']);
			$Osm->setMarkericon($TtAddressMarker['markericon']);
			$address = [$TtAddressMarker['address'], $TtAddressMarker['zip'] . ' ' . $TtAddressMarker['city'], $TtAddressMarker['country']];
			$address = array_filter($address, function($a) {return $a !== "";});
			$Osm->setAddress( implode("\n", $address) );
            array_push($OsmTtAddresses, $Osm);
		}
		return $OsmTtAddresses;
	}

	/**
	 * function set Map Markers Unic Ids
	 * @var array $markers
	 * @var integer $cUid
	 * @var string $mapRecords
	 * @return array $markers
	 */
	public function setMapMarkersUids( $markers, $cUid) {
		foreach($markers as $i=>$marker) {
			$markers[$i]->setMapmarkeruid('mapMarker-' . $cUid . '-' . $i);
		}
		return $markers;
	}
}