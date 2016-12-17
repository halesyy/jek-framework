/*
| ------------------------------------------------------------------
| MAIN JS FILE LOADED FIRST -- FOR FRAMEWOERK.
| ------------------------------------------------------------------
| This file manages the frameworks stack for frontend developent.
|
| This manages the hashes and onclick events generated from the
| DOM environment, you're best off extending the current DOM given
| when starting off with the framework before you completely
| re-write the pages and implement the current frontend consepts.
|
| (this is if you're a new developer, don't listen to me if you're
| the God coder everyone claims you are!)
| ------------------------------------------------------------------
*/
$(document).ready(function(){

  jek = {
    uri  : window.location.href,
    hash : window.location.hash,
    /*
    | Type refers to the way you want to trigger the "hash_manager" function.
    | ---------------------------------------------------------------------------
    | If type is Click, when you click a certian id/class the event is triggered,
    | If type is HChan, whenever the hash is changed the event is triggered.
    */
    type : 'click',
    typeext: {
      // .CLASS or #ID.
      typeofclick  : '.jek-trigger',
      display_href : true
    },

    // Last segment that was used.
    last_segment: false,


    // Function for returning a certain segment of the URI / HASH area.
    seg: function(segment) {
      if (this.hash === '')
      return 'index';
      else
      {
        //hash.
        hash     = (this.hash).substring(2);
        segments = hash.split('/');
        //return the requested hash.
        if (typeof segments[segment] === undefined)
          return 'index';
        else return segments[segment];
      }
    },

    segsupply: function(uri, segment) {
      if (uri === '')
        return 'index';
      else
      {
        //hash.
        hash     = (uri).substring(2);
        segments = hash.split('/');
        //return the requested hash.
        if (typeof segments[segment] === undefined)
          return 'index';
        else return segments[segment];
      }
    },

    // Function for initializing the class.
    init: function() {
      if (this.type == 'click')
      {
        $( this.typeext.typeofclick ).click(function(event){
          event.preventDefault();

          uri        = "#!/" + $(this).attr('href');
          if (window.jek.typeext.display_href === true)
            window.location.href = uri;
          kontroller = window.jek.segsupply( uri, 1 );
          method     = window.jek.segsupply( uri, 2 );

          window.jek.load( kontroller, method );
        });
      }
      else if (this.type == 'hchan')
      {
        $(window).bind('hashchange', function(event){

          uri        = window.location.hash;
          kontroller = window.jek.segsupply( uri, 1 );
          method     = window.jek.segsupply( uri, 2 );

          window.jek.load( kontroller, method );

        });
      }
    },

    // Called when wanting to load some content.
    load: function( kontroller, method ) {
      $.get('/' + kontroller + '/' + method, function(body){
        $('#jek-midpage-view').html( body );
      });
    }

  };
  window.jek = jek;
  window.jek.init();
});
