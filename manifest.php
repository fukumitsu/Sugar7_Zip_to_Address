<?php
/*
 * This file is part of the 'Zip to Address' function.
 * Copyright [2015/5/27] [Masaki Fukumitsu - SugarCRM]
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * 
 * Author: Masaki Fukumitsu SugarCRM
 */
$manifest = array (
  'acceptable_sugar_versions' => 
  array (
        'regex_matches' => array (
      0 => '7\\.2\\.2\\.(.*?)', 
      1 => '7\\.5\\.(.*?)\\.(.*?)', 
      2 => '7\\.6\\.(.*?)\\.(.*?)'
    ),
  ),
  'acceptable_sugar_flavors' => 
  array (
    0 => 'PRO',
    1 => 'ENT',
    2 => 'ULT',
  ),
  'readme' => '',
  'key' => 'ZTA',
  'author' => 'Masaki Fukumitsu',
  'description' => 'auto complete Address by Zip code',
  'icon' => '',
  'is_uninstallable' => true,
  'name' => 'Zip to Address',
  'published_date' => '2015-05-27 08:00:00',
  'type' => 'module',
  'version' => '1.0',
);
$installdefs = array (
  'id' => 'ZIPTOADDRESS201505',
    
  'copy' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/custom/clients/base/fields/zipToAddress/zipToAddress.js',
      'to' => 'custom/clients/base/fields/zipToAddress/zipToAddress.js',
    ),
    1 =>
    array (
      'from' => '<basepath>/custom/clients/base/api/zipToAddress.php',
      'to' => 'custom/clients/base/api/zipToAddress.php',
    ),
  ),
  'post_execute' => 
  array (
    0 => '<basepath>/post_install.php',
  ),
);