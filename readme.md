Zip Code to Address
============

Sugar 7.5 add-on.
- Auto complete address after you input postal code field. 

![Image](/ziptoaddress.png)

Installation & Setup
============

1) install via module loader
2) Add a line on postal code field in record.php 
   If you would like to convert existing postal code fields on Accounts module to Auto Complete postal code fields,
   you will need to modify in /custom/Accounts/clients/base/layouts/record/record.php.
   

```php

                        array(
                            'name' => 'billing_address_postalcode',
                            'css_class' => 'address_zip',
                            'type' => 'zipToAddress', //add	
                            'placeholder' => 'LBL_BILLING_ADDRESS_POSTALCODE',
                        ),

```
```php

                        array(
                            'name' => 'shipping_address_postalcode',
                            'css_class' => 'address_zip',
                            'type' => 'zipToAddress', //add
                            'placeholder' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
                        ),
```
3) Quick Repaire & Rebild


LICENCE
============

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at
 
     http://www.apache.org/licenses/LICENSE-2.0
 
Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

Author: Masaki Fukumitsu SugarCRM


DATA
============
This add-on consumes data from the API 'Zippopotamus’(http://api.zippopotam.us/)
and ZipCloud(http://zipcloud.ibsnet.co.jp/)


