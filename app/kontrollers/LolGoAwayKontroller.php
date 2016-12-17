<?php
  class LolGoAwayKontroller extends Kontroller {
    public function index() {
      //Lets do some interaction!

      $this->c->entry()->load('lolkillme');
    }
  }
