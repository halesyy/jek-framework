<?php
  class jTETriggers
    {
      public function trigger_import($toload)
        {
          if (in_array($toload, array_keys($this->import_keywords)))
            {
              $toload = $this->import_keywords[ $toload ];
              require_once( "app/entries/" . $toload );
              return '';
            }
          else App::Error('JTE External Importer', "Keyword unknown <b>\"$toload\"</b>, please check the jTE class variable (public \$keywords)");
        }



      public function trigger_builder()
        {
          $this->in_builder_mode = !$this->in_builder_mode;
        }
      public function trigger_build()
        {
          $this->in_builder_mode = !$this->in_builder_mode;
          $this->builder->render();
        }



      public function trigger_setter()
        {
          $this->in_setter_mode = !$this->in_setter_mode;
        }



      public function trigger_if($conditional)
        {
          if ($conditional === '')
          App::Error('JTE If starter', 'No conditional given');
          else if (!in_array( $conditional, array_keys($this->official_setter_vars) ))
          App::Error('JTE If starter', 'No official var given for the trigger <b>"'.$conditional.'"</b>');
          $this->execute_if_code = $this->official_setter_vars[$conditional];
          $this->in_if_mode = true;
        }
      public function trigger_else()
        {
          $this->execute_if_code = !$this->execute_if_code;
        }
      public function trigger_endif()
        {
          $this->in_if_mode = false;
        }



      public function trigger_killsession()
        {
          session_unset();
        }
      public function trigger_ks()
        {
          session_unset();
        }

      public $last_auto_modal_id = '#modal';
      public function trigger_auto_modal($loading)
        {
          if (!$loading) App::Error('jTE Modal Creator', 'No name for modal supplied');
          if (count(explode(':',$loading)) != 2) App::Error('jTE Modal Creator', 'No modal name given, format: <b>ID:Modal Title</b>');
          $loading = str_replace('_',' ',$loading);
          $modal_info = explode(':',$loading);
          $this->last_auto_modal_id = $modal_info[0];
          echo "<div class='modal fade' id='{$modal_info[0]}' tabindex='-1' role='dialog'>";
          echo "<div class='modal-dialog' role='document'>";
          echo "<div class='modal-content'>";
          echo "<div class='modal-header'>";
            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
              echo "<span aria-hidden='true'>&times;</span>";
            echo "</button>";
            echo "<h3 class='modal-title'>{$modal_info[1]}</h3>";
          echo "</div>";
          echo "<div class='modal-body'>";
        }
      public function trigger_end_auto_modal($loading)
        {
          echo "</div>"; // End of modal body.
          //footer man.
          if ($loading !== false && $loading == 'none')
            { /*user wants nothing*/ }
          else if ($loading === false)
            {
              echo "<div class='modal-footer'>";
              echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
              echo "<button type='button' class='btn btn-primary'>Save changes</button>";
              echo "</div>";
            }
          else
            {
              echo "<div class='modal-footer'>";
              //treating like specify buttons.
              foreach (explode(',',$loading) as $buttontype)
                {
                  $buttontype = trim($buttontype);
                  if ($buttontype == 'close')
                  echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
                  //other buttons can go here.
                }
              echo "</div>";
            }
          //end of footer man.
          echo "</div>"; // End of modal content.
          echo "</div>"; // End of modal dialog.
          echo "</div>"; // End of modal.

          //writing the autoloader code so the modal is automatically opened.
          echo "<script>$('#{$this->last_auto_modal_id}').modal('show');</script>";
        }



      public function trigger_modal($loading)
        {
          if (!$loading) App::Error('jTE Modal Creator', 'No name for modal supplied');
          if (count(explode(':',$loading)) != 2) App::Error('jTE Modal Creator', 'No modal name given, format: <b>ID:Modal Title</b>');
          $loading = str_replace('_',' ',$loading);
          $modal_info = explode(':',$loading);
          echo "<div class='modal fade' id='{$modal_info[0]}' tabindex='-1' role='dialog'>";
          echo "<div class='modal-dialog' role='document'>";
          echo "<div class='modal-content'>";
          echo "<div class='modal-header'>";
            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
              echo "<span aria-hidden='true'>&times;</span>";
            echo "</button>";
            echo "<h3 class='modal-title'>{$modal_info[1]}</h3>";
          echo "</div>";
          echo "<div class='modal-body'>";
        }



      public function trigger_endmodal($loading)
        {
          echo "</div>"; // End of modal body.
          //footer man.
          if ($loading !== false && $loading == 'none')
            { /*user wants nothing*/ }
          else if ($loading === false)
            {
              echo "<div class='modal-footer'>";
              echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
              echo "<button type='button' class='btn btn-primary'>Save changes</button>";
              echo "</div>";
            }
          else
            {
              echo "<div class='modal-footer'>";
              //treating like specify buttons.
              foreach (explode(',',$loading) as $buttontype)
                {
                  $buttontype = trim($buttontype);
                  if ($buttontype == 'close')
                  echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
                  //other buttons can go here.
                }
              echo "</div>";
            }
          //end of footer man.
          echo "</div>"; // End of modal content.
          echo "</div>"; // End of modal dialog.
          echo "</div>"; // End of modal.
        }



      public function trigger_trigger($loading)
        {
          if (!$loading) App::Error('jTE Modal Creator', 'No name for modal trigger');
          if (count(explode(':',$loading)) != 2) App::Error('jTE Modal Creator', 'No modal name given, format: <b>ModalID:Trigger Title</b>');
          $loading = str_replace('_',' ',$loading);
          $trigger_info = explode(':',$loading);

          echo "<a style='cursor: pointer;' data-toggle='modal' data-target='#{$trigger_info[0]}'>";
            echo $trigger_info[1];
          echo "</a>";
        }
      public function trigger_closer($closer_name)
        {
          $closer_name = str_replace('_',' ',$closer_name);
          echo " <a data-dismiss='modal' style='cursor:pointer;'>{$closer_name}</a> ";
        }



      public function trigger_col($definitions)
        {
          $defs = explode(',',$definitions);
          $runs = ['lg','md','sm','xs'];
          echo "<div class='";
          foreach ($defs as $index => $toload_def)
            {
              $size = $runs[$index];
              if ($toload_def == '+') { echo "visible-{$size} "; }
              else if ($toload_def == '-') echo "hidden-{$size} ";
              else
                {
                  echo "col-{$size}-{$toload_def} ";
                }
            }
          echo '\'>';
        }
      public function trigger_endcol()
        {
          echo "</div>";
        }
      public function trigger_row()
        {
          echo "<div class='row'>";
        }
      public function trigger_endrow()
        {
          echo "</div>";
        }



      public function trigger_fold_header_up()
        {
          echo "<script async>window.jek.fold_header_up();</script>";
        }
      public function trigger_fold_footer_up()
        {
          echo "<script async>window.jek.fold_footer_up();</script>";
        }
      public function trigger_small_header()
        {
          echo "<script async>window.jek.small_header();</script>";
        }



      public function trigger_g($glyphicon_name)
        {
          echo "<span class='glyphicon glyphicon-{$glyphicon_name}'></span>";
        }



      public function trigger_options($option_set)
        {
          if ($option_set == 'countries' || $option_set == 'country')
            {
              $countries = [
                'AF' => 'Afghanistan', 'AX' => 'Aland Islands', 'AL' => 'Albania', 'DZ' => 'Algeria', 'AS' => 'American Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AI' => 'Anguilla', 'AQ' => 'Antarctica', 'AG' => 'Antigua And Barbuda', 'AR' => 'Argentina', 'AM' => 'Armenia', 'AW' => 'Aruba', 'AU' => 'Australia', 'AT' => 'Austria', 'AZ' => 'Azerbaijan', 'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' => 'Bangladesh', 'BB' => 'Barbados', 'BY' => 'Belarus', 'BE' => 'Belgium', 'BZ' => 'Belize', 'BJ' => 'Benin', 'BM' => 'Bermuda', 'BT' => 'Bhutan', 'BO' => 'Bolivia', 'BA' => 'Bosnia And Herzegovina', 'BW' => 'Botswana', 'BV' => 'Bouvet Island', 'BR' => 'Brazil', 'IO' => 'British Indian Ocean Territory', 'BN' => 'Brunei Darussalam', 'BG' => 'Bulgaria', 'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'KH' => 'Cambodia', 'CM' => 'Cameroon', 'CA' => 'Canada', 'CV' => 'Cape Verde', 'KY' => 'Cayman Islands', 'CF' => 'Central African Republic', 'TD' => 'Chad', 'CL' => 'Chile', 'CN' => 'China', 'CX' => 'Christmas Island', 'CC' => 'Cocos (Keeling) Islands', 'CO' => 'Colombia', 'KM' => 'Comoros', 'CG' => 'Congo', 'CD' => 'Congo, Democratic Republic', 'CK' => 'Cook Islands', 'CR' => 'Costa Rica', 'CI' => 'Cote D\'Ivoire', 'HR' => 'Croatia', 'CU' => 'Cuba', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'DK' => 'Denmark', 'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'GQ' => 'Equatorial Guinea', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'ET' => 'Ethiopia', 'FK' => 'Falkland Islands (Malvinas)', 'FO' => 'Faroe Islands', 'FJ' => 'Fiji', 'FI' => 'Finland', 'FR' => 'France', 'GF' => 'French Guiana', 'PF' => 'French Polynesia', 'TF' => 'French Southern Territories', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germany', 'GH' => 'Ghana', 'GI' => 'Gibraltar', 'GR' => 'Greece', 'GL' => 'Greenland', 'GD' => 'Grenada', 'GP' => 'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GG' => 'Guernsey', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HT' => 'Haiti', 'HM' => 'Heard Island & Mcdonald Islands', 'VA' => 'Holy See (Vatican City State)', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hungary', 'IS' => 'Iceland', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran, Islamic Republic Of', 'IQ' => 'Iraq', 'IE' => 'Ireland', 'IM' => 'Isle Of Man', 'IL' => 'Israel', 'IT' => 'Italy', 'JM' => 'Jamaica', 'JP' => 'Japan', 'JE' => 'Jersey', 'JO' => 'Jordan', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KR' => 'Korea', 'KW' => 'Kuwait', 'KG' => 'Kyrgyzstan', 'LA' => 'Lao People\'s Democratic Republic', 'LV' => 'Latvia', 'LB' => 'Lebanon', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libyan Arab Jamahiriya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania', 'LU' => 'Luxembourg', 'MO' => 'Macao', 'MK' => 'Macedonia', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MY' => 'Malaysia', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshall Islands', 'MQ' => 'Martinique', 'MR' => 'Mauritania', 'MU' => 'Mauritius', 'YT' => 'Mayotte', 'MX' => 'Mexico', 'FM' => 'Micronesia, Federated States Of', 'MD' => 'Moldova', 'MC' => 'Monaco', 'MN' => 'Mongolia', 'ME' => 'Montenegro', 'MS' => 'Montserrat', 'MA' => 'Morocco', 'MZ' => 'Mozambique', 'MM' => 'Myanmar', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Netherlands', 'AN' => 'Netherlands Antilles', 'NC' => 'New Caledonia', 'NZ' => 'New Zealand', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'NU' => 'Niue', 'NF' => 'Norfolk Island', 'MP' => 'Northern Mariana Islands', 'NO' => 'Norway', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PS' => 'Palestinian Territory, Occupied', 'PA' => 'Panama', 'PG' => 'Papua New Guinea', 'PY' => 'Paraguay', 'PE' => 'Peru', 'PH' => 'Philippines', 'PN' => 'Pitcairn', 'PL' => 'Poland', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'RE' => 'Reunion', 'RO' => 'Romania', 'RU' => 'Russian Federation', 'RW' => 'Rwanda', 'BL' => 'Saint Barthelemy', 'SH' => 'Saint Helena', 'KN' => 'Saint Kitts And Nevis', 'LC' => 'Saint Lucia', 'MF' => 'Saint Martin', 'PM' => 'Saint Pierre And Miquelon', 'VC' => 'Saint Vincent And Grenadines', 'WS' => 'Samoa', 'SM' => 'San Marino', 'ST' => 'Sao Tome And Principe', 'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SK' => 'Slovakia', 'SI' => 'Slovenia', 'SB' => 'Solomon Islands', 'SO' => 'Somalia', 'ZA' => 'South Africa', 'GS' => 'South Georgia And Sandwich Isl.', 'ES' => 'Spain', 'LK' => 'Sri Lanka', 'SD' => 'Sudan', 'SR' => 'Suriname', 'SJ' => 'Svalbard And Jan Mayen', 'SZ' => 'Swaziland', 'SE' => 'Sweden', 'CH' => 'Switzerland', 'SY' => 'Syrian Arab Republic', 'TW' => 'Taiwan', 'TJ' => 'Tajikistan', 'TZ' => 'Tanzania', 'TH' => 'Thailand', 'TL' => 'Timor-Leste', 'TG' => 'Togo', 'TK' => 'Tokelau', 'TO' => 'Tonga', 'TT' => 'Trinidad And Tobago', 'TN' => 'Tunisia', 'TR' => 'Turkey', 'TM' => 'Turkmenistan', 'TC' => 'Turks And Caicos Islands', 'TV' => 'Tuvalu', 'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates', 'GB' => 'United Kingdom', 'US' => 'United States', 'UM' => 'United States Outlying Islands', 'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VE' => 'Venezuela', 'VN' => 'Viet Nam', 'VG' => 'Virgin Islands, British', 'VI' => 'Virgin Islands, U.S.', 'WF' => 'Wallis And Futuna', 'EH' => 'Western Sahara', 'YE' => 'Yemen', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe'
              ];
              foreach ($countries as $countrycode => $countryname)
              echo "<option value='{$countrycode}'>{$countryname}</option>";
            }
        }



      public function trigger_container()
        {
          echo "<div class='container'>";
        }
      public function trigger_endcontainer()
        {
          echo "</div>";
        }
      public function trigger_half()
        {
          echo "<div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>";
        }
      public function trigger_endhalf()
        {
          echo "</div>";
        }
    }
