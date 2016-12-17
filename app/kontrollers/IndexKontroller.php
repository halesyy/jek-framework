<?php
  class IndexKontroller extends Kontroller
    {
        public function index() {
          $this->c->entry()->load('Index');
        }

        public function database_test()
          {
            $j = $this->c->joint()->Index();
            $j->JDO();


          }
    }
