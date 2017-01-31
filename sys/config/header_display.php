<?php
  /*
  | Config related to building the header for the site.
  | The header is mainly the dispaly image and some other components.
  | Links, Dropdowns, Brand name, etc...
  */

  $c['hd']['header_image'] = '/public/images/headers/1.png';

  $c['hd']['site_logo_name'] = 'JekF';

  $c['hd']['triggerable'] = [
    ['link', ['Login', 'login']],
    ['dropdown', [
      'Zoe',
      'Sami'      => 'sami',
      'seperator' => true,
      'Jek'       => 'jek'
    ]],
    ['link', ['Kys', 'XD']]
  ];
