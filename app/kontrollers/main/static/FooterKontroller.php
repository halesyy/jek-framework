<?php
  class FooterKontroller extends Kontroller {

    public function index() {
      $this->loader->entry->render('main/static/Footer', [

      ]);
    }

  }
