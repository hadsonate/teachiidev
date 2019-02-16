<?php
require_once 'libs/Connect.php';
class Data
{
    private $db;

    function __construct(){
        $this->db = Connect::getConnection();
    }

    public function getDB(){
        return $this->db;
    }
}