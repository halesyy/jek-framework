<?php
  class IndexKontroller extends Kontroller
    {
        public function index( $parm )
          {
            $this->loader->set->title = 'Jek Templating Engine Example!';

            $this->loader->entry->load('main/Home');
          }
    }
