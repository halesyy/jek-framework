<?php
  /*
  |-------------------------------------------------------------------
  | JEKS CODE BASE!
  | ------------------------------------------------------------------
  | It's nice to see you have your configuration at the top, that's a
  | good thing.
  |
  | So, this will be your table:
  |
  |            |------------------------------------------------|
  |            | NAME: values                                   |
  |            |------------------------------------------------|
  |            | id |          item_name         |    value     |
  |            |----|----------------------------|--------------|
  |            | 1  |           throne           |    10000     |
  |            | 2  |           sc               |    5000      |
  |            | 3  |           typewriter       |    20000     |
  |            |------------------------------------------------|
  |
  | With this data, the return array (when accessing the database)
  | looks like so:
  | (CODE):
  |  >$query = $pdo->query( "SELECT * FROM values" );
  |  >echo "<pre>", print_r($query->fetchAll()) ,"</pre>";
  |
  | OUTPUT: (ARRAY)
  |   FIRST_ROW [
  |     'id' => '1',
  |     'item_name' => 'throne',
  |     'value' => '10000'
  |   ],
  |   SECOND_ROW, etc!
  |
  | So, we just foreach this to iterate each row!
  |   foreach ( $query->fetchAll() as $row )
  |     {
  |       echo "<pre>", print_r($row) ,"</pre>";
  |     }
  |
  | BTW, Make your own PDO connection you fat fuck I'm not doing
  | everything for you.
  |
  | TODO [*] = Not done, [x] = done.
  | [*] Create Table
  | [*] Update codebase
  | [*] Add the image column to the Table for the image location
  | [*] Kiss Jek <3
  |
  |------------------------------------------------------------------
  */

  //Your PDO Connection goes here!
  $query = $pdo->query("SELECT * FROM values");

  /*Loops each row with the $row['item_name'] and $row['value'].*/
  //TALKING ABOUT THE LOOP IN THE CODE DOWN vvvv
?>

<html>
  <head>
  <title> Hi </title>
    <style>
    	table {
    		font-family: arial, sans-serif;
    		border-collapse: collapse;
            width: 100%;
        }
      	tr, th {
      		text-align: left;
      		border: 1px solid #dddddd;
      		padding: 8px;
      	}
        /*Very good Ant! Most cunts just use a special class for each even table.*/
      	tr:nth-child(even) {
        	background-color: #dddddd;
        	border: 2px solid grey;
      	}
    </style>
  </head>
<body>
  <div style="margin-bottom: 50px;">
    <h1> Hobba Values. </h1>
  </div>
<table>
  <tr>
  	<th> Rare </th>
  	<th> Thrones </th>
  	<th> Suitcases (SC) </th>
  	<th> Credits </th>
  </tr>
  <?php foreach ($query->fetchAll() as $row): ?>
    <tr>
      <th>
        <img src="imgs/throne.gif">
        <?=$row['item_name']?>
      </th>
      <th>1</th>
      <th><?=$row['value']?></th>

      <!--
      | No clue what you're doing with these values tbh but have fun.
      -->
    </tr>
  <?php endforeach; ?>

</body>
</html>
