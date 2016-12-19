<?php
  class HeaderKontroller extends Kontroller {
    public function index() {
      //Lets do some interaction!

      require App::LoadConfig('display');
      if ($cfg['use-display-properties'])
        {
          // User wants to use display properties.
          App::TEMPCSS($cfg['header']['stylesheet']);
          App::TEMPCSS('/public/css/jek-core/content.css');

          // App::TEMPJS('/public/bootstrap/js/bootstrap.min.js');
          // App::TEMPCSS('/public/bootstrap/css/bootstrap-theme.min.css');
          // App::TEMPCSS('/public/bootstrap/css/bootstrap.min.css');

          $this->c->entry()->Load('templates/DP_Header', $cfg['header']);
        }
      else
        {
          // User doesnt want to use special properties, use normal.
          $this->c->entry()->Load('templates/Header');
        }


      $this->close_kontroller();
    }
  }
