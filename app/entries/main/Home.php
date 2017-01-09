<body style="background-color: #4B4948;"></body>

<div class="jf-container mid-small" style="margin-top: 200px;">
  <form method="post" id="form" class="jekform">
    <div class="jf-title">
      Login
    </div>
    <div class="jf-content">
      
      <@> CSRF safety
      {{ csrf_make() }}

      <@> Form inputs
      {{{ Form, Text, Username, username }}}
      {{{ Form, Password, Password, password }}}
      {{{ Form, Submit, Sign In }}}

      <@> Form management
      {{{ Form, Errorplace, form }}}
      {{{ Form, ForceGenerateJs, index, form, form-errorplace, home }}}
      
    </div>
  </form>
</form>
