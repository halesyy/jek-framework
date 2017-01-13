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
      fuckforms: function(form_to_bind, type, errorplace, onsuccess) {
        $('#' + form_to_bind).bind('submit', function(event){
          event.preventDefault();
          $.post('api', {
            'type'  : type,
            'pdata' : $(this).serializeArray()
          }, function( ret ){
            alert(ret);
            // tdata = JSON.parse( ret );
            // if (tdata.return === "success")
            //   {
            //     $('#' + errorplace).html( tdata.html );
            //     onsuccess();
            //   }
            // else
            //   {
            //     $('#' + errorplace).html( tdata.html );
            //   }
          });
        });
      }
  };
  window.jek.initialize();
});
