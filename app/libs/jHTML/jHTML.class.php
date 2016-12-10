<?php
  /*
  //
  //                       _oo0oo_
  //                      o8888888o
  //                      88" . "88
  //                      (| -_- |)
  //                      0\  =  /0
  //                    ___/`---'\___
  //                  .' \\|     |// '.
  //                 / \\|||  :  |||// \
  //                / _||||| -:- |||||- \
  //               |   | \\\  -  /// |   |
  //               | \_|  ''\---/''  |_/ |
  //               \  .-\__  '-'  ___/-. /
  //             ___'. .'  /--.--\  `. .'___
  //          ."" '<  `.___\_<|>_/___.' >' "".
  //         | | :  `- \`.;`\ _ /`;.`/ - ` : | |
  //         \  \ `_.   \_ __\ /__ _/   .-` /  /
  //     =====`-.____`.___ \_____/___.-`___.-'=====
  //                       `=---='
  //
  //
  //     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  //
  //               佛祖保佑         永无BUG
  //              May your code be bug free.
  //
  //
  //              _____________ _____________
  //            /   _____/    |   \______   \
  //            \_____  \|    |   /|       _/
  //            /        \    |  / |    |   \
  //            /_______  /______/  |____|_  /
  //                \/                 \/
  //            Helped design 1% of the language.
  */
  class jHTML extends jHTML_Compile {
    /*
      This is a class meant to build a templating engine for
      making easy-to-read HTML and CSS structures using php.

      It has two modes --
      Pre-made styles mode and BASE-styles mode,
      This means whichever mode gives whichever parsed output,

      Say you're using a pre-made styles type, you can try and
      opt a paragraph tag, and fonts, colors, etc will be
      pre-made, for a quick development cycle,

      Similar to the pre-made styles, BASE-styles is a
      html-elem-and-ext only opt stream.

      You can choose whichever mode you want to use by changing
      the first constructing paramater,
      Use either: PREMADE or BASE, default is PREMADE.
    */


    public $MODE = 'PREMADE';


    /*Manages the construction input and sets mode.*/
      function __construct($opt_stream_type = 'PREMADE')
        {
          if ($this->san_input(
            strtoupper($opt_stream_type),
            ['PREMADE','BASE']
          )) {
            $this->MODE = $opt_stream_type;
          } else {
            //opt error if not PREMADE/BASE type.
            $this->error(
              __FUNCTION__,
              "input <b>{$opt_stream_type}</b> not legal"
            );
          }
        }



    //
  }
