<?php
  /*
  | Config related to building the header for the site.
  | The header is mainly the dispaly image and some other components.
  | Links, Dropdowns, Brand name, etc...
  */

  $c['hd']['header_image'] = 'http://www.freewebheaders.com/wordpress/wp-content/gallery/forests-fields/green-forest-and-clouds-website-header.jpg';

  $c['hd']['site_logo_name'] = 'JekF';

  $c['hd']['triggerable'] = [
    ['link_farleft', ['Login', 'login']],
    ['dropdown', [
      'Zoe',
      'Sami'      => 'sami',
      'seperator' => true,
      'Jek'       => 'jek'
    ]],
    ['link', ['Kys', 'XD']]
  ];
