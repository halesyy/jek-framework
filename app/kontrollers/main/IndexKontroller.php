<?php
  class IndexKontroller extends Kontroller
    {

        public function options() { $this->RunHeaderFooter = true; }

        public function index()
          {
            $this->c->entry()->load('main/Index');
          }

    }
