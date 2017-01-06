<?php
  $form = new Form;
  $form('form')
     ->text('Username')
     ->password('Password')
     ->email('Email')
     ->submit('sub XD')
     ->errorplace();

  $form->generate_fuckforms('index', function(){ ?>
    alert('asd!');
  <?php });

?>
