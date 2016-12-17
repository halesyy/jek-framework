<?php
  class P_Queries extends P_Chains {
    /*
    | This is the queries class that contains PDO nature queries to the database.
    |
    | NOTE
    |   One of the key uses for PJDO is to do a single query for all your needs from that pull.
    |   Exampe, if I call a query and want to check that there was data returned,
    |   I could use:
    |    if (isset( $p->row_set( "QUERY", "BINDS" ) ) ) {  }
    |   Or:
    |    $q = $p->single( "QUERY", "BINDS" );
    |    if ($q->row_count) {  }
    |   Then be able to use that q element in a loop, etc.
    */




    //For looping the rows given off from the statement.
    public function select_loop($statement, $binds, callable $loop, $debug = false)
      {
        $query = $this->handler->prepare($statement);
        $query->execute($binds);

        if ($query->rowCount() == 0 && $debug)
          $this->Breadcrumb('rowcount = 0');
        if ($debug)
          $this->Display($query);

        foreach ($query->fetchAll() as $row)
          $loop( $row, $this, (object) $_REQUEST );
      }

    //For getting a single row from the database and not needing any iteration.
    public function row_set($statement, $binds, $debug = false)
      {
        $query = $this->handler->prepare($statement);
        $query->execute($binds);

        if ($debug) $this->Display( $query );

        return $query->fetch();
      }

    //Opposite side of selecting, inserting into the database.
    public function insert($table, $inserts, $debug = false)
      {
        /*
        |    Formatted like so
        | [ 'column' => 'data' ]
        | [ 'column' => 'data' ]
        */
        $binds = [];

        $statement  = "INSERT INTO $table (";
        $statement .= implode( ',', array_keys($inserts) );
        $statement .= ') VALUES (';
            for ($i = 1; $i <= count( array_values($inserts) ); $i++)
              array_push($binds, '?');
        $statement .= implode( ',', $binds);
        $statement .= ')';

        $query = $this->handler->prepare( $statement );
        $query->execute( array_values($inserts) );

        if ($debug) $this->Breadcrumb( "<b>$statement</b>" );
        if ($debug) $this->Display($query);
      }

    //For deleting content.
    public function delete($table, $where, $debug = false)
      {
        //Where management.
        $wheres = explode(' = ', $where);
        if (count($wheres) == 1) $wheres = ['id', $where];

        $statement = "DELETE FROM $table WHERE {$wheres[0]} = :w";
        $query = $this->handler->prepare($statement);
        $query->execute([':w'=>$wheres[1]]);

        if ($query && $debug)
          $this->Breadcrumb('query was executed, as stated by query return');
        if ($debug)
          $this->Breadcrumb("statement: $statement");
      }

    //Query to help with multi-line as well as clean management.
    public function single($statement, $binds, $debug = false)
      {
        //Creating original query.
        $q = $this->create_query($statement, $binds);

        $ret['query']       = $q;
        $ret['data_exists'] = $q->rowCount();
        $ret['statement']   = $statement;
        $ret['binds']       = $binds;
        $ret['rowcount']    = $q->rowCount();
        $ret['helper']      = $this->help($q, true);

        return (object) $ret;
      }

  }
