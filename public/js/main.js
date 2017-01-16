$(document).ready(function(){
  window.jek =
    {
      placeatme: $('#content'),
      initialize: function() {
        if (this.placeatme.length > 0)
          {
            this.firstload();
            $(window).bind('hashchange', function(){
              window.jek.pageloader();
            });
          }
        else console.log('JEKFWDE, INITIALIZE: placeatme element doesn\'t exist; not running codebase');
      },
      pageloader: function() {
        toload = window.location.hash;
      },
      loadpage: function(urltoload = false) {
        if (urltoload === false) urltoload = window.location.hash;
        if ( urltoload.length <= 3) urltoload = 'home';
        $.get(urltoload, function(body){
          // window.jek.placeatme.html(body);
          alert(body);
          console.log('JEKFWFE, LOADPAGE: (' + urltoload + ')');
        });
      },
      firstload: function() {
        this.loadpage();
      },
      form_manager: function(form_to_bind, type, errorplace, goto) {
        $('#' + form_to_bind).bind('submit', function(event){
          event.preventDefault();
          $.post('api', {
            'type'  : type,
            'pdata' : $(this).serializeArray()
          }, function( body ){
            alert(body);
            $errorplace = $('#'+errorplace);
            tdata = JSON.parse(body);
            // Managing for return = success.
            if (tdata.return === "success")
              if (goto === "reload")
                {
                  $errorplace.html(tdata.html);
                  window.location.reload();
                }
              else if (goto === "nothing")
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
      }
  };
  window.jek.initialize();
});
