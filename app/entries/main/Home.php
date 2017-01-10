<body style="background-color: white;"></body>

<script>
  alert('THIS WAS JUST RAN!');
</script>

<div class="jf-container mid-small" style="margin-top: 200px;">
  <form method="post" id="form" class="jekform">
    <div class="jf-title">
      Login
    </div>
    <div class="jf-content">

      <@> CSRF safety
      {{ csrf_token }}

      <@> Form inputs
      {{{ Form, Text, Username, username }}}
      {{{ Form, Password, Password, password }}}
      {{{ Form, Submit, Sign In }}}

      <@> Form management
      {{{ Form, Errorplace, form }}}
      {{{ Form, ForceGenerateJs, auth_test, form, form-errorplace, home }}}

    </div>
  </form>
</div>
