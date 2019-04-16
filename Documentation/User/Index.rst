.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _user-manual:

Users Manual
============

Target group: **Editors**

To display an OpenStreetMap on your page, you have to follow 2 steps:

- **Create a database OSM record for the map with List module**:

you will have to enter for one map

    - The title,
    - The address,
    - The latitude,
    - The longitude,
    - A custom marker.

.. tip::

To find the longitude and the latitude from an adress you can use this site :

`latlong.net <https://www.latlong.net/>`_

You don't really need to create a Folder page for this. You can store this record in any standard page.



.. figure:: ../Images/UserManual/be_insert_map_record.png
   :width: 297px
   :alt: Insert an OSM record

   Inserting a new OSM record.


.. figure:: ../Images/UserManual/be_enter_map_infos.png
   :width: 711px
   :alt: Configure an OSM record

   Configuring an OSM record.



- **Insert the simple OpenStreetMap plugin with Page module**:

you will have to configure the desired map by specifing:

    - A header for the plugin,
    - The OSM record or tt_address record for the desired map,
    - The map style, width, height and border radius,
    - The map zoom factor,
    - The map popup options,
    - The map zoom, mouse and fullscreen options,
    - The navigational mini map display,
    - The external caption menu display.


.. figure:: ../Images/UserManual/be_insert_plugin.png
   :width: 819px
   :alt: Insert an OSM plugin

   Inserting an OSM plugin.



.. figure:: ../Images/UserManual/be_select_map.png
   :width: 552px
   :alt: Select a map record

   OSM plugin: selecting an Osm record or a tt_address record.



.. figure:: ../Images/UserManual/be_select_style.png
   :width: 712px
   :alt: Select a map style, width, height and border radius

   OSM plugin: selecting a map style, width, height and border radius.



.. figure:: ../Images/UserManual/be_other_options.png
   :width: 684px
   :alt: Configure map options

   OSM plugin: Configuring map options.



.. figure:: ../Images/UserManual/be_plugin.png
   :width: 497px
   :alt: OSM Plugin appearance in Page module

   OSM plugin: Appearance in Page module.



.. figure:: ../Images/UserManual/fe_caption_menu.png
   :width: 838px
   :alt: OSM Plugin rendering with navigational mini map and external caption menu

   OSM plugin: Rendering with navigational mini map and external caption menu.



.. figure:: ../Images/UserManual/fe_bandw.png
   :width: 815px
   :alt: OSM Plugin rendering with black and white provider

   OSM plugin: Frontend rendering with black and white provider.



.. figure:: ../Images/UserManual/fe_watercolor.png
   :width: 815px
   :alt: OSM Plugin rendering with Stamen Design watercolor provider

   OSM plugin: Frontend rendering with Stamen Design watercolor provider.



.. figure:: ../Images/UserManual/fe_esri_imagery.png
   :width: 945px
   :alt: OSM Plugin rendering with ESRI Imagery + Stamen labels provider

   OSM plugin: Frontend rendering with ESRI Imagery + Stamen labels provider.



.. figure:: ../Images/UserManual/fe_terrain.png
   :width: 815px
   :alt: OSM Plugin rendering with Stamen Design terrain provider

   OSM plugin: Frontend rendering with Stamen Design terrain provider.



.. figure:: ../Images/UserManual/fe_mtb_map.png
   :width: 815px
   :alt: OSM Plugin rendering with MTB map (Europe only) provider

   OSM plugin: Frontend rendering with MTB map (Europe only) provider.