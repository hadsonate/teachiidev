<?php
require_once( 'Dbconfig.php' );

class Connect extends Dbconfig
{
    var $classQuery;
    private $link;

    var $errno = '';
    var $error = '';


    private static $db;
    //private $connection;

    private function __construct() {
        $settings = $this->getConfig();
        $host = $settings['dbhost'];
        $name = $settings['dbname'];
        $user = $settings['dbusername'];
        $pass = $settings['dbpassword'];

        $this->link = new mysqli( $host , $user , $pass , $name );
        if($this->link === false){
            die("ERROR: Could not connect. " . $this->link->connect_error);
        }
        return $this;

    }



    public static function getConnection() {
        if (self::$db == null) {
            self::$db = new Connect();
        }
        return self::$db;
    }



    function query( $query )
    {
        $this->classQuery = $query;
        return $this->link->query( $query );
    }

    function escapeString( $query )
    {
        return $this->link->escape_string( $query );
    }


    function numRows( $result )
    {
        return $result->num_rows;
    }

    function lastInsertedID()
    {
        return $this->link->insert_id;
    }


    function fetchAssoc( $result )
    {
        return $result->fetch_assoc();
    }


    function fetchArray( $result , $resultType = MYSQLI_ASSOC )
    {
        return $result->fetch_array( $resultType );
    }


    function fetchAll( $result , $resultType = MYSQLI_ASSOC )
    {
        return $result->fetch_all( $resultType );
    }

    function fetchRow( $result )
    {
        return $result->fetch_row();
    }

    function freeResult( $result )
    {
        $this->link->free_result( $result );
        return $this;
    }

    function close()
    {
        $this->link->close();
        return $this;
    }

    function sql_error()
    {
        if( empty( $error ) )
        {
            $this->errno = $this->link->errno;
            $this->error = $this->link->error;
        }
        return $this->errno . ' : ' . $this->error;
    }

    public function test()
    {
        echo "test connect";
    }

}