<?php
  class IndexKontroller extends Kontroller
    {
        public function index( $parm )
          {
            $this->loader->set->title = 'Jek Templating Engine Example!';

            $this->loader->entry->JTE('main/Home', [
              'name1' => 'jack',
              'name2' => 'sami',
              'age'   => '15',

              'csrf_token' => csrf_make(true)
            ]);
          }
    }
