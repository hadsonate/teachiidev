<?php
require_once( 'models/Data.php' );

class Schedule extends Data
{

    private $db;
	public function __construct()
    {
        parent::__construct();
        $this->db = $this->getDB();
    }

    public function loadDB(){
        return $this->db;
    }

    public function getCurrentSchedule($dateFilter)
    {
        $db = $this->db;
        $dateFilter = date("Y-m-d" , $dateFilter);
        if($dateFilter){
            $this->checkIfTableExists($db);
            $result = $db->query(
                "Select schedule.*
              FROM schedule
              WHERE schedule.entry_class_from BETWEEN '{$dateFilter}' AND '{$dateFilter} 23:59:59' 
                ORDER BY schedule.entry_class_from ASC
                "
            );
            if($db->numRows($result)){
                $data = $db->fetchAll($result);
                return $data;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function checkIfTableExists($db)
    {
        $result = $db->query("SELECT 1 FROM `schedule` LIMIT 1");

        if ($result == false) {
            $db->query("CREATE TABLE `schedule` (
            sid INT(11) AUTO_INCREMENT PRIMARY KEY,
            aid INT(11) NOT NULL,
            entry_title VARCHAR(255) NOT NULL,
            entry_description VARCHAR(255) NOT NULL,
            entry_type ENUM('opened_class', 'enrolled') NOT NULL,
            entry_status ENUM('active', 'done', 'cancelled') NOT NULL,
            entry_class_from TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            entry_class_to TIMESTAMP DEFAULT CURRENT_TIMESTAMP)"
            );
        }
    }
}