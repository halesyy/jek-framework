<?php
  $form = new Form;
  $form('form', ['style' => 'width: 50%; margin-left: 25%; padding: 50px;'])
    ->row()
      ->third()

        ->text('Username')

      ->endthird()
      ->third()

        ->text('Username')

      ->endthird()
      ->third()

        ->text('Username')

      ->endthird()
    ->endrow()
  ->end();



  $form->generate_fuckforms('index', function(){ ?>
    alert('asd!');
  <?php });

?>
