<?php
  /*
  | This is the config file for the way the framework can be easily
  | styled.
  */

  // For if you  want to use this file or not.
  $cfg['use-display-properties'] = false;

  // Config area for the header.
  $cfg['header'] = [
    'stylesheet'   => '/public/css/jek-core/header.css',

    'navbar-type'  => 'default',

    /*
    | ALL STYLES SHOULD BE EDITED IN /public/css/jek-core/header.css for header.
    */
    'use-sitename' => false,
    'site-name'    => 'JEK',




    // LINK CONFIG.
    'header-links' => [
      // [NAME, WHERETO, ICON LOCATION]
      // NOTE: If you set ICON LOCATION = false, no icon used.
      // NOTE: Please don't add # into the URL, as it's already pre-done.

      ['Home'     , 'home'  , false]

    ],


    'header-links-right' => [
      // [NAME, WHERETO, ICON LOCATION]
      // NOTE: If you set ICON LOCATION = false, no icon used.
      // NOTE: Please don't add # into the URL, as it's already pre-done.

      ['Login'    , 'login' , false],
      ['Register' , 'login' , false]

    ],


    'header-dropdowns' => [
      // [NAME OF DROPDOWN DISPLAY, [NAME => TO, NAME => TO]]
      // NOTE: IDK.

      ['Rank List', [
        'Ranks'                => 'ranklist/ranks',
        'Promo Tags'           => 'ranklist/promotags',
        'Prices'               => 'ranklist/prices'
      ]],

      ['Scripts', [
        'Recruit'              => 'script/recruit',
        'Advertising'          => 'script/advertising',
        'Security'             => 'script/security',
        'Trainers'             => 'script/trainers',
        'Operations+'          => 'script/operations',
        'Transfer'             => 'script/transfer'
      ]],

      ['Divisions', [
        'Applications'         => 'divisions/applications',
        'Transfer Team'        => 'divisions/transfer-team',
        'I/A'                  => 'divisions/internal-affairs',
        'E/A'                  => 'divisions/external-affairs',
        'Innovations Team'     => 'divisions/innovations-team',
        'Events Team'          => 'divisions/events-team'
      ]],

      ['About Us', [
        'Code of Conduct'      => 'about-us/coc',
        'Alliances'            => 'about-us/alliances',
        'News'                 => 'about-us/news',
        'Staff'                => 'about-us/staff',
        'National Punishment'  => 'about-us/national-punishment',
        'Pay Times'            => 'about-us/pay-times'
      ]]
    ]
  ];
