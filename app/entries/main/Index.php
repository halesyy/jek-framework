<body style="background-color: white;"></body>

<div class="jf-container mid-small" style="margin-top: 200px;">
  <form method="post" id="form" class="jekform">
    <div class="jf-title">
      Login
    </div>
    <div class="jf-content">
      <@> CSRF Manager.
      {{ csrf_make() }}

      <@> Managing if the user is signed in.
      @if signedin
        <@> You're signed in!
        {{{ Form, Text, You're signed in!, username }}}
      @else
        <@> Form placement
        {{{ Form, Text, Username, username }}}
        {{{ Form, Password, Password, password }}}
        {{{ Form, Submit, Sign in XD! }}}

        <@> Form management
        {{{ Form, Errorplace, form }}}

        @builder
          name:   form.generatejs
          type:   auth_test
          formid: form
          eplace: form-errorplace
          goto:   nothing
        @build
      @endif
    </div>
  </form>
</div>
