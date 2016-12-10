<?php
  class jHTML_Templates extends jHTML_Components {
    /*
      This is a class that is meant to hold all the function
      templates that contain the management for the optstream.

      STACK FOLLOW.
      Main Template function ->
      Calls Function ->
      Gets OPTSTREAM ->
      Opts.
    */

    /*
      Group of variables used in class for compiling and template management.
    */

    //store of last used.
    public $last_template  = false;
    public $last_content   = false;
    public $last_ext       = false;
    //store of all used.
    public $store_template = [];
    public $store_content  = [];
    public $store_ext      = [];
    //replaces -- what the tempaltes incoming are replaced with if needbe.
    public $replaces       = [
      '@' => 'at',
      '~' => 'grave',
      '&' => 'and'
    ];
    //store of functions that've been called.
    public $function_calls = [];


    /*Gets the template, adds content and manages the ext
    ext-extension-the styles/class/etc...
    {CLASSES=first,class::STYLES=margin-top:20px::EXTRAS=placeholder='lol!'}
    LMAO LOOK @ THAT FUCKING SHIT IMAGINE HOW UGLY IT IS
    {this='is just a place that gets put into the' element='so, its ur fault if its ugly'}

    This is the function where the changes occur.
    |ipt|
        |compiler|
                 |lbl-interpreter|
                                 |template-class|
                                                |opt|
    */
      public function template_manage($template, $content, $ext)
        {
          // uncomment for ipt streams.
          // echo "<pre>";
          // echo "user req template: $template \n";
          // echo "user req content.: $content \n";
          // echo "user req ext.....: $ext \n";
          // echo "</pre>";

          //the call to the function that manages the opt stream, is where all outputting occurs.
          $this->opt_stream_manage( $template, $content, $ext );

          //sends data to be saved. -- done after just incase there's a need for it.
          $this->template_constructor( $template, $content, $ext );
        }

    /*Takes in the template/content/ext and manages the output stream.*/
      public function opt_stream_manage($template, $content, $ext, $doopt = true)
        {
          //save functions been called.
          array_push( $this->function_calls, $template );
          //opt stream start.
          $templates = explode( '/', $template );
          $opt       = $content;
          foreach ($templates as $itemplate)
          {
            //replacing.
            foreach ($this->replaces as $search => $replace)
            $itemplate = str_replace( $search, $replace, $itemplate );
            //fcall.
            $fname = "t_{$itemplate}";
            //opt management.
            $opt = $this->$fname( $opt, $ext );
          }
          echo ($doopt) ? $opt."\n" : '';
        }

      /*This function takes in all the given data in case some function needs
      it at a later date.*/
        public function template_constructor( $template, $content = false, $ext = false )
          {
            //mangement for last&&stores.
            $this->last_template = $template;
            $this->last_content  = $content;
            $this->last_ext      = $ext;

            array_push( $this->store_template, $template );
            array_push( $this->store_content, $content );
            array_push( $this->store_ext, $ext );
          }

        /*Opts the streams of last|template,content,ext and store|template,content,ext.*/
          public function template_stores()
            {
              $this->display(
                "TEMPLATES: FIRST -> LAST",
                $this->store_template,
                "CONTENTS: FIRST -> LAST",
                $this->store_content,
                "EXTS: FIRST -> LAST",
                $this->store_ext
              );
            }
        /*Opts the stream of functions that've been called.*/
          public function func_stores()
            {
              $this->display(
                "FUNCTIONS THAT HAVE BEEN CALLED TO CONSTRUCT OPT STREAM",
                $this->function_calls
              );
            }


        /*HELPER FUNCTIONS FOR THE TEMPLATE SYSTEM.*/
          public function remove_template_name($fname)
            {
              return ltrim($fname, 't_');
            }
          public function bare($fname, $ext = false)
            {
              return "<{$this->remove_template_name($fname)} {$ext}>";
            }
          public function htmle_normal($fname, $content, $ext)
            {
              $template = $this->remove_template_name($fname);
              return "<{$template} {$ext}>{$content}</{$template}>";
            }









      /*Where data gets sent to be opt'd. Looks in array for template and calls
      funtion. -- function is called from starter, so:
      ipt: h1 hello world!
      cal: t_h1 with params: content=hello world!, ext=false.*/

        public function t_h1($content, $ext)
          {
            return $this->htmle_normal(__FUNCTION__, $content, $ext);
          }
        public function t_h2($content, $ext)
          {
            return $this->htmle_normal(__FUNCTION__, $content, $ext);
          }
        public function t_h3($content, $ext)
          {
            return $this->htmle_normal(__FUNCTION__, $content, $ext);
          }
        public function t_h4($content, $ext)
          {
            return $this->htmle_normal(__FUNCTION__, $content, $ext);
          }
        public function t_h5($content, $ext)
          {
            return $this->htmle_normal(__FUNCTION__, $content, $ext);
          }
        public function t_h6($content, $ext)
          {
            return $this->htmle_normal(__FUNCTION__, $content, $ext);
          }
        public function t_br()
          {
            return $this->bare(__FUNCTION__);
          }
        public function t_p($content, $ext)
          {
            return $this->htmle_normal(__FUNCTION__, $content, $ext);
          }
        public function t_grave($content, $ext)
          {
            //gets last template, makes function name, calls w/ data.
            $template = $this->last_template;
            $fname = "t_$template";
            return $this->$fname($content, $ext);
          }
        public function t_div($content, $ext)
          {
            return $this->htmle_normal(__FUNCTION__, $content, $ext);
          }
        public function t_()
          {
            return '';
          }
        public function t_contentbox($content, $ext)
          {
            $pieces = explode(':', $content);
            return "<div class='contentbox-container'>"
                ."<div class='contentbox-title cb-color-red'>{$pieces[0]}</div>"
                ."<div class='contentbox-content'>{$pieces[1]}</div>"
                ."</div>";
          }
        public function t_d($content, $ext)
          {
            return "<div {$ext}>";
          }
        public function t_atd()
          {
            return "</div>";
          }
        public function t_b($content, $ext)
          {
            return $this->htmle_normal(__FUNCTION__, $content, $ext);
          }
        public function t_i($content, $ext)
          {
            return $this->htmle_normal(__FUNCTION__, $content, $ext);
          }
        public function t_u($content, $ext)
          {
            return $this->htmle_normal(__FUNCTION__, $content, $ext);
          }
        public function t_body($content, $ext)
          {
            return "<body {$ext}>";
          }
        public function t_atbody()
          {
            return "</body>";
          }
        public function t_ul($content, $ext)
          {
            return "<ul {$ext}>";
          }
        public function t_atul($content, $ext)
          {
            return "</ul>";
          }
        public function t_lieasy($content, $ext)
          {
            return $this->htmle_normal(__FUNCTION__, $content, $ext);
          }
        public function t_head($content, $ext)
          {
            return "<head {$ext}>";
          }
        public function t_athead($content, $ext)
          {
            return "</head>";
          }
        public function t_link($content, $ext)
          {
            return $this->bare(__FUNCTION__, $ext);
          }
        public function t_script($content, $ext)
          {
            return $this->htmle_normal(__FUNCTION__, $content, $ext);
          }
        public function t_html($content, $ext)
          {
            return "<html {$ext}>";
          }
        public function t_athtml($content, $ext)
          {
            return "</html>";
          }
        public function t_meta($content, $ext)
          {
            return $this->bare(__FUNCTION__, $ext);
          }
      /*Some Bootstrap-related functions, since that's what I like to use!*/
        public function t_container($content, $ext)
          {
            return "<div class='container'>";
          }
        public function t_atcontainer($content, $ext)
          {
            return "</div>";
          }
        public function t_lianda($content, $ext)
          {
            $pieces = explode( ':',$content );
            $show   = $pieces[0];
            $tell   = $pieces[1];
            return "<li {$ext}><a href='{$tell}'>{$show}</a></li>";
          }
        public function t_navbar($content, $ext)
          {
            return "<div class='navbar navbar-default'>";
          }
        public function t_atnavbar($content, $ext)
          {
            return "</div>";
          }
        public function t_row($content, $ext)
          {
            return "<div class='row' {$ext}>";
          }
        public function t_atrow()
          {
            return "</div>";
          }
        public function t_col($content, $ext)
          {
            //THIS IS SOME OF THE WORST CODE IVE EVER WRITTEN BUT ITS MAKING ME LAUGH SO IT STAYS.
            $splits = explode(',',$content);
            $str = implode(',',$splits);
            //repalces for the string.
            $str = str_replace('v', 'visible', $str);
            $str = str_replace('h', 'hidden' , $str);
            $splits = explode(',',$str);
            //getting the lg, md, sm and xs.
            $sections = ['lg','md','sm','xs'];
            foreach ($splits as $index => $piece)
              if ( is_numeric($piece) ) $splits[$index] = "col-{$sections[$index]}-$piece";
                else $splits[$index] = "{$piece}-{$sections[$index]}";
            foreach ($splits as $index => $piece)
              $splits[$index] = str_replace(' ', '', $piece);
            //getting each part.
            $lg = $splits[0]; $md = $splits[1]; $sm = $splits[2]; $xs = $splits[3];
            return "<div class='{$lg} {$md} {$sm} {$xs}'>";
          }
        public function t_atcol()
          {
            return "</div>";
          }
        public function t_img($content, $ext)
          {
            return "<img {$ext} alt='{$content}' />";
          }
        public function t_font($content, $ext)
          {
            return $this->htmle_normal(__FUNCTION__, $content, $ext);
          }
        public function t_li($content, $ext)
          {
            return "<li {$ext}>";
          }
        public function t_atli()
          {
            return "</li>";
          }
        public function t_a($content, $ext)
          {
            $pieces = explode(':',$content);
            $show = $pieces[0];
            $tell = $pieces[1];
            return "<a href='{$tell}' {$ext}>{$tell}</a>";
          }
  }
