<?php
  class TestKontroller extends Kontroller {

    public function options()
    {
      $this->RunHeaderFooter = false;
    }

    public function one()
      {
        $this->c->set()->title = 'One!';
        echo 'one!';
      }
    public function two()
      {
        $this->c->set()->title = 'Two!';
        echo 'two!';
      }
  }
