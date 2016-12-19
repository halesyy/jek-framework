<?php
  class HomeKontroller extends Kontroller {
    public function options()
      {
        $this->RunHeaderFooter = false;
      }

    public function index() {
      //Loader for the home page.

      $this->c->entry()->load('main/Home');
    }
  }
