@small-header

<script>
$(document).ready(function(){
  window.jek.form_binder('form', 'index', function(sobj){
    alert(sobj.raw);
  }, true);
});
</script>

<div class="container">
  @row
    @col 6,6,12,12
      <div class="divcontainer">
        <div class="title">
          <span class="big-title black-highlight white">Nice title text</span>
        </div>
        <div class="content">
          We're changing the world, one CSS style at a time. kys jek <br/>
          this is jeks sandbox! <br/><br/>
          <a href="/#!/home">Click me zoe again!</a>
        </div>
      </div>
    @endcol
    @col 6,6,12,12
      <div class="jf-container jf-container-none" id="form" style="">
        <form method="post" id="form" class="jekform">
          <div class="title">
            Login
          </div>
          <div class="content">
            {{ csrf_make() }}

            <select class="solo">
              @options countries
            </select>

            {{{ Form, Text, Username }}}
            {{{ Form, Password, Password }}}
            {{{ Form, Submit, Login }}}

            {{{ Form, Errorplace, form }}}
            @@builder
            @@  name: form.generatejs
            @@  formid: form
            @@  eplace: form-errorplace
            @@  goto: reload
            @@  type: auth_test
            @@build
          </div>
        </form>
      </div>
    @endcol
  @endrow
</div>
