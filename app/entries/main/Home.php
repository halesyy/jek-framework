<form id="form">
  <input type="text" name="username" value="Jack" />
  <input type="password" name="password" value="JacksPassword" />
  <input type="submit" value="send nudes!" />
  <div id="form-errorplace">
  </div>
</form>

<script>
  $(document).ready(function(){
    window.jek.manage_form('form', 'index', 'form-errorplace', function(){
      alert('success!');
    });
  });
</script>
