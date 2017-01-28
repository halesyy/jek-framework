<?php
  /*
  | The IndexKontroller is incharge of serving content when the page
  | is first loaded, supplying all of the CSS and JS, the other pages
  | do NOT manage the excess styles and are only meant to serve entries
  | and pages to be served to the content area built by the
  | IndexKontroller.
  |
  | When there's no content for the page to render, the Kontroller
  | loads the home function, which loads the entry needed.
  | This is loaded when the URI is bare such as "localhost/" or
  | frontend components are "localhost/#!/"
  |
  | When "index" is loaded the index method is loaded, and when
  | "home" is loaded, the home methid is loaded.
  |
  | @STACK
  | User loads localhost -> Loads all needed files to build FRONTEND
  | correctly -> Load IndexKontroller to get header/content/footer ->
  | Rely on events to build new views and swap them out.
  */

  class IndexKontroller extends Kontroller
    {
        public function index()
          {
            // Incharge of supplying all of the FIRSTLOAD data.
            $this->loader->set->title = 'JEKF';
            // Loading the header and default page content.
            $this->loader->builder->header;
              $this->loader->entry->render('main/Index', [
              ]);
            $this->loader->builder->footer;
          }
        public function home()
          {
            $this->loader->entry->render('main/Home');
          }
        public function login()
          {
            $this->loader->entry->render('main/Login', [

            ]);
          }

    }
