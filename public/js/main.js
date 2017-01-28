$(document).ready(function(){
  window.jek =
    {
      content: $('#content'),

      header: $('#header'),
      footer: $('#footer'),
      contentid: false,

      basefooterheight:  30,
      // the height of the header is collapsed
      largeheaderheight:   200,
      normalheaderheight: false,

      docheight: function()
        {
          var D = document;
          return Math.max(
              D.body.scrollHeight, D.documentElement.scrollHeight,
              D.body.offsetHeight, D.documentElement.offsetHeight,
              D.body.clientHeight, D.documentElement.clientHeight
          );
        },

      /*the framework event handlers that should be used, nothing to do with the hash changes*/
      event_handlers: function()
        {
          //making so the content can fit the footer when extended and not shut down content
          this.content.css({'margin-bottom':this.largeheaderheight + 20});
          this.normalheaderheight = this.header.height();
          // if ($(window).height() == $(document).height()) window.jek.footer_enlarge();
          $(window).scroll(function() {
             if($(window).scrollTop() + $(window).height() == $(document).height()) {
               window.jek.footer_enlarge();
             } else window.jek.footer_delarge();
          });
        },

      /*function to load the current url hash*/
      load_current_page: function()
        {
          if (this.content.length < 0) // content placer exists
          console.log('JEKFWDE: LOAD_CURRENT_PAGE: content to place doesn\'t exist.');
          else
          this.load_page();
          //setting event handler
          $(window).bind('hashchange', function(event){
            event.preventDefault();
            window.jek.load_page(true);
          });
        },
      load_page: function(speed = false)
        {
          //going put the header and footer back just incase was changed
          this.fold_header_down();
          this.fold_footer_down();

          hash = window.location.hash;
          if (hash.length <= 3) urltoload = 'home';
          else urltoload = hash.substring(3);
          //loading url page
          $.get(urltoload, function(body){
            if (speed)
              {
                window.jek.content.fadeOut(250, function(){
                  window.jek.content.html(body);
                  window.jek.content.fadeIn(250, function(){
                    if ($(window).height() == $(document).height()) window.jek.footer_enlarge();
                    else window.jek.footer_delarge();
                  });
                });
              }
            else
              {
                window.jek.content.html(body);
                if ($(window).height() == $(document).height()) window.jek.footer_enlarge();
              }
          });
        },
      form_manager: function(form_to_bind, type, errorplace, goto) {
        $('#' + form_to_bind).bind('submit', function(event){
          event.preventDefault();
          $.post('api', {
            'type'  : type,
            'pdata' : $(this).serializeArray()
          }, function( body ){
            // alert(body);
            $errorplace = $('#'+errorplace);
            tdata = JSON.parse(body);
            // Managing for return = success.
            if (tdata.return === "success")
              if (goto === "reload")
                {
                  $errorplace.html(tdata.html);
                  window.location.reload();
                }
              else if (goto === "nothing" || goto == "none")
                {
                  $errorplace.html(tdata.html);
                }
              else
                {
                  $errorplace.html(tdata.html);
                  window.location.href = "#!/" + goto
                }
            else // Managing for not a successful API call.
              $errorplace.html(tdata.html);
          });
        });
      },


    fold_header_up: function()
      {
        this.header.slideUp();
      },
    fold_header_down: function()
      {
        this.header.slideDown();
      },
    fold_footer_up: function()
      {
        this.footer.slideUp();
      },
    fold_footer_down: function()
      {
        this.footer.slideDown();
      },

    footer_enlarge: function()
      {
        this.footer.height( this.largeheaderheight );
        $('#footer > #footer-preview').fadeOut(function(){
          $('#footer > #footer-content').fadeIn();
        });
      },
    footer_delarge: function()
      {
        this.footer.height( this.basefooterheight );
        $('#footer > #footer-content').fadeOut(function(){
          $('#footer > #footer-preview').fadeIn();
        });
      },

    small_header: function()
      {
        this.header.height( this.smallheaderheight );
      }
  };
  window.jek.load_current_page();
  window.jek.event_handlers();
});
