<?php

class DBManager
{
    private $logger;
    private $pdo;

    public function __construct(PDO $pdo, $logger)
    {
        $this->logger=$logger;
        $this->pdo = $pdo;
    }

    function GetData( $sql )
    {
        //log sql
        $this->logger->log($sql);
        //define and execute query
        $result = $this->pdo->query( $sql );

        //show result (if there is any)
        if ( $result->rowCount() > 0 )
        {
            $rows = $result->fetchAll(PDO::FETCH_BOTH); //geeft array zoals [0] => 1, ['lan_id'] => 1, ...
            return $rows;
        }
        else
        {
            return null;
        }

    }

    function ExecuteSQL( $sql )
    {

        //Log sql
        $this->logger->log($sql);

        //define and execute query
        $result = $this->pdo->query( $sql );

        return $result;
    }




}