<?php
  class HeaderKontroller extends Kontroller {
    /*
    | The Header Kontroller takes the configuration file from
    | config.header_display and manages all the data there,
    | creating HTML to display as well as dropdowns, etc...
    */



    public function index() {
      require_once App::ConfigGet('header_display');
      $links = $this->manage_triggerable_data( $c['hd']['triggerable'] );

      $this->loader->entry->render('main/static/Header', [
        'header_image'   => $c['hd']['header_image'],
        'site_logo_name' => $c['hd']['site_logo_name'],
        'triggerable'    => $links
      ]);
    }



    public function manage_triggerable_data($link_array) {
      $links = '';
      foreach ($link_array as $index => $def_array)
        {
          $type = $def_array[0];
          if (method_exists($this, $type)) $links .= $this->$type($def_array[1]);
        }
      return $links;
    }



    public function link($array) {
      return "<li><a class='navbar-link' href='#!/{$array[1]}'>{$array[0]}</a></li>";
    }
    public function link_farleft($array) {
      return "<li><a class='navbar-link farleft-link' href='#!/{$array[1]}'>{$array[0]}</a></li>";
    }



    public function dropdown($array) {
      $constructor = '';
      $constructor .= '<li class="dropdown">';
      $constructor .= '<a class="dropdown-link" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.
        $array[0]
      .' <span class="caret"></span></a>';
      $constructor .= '<ul class="dropdown-menu">';

        foreach ($array as $display => $to)
        if (is_numeric($display)) continue;
        else if ($display == 'seperator') $constructor .= '<li role="separator" class="divider"></li>';
        else $constructor .= "<li><a href='#!/{$to}'>{$display}</a></li>";

      $constructor .= '</li>';
      $constructor .= '</ul>';
      return $constructor;
    }







    //
  }
