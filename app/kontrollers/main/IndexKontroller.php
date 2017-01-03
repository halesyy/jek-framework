<?php
  class IndexKontroller extends Kontroller
    {
        public function index( $parm )
          {
            $this->loader->set->title = 'Jek Templating Engine Example!';

            $indexjoint = $this->loader->joint->load('Index');
            $indexjoint->PSM_Tester();

            // JTE = Jek Template Engine.
            // $this->loader->entry->jte(
            //   'main/TemplateEngineTest',
            //   ['name' => 'Jack!']
            // );
          }
    }
