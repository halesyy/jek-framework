<?php
  class Url {
    /*
      This is a class that manages the URL in PHP, meaning you can use slugs.
        Example: If the URL is "site.com/im/a/slow/slug," and you want to get
                 "im," that's referenced as the "first slug," and you can get
                 that by calling Url::Segment(1), or Url::First().
      It helps you manage the slugs in a nice, clean way!
    */

    //*************************************************************************

    /*
      Class Variables.
    */
    static $site_path    = '/';

    public function __construct()
      {
        $this->site_path = $_SERVER['REQUEST_URI'];
      }
    function __toString()
      {
        return self::$site_path;
      }
    /*Removes the slash from a sting at the of string.
    Used: URL = /asd/asd/ CONVERTS_TO /asd/asd.*/
      private static function remove_slash($string)
        {
          if ($string[strlen($string) - 1] == '/')
            $string = rtrim($string, '/');
          return $string;
        }
    /*Main function for slugs, gets the wanted segment.*/
      public static function segment($segment)
        {
          $segments = explode( '/', $_SERVER['REQUEST_URI'] );
          if ( isset($segments[$segment]) && !empty($segments[$segment]) )
            return $segments[$segment];
          else return false;
        }
    /*Same as the Segment method but instead -- Returns what you ask it to if it's false.*/
      public static function indexsegment($segment, $return = 'index')
        {
          if ( self::segment($segment) !== false ) return urldecode( self::segment($segment) );
            else return $return;
        }
    /*Returns array of all segments.*/
      public static function segments()
        {
          $s = explode( '/', $_SERVER['REQUEST_URI'] );
          if ( empty($s[1]) ) $s[1] = 'index';
          return $s;
        }
      public static function allsegments() { return self::getallsegments(); }
    /*Functions for quick access to specific segments.*/
      public static function first()
        {  return self::IndexSegment(1); }
      public static function second()
        {  return self::IndexSegment(2);  }
      public static function third()
        {  return self::IndexSegment(3);  }
      public static function fourth()
        {  return self::IndexSegment(4);  }
      public static function fifth()
        {  return self::IndexSegment(5);  }
      public static function sixth()
        {  return self::IndexSegment(6);  }
      public static function seventh()
        {  return self::IndexSegment(7);  }

    /*Parses a url string if wanted to be a normal GET request string.*/
      public static function urlparse($url = false)
        {
          if (!$url) $url = $_SERVER['REQUEST_URI'];
            $toparse = explode('?', $url)[1];
            parse_str($toparse, $opt);
          return $opt;
        }
    /*Gets the opposite of the parsed string, e.g. /slug2=something?blah=asd
    Function returns the "slugs" part, so you use the function like:
    $Seg = Url::SlugOfUnparsed( Url::Segment(2) ) -- Returns the slug.*/
      public static function slugofunparsed($segment_data)
        {
            return explode('?', $segment_data) [0];
        }
    /*Function just meant to help with returning an array of paramaters after a certain slug index.*/
      public static function getsegmentsfrom($num)
        {
          $return_array = [];
          foreach (self::Segments() as $index => $slug)
            if ($index > $num) array_push( $return_array, urldecode($slug) );
          return $return_array;
        }

    /*Removes any accents from the string, then can be used for a slug.*/
    public static function remove_accents($ipt) {
      $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
      $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
      return str_replace($a, $b, $ipt);
    }

    /*Makes the string safe, if you want that extra security above the "remove_accents" function.*/
    public static function to_safe_slug($str) {
      return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'),
      array('', '-', ''), $this->remove_accent($str)));
    }
  }
