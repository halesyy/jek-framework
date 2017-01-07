<?php
  $form = new Form;
  $form('form', ['style' => 'width: 50%; margin-left: 25%; padding: 50px;'])
    ->row()->third()
      ->text('Username')
    ->endthird()->endrow()
    ->row()->third()
      ->password('Password')
    ->endthird()->endrow()
    ->row()->third()
      ->email('Email')
    ->endthird()->endrow()
  ->end();

  $form->generatejs('index', function(){
    ?>
      alert('asd!');
    <?php
  });

?>
