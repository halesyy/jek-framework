<?php
  class FooterKontroller extends Kontroller {
    public function index() {
      //Lets do some interaction!

      $this->loader->entry()->Load('templates/Footer');

      $this->close_kontroller();
    }
  }
