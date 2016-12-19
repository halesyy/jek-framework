<?php
  class SuperCrypt
    {
      public function Ghost($str)
        {
          $return = [];

          foreach ( str_split($str) as $character )
            {
              $chr_base = ord( $character ) * 10257 + ord( $character ) + (12 * 290158);
              $chr_base = $chr_base * $chr_base;
              $chr_base = $chr_base + 12 * ord( $character ) * 90;

              array_push($return, $chr_base);
            }

          return implode('',$return);
        }
    }
