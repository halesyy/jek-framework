/*
| The JavaScript window function for managing your SPA application.
*/
$(document).ready(function(){
  window.jek =
  {
    placeatme: $('#content'),

    // Function to initialize the hashchange loader.
    initialize: function()
    {
      this.firstload();

      $(window).bind('hashchange', function(){
        window.jek.pageloader();
      });
    },
    // Manages the new URI and loads the page required.
    pageloader: function()
    {
      $.get( window.location.hash.substring(3) , function( body ){
        window.jek.placeatme.fadeOut(300, function(){
          window.jek.placeatme.html( body );
          window.jek.placeatme.fadeIn(300);
        })
      });
    },
    firstload: function()
    {
      $.get( window.location.hash.substring(3) , function( body ){
        window.jek.placeatme.html( body );
      });
    },
    // Function for managing forms easily and quickly.
    manage_form: function(form_to_bind, type, errorplace, onsuccess)
    {
      $('#' + form_to_bind).bind('submit', function(event){
        event.preventDefault();
        $.post('api', {
          'type'  : type,
          'pdata' : $(this).serializeArray()
        }, function( ret ){
          tdata = JSON.parse( ret );
          if (tdata.return === "success")
            {
              $('#' + errorplace).html( tdata.html );
              onsuccess();
            }
          else
            {
              $('#' + errorplace).html( tdata.html );
            }
        });
      });
    }
  };

  // Initializes class.
  window.jek.initialize();
});

/*
  A normal POST send to the APIS is done like:

  $('#FORMID').bind('submit', function(event){
    event.preventDefault();
    $.post('api', {
      'type'  : 'TO_CALL',
      'pdata' : $(this).serializeArray()
    });
  });
*/
