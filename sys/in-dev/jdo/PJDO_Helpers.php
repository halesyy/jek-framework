<?php
  class P_Helpers {
    /*
    | Functions on the JDO class to help aid in the processing.
    */

    public function display($arr)
      { echo "<pre>",print_r($arr),"</pre>"; }

    public function error($msg)
      {
        die( "<b>JDO {$this->version} ERROR</b>: " . $msg );
      }

    public function breadcrumb($msg)
      {
        echo "<b>breadcrumb</b>: $msg <br/>";
      }

    public function create_query($statement, $binds)
      {
        $q = $this->handler->prepare($statement);
        $q->execute($binds);
        return $q;
      }

      /* This is a function that is used practically and is a testing function as well. */
        # prepared, this is a function meant for a prepared and then executed statement.
        public function help($query = 'not-given') {
          if ($query == 'not-given') die('the function <b>help</b> is meant to supply you with information on the query you just tried to execute, and should be used if is failing.');
          # Getting the error info array.
            $e = $query->errorInfo();
            $r = []; # R = Return, returning array.
          # Will start adding values into the Return array.
            $r['PSM - pHelp'] = '<b>INFORMATION GATHERED FROM THE PREPARED / EXECUTED QUERY</b>';
            $r['MYSQL eCode'] = $e[0].' - Google the meaning of the code';
            $r['Drivr eCode'] = $e[1].'  - Error specific to the driver';
          # Manip for getting the correct error message to display.
            $search = [
              '/Table \'(.*?)\.(.*?)\' doesn\'t exist/is',
              '/You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near (.*?) at line (.*?)/is',
              '/Unknown column \'(.*?)\' in \'(.*?)\'/is',
              '/Column count doesn\'t match value count at row (.*?)/is'
            ]; $replace = [
              'The table <b>$2</b> doesn\'t exist in the database <b>$1</b>, did you spell it right?',
              'There was a syntax error, if you want to combat it effectively, please seperate each SQL word into seperate lines then retry, now check <b>line: $2</b>',
              'The column (<b>$1</b>) in the table you tried to insert/select from into doesn\'t exist, did you spell it right?',
              'The amount of <b>column\'s</b> vs <b>inserting values</b> does not match up, re count them!'
            ]; $r['Custom Mesg'] =  preg_replace($search,$replace,$e[2]);
            $r['Raw Message'] = $e[2];
            if ($query->execute()) $r['Query Execu'] = 'true';
              else $r['Query Execu'] = 'false';
          # Management for checking if there is even an error.
            if ($e[0] == "00000") $succ = true;
              else $succ = false;

          # Return management.
            if ($succ) {
              echo 'The query executed correctly - There should be no need for the error report';
            } else {
              $this->display($r);
            }
        } #

  }
