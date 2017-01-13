<?php
  class HeaderKontroller extends Kontroller {

    public function index() {
      $this->loader->entry->JTE('main/static/Header');
    }

  }
