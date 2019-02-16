<?php
require_once( 'models/Data.php' );

class Notifications extends Data
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

    public function getCurrentMemos($count = false){
        $limit = "";
        if($count){
            $limit = " LIMIT {$count}";
        }
        $db = $this->db;
        $now = date("Y-m-d H:i:s");
        if($_SESSION["account_data"]){
            $account_data = $_SESSION["account_data"];
            $aid = $account_data["id"];
            $result = $db->query(
                "Select threads.*, notifications.*, accounts.*
              FROM threads
              LEFT JOIN notifications ON threads.nid=notifications.nid
              LEFT JOIN accounts ON notifications.sender=accounts.id
              WHERE threads.recipient = {$aid} AND notifications.notif_type='memo'
                AND notifications.end_datetime >= '{$now}' AND notifications.start_datetime  <= '{$now}'
                ORDER BY urgency DESC, start_datetime ASC
                ".$limit
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

    public function getCurrentTasks($count = false){


        $limit = "";
        if($count){
            $limit = " LIMIT {$count}";
        }


        $db = $this->db;
        $now = date("Y-m-d H:i:s");
        if($_SESSION["account_data"]){
            $account_data = $_SESSION["account_data"];
            $aid = $account_data["id"];

            $result = $db->query(
                "Select threads.*, notifications.*, accounts.*
              FROM threads
              LEFT JOIN notifications ON threads.nid=notifications.nid
              LEFT JOIN accounts ON notifications.sender=accounts.id
              WHERE threads.recipient = {$aid} AND notifications.notif_type='task'
                AND notifications.end_datetime >= '{$now}'
                ORDER BY urgency DESC, start_datetime ASC
                ".$limit
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

    public function getEvents($count = false){


        $limit = "";
        if($count){
            $limit = " LIMIT {$count}";
        }


        $db = $this->db;
        $now = date("Y-m-d H:i:s");
        if($_SESSION["account_data"]){
            $account_data = $_SESSION["account_data"];
            $aid = $account_data["id"];

            $result = $db->query(
                "Select threads.*, notifications.*, accounts.*
              FROM threads
              LEFT JOIN notifications ON threads.nid=notifications.nid
              LEFT JOIN accounts ON notifications.sender=accounts.id
              WHERE threads.recipient = {$aid} AND (notifications.notif_type='event' OR notifications.add_to_calendar = 'yes')
                AND notifications.end_datetime >= '{$now}'
                ORDER BY start_datetime ASC
                ".$limit
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

    public function getMailboxInbox($filter = false){


        $addwhere = "";
        if($filter){
            switch($filter){
                case "starred":
                    $addwhere = " AND threads.favorite='yes'";
                    break;
                case "flagged":
                case "trashed":
                    $addwhere = " AND threads.{$filter}='yes'";
                    break;
                case "sent":
                    $addwhere = " AND notifications.parent != 0";
            }

        }


        $db = $this->db;
        $now = date("Y-m-d H:i:s");
        if($_SESSION["account_data"]){
            $account_data = $_SESSION["account_data"];
            $aid = $account_data["id"];

            $result = $db->query(
                "Select threads.*, notifications.*, accounts.*
              FROM threads
              LEFT JOIN notifications ON threads.nid=notifications.nid
              LEFT JOIN accounts ON notifications.sender=accounts.id
              WHERE threads.recipient = {$aid}
              {$addwhere}
                ORDER BY urgency DESC, created_date DESC
                "
            );


            if($cc = $db->numRows($result)){
                $data = $db->fetchAll($result);
                $data["count"] = $cc;
                return $data;

            }else{
                return false;
            }
        }else{
            return false;
        }

    }

    public function getNotification($id = false){


        if($id){
            $db = $this->db;
            $now = date("Y-m-d H:i:s");
            if($_SESSION["account_data"]){
                $account_data = $_SESSION["account_data"];
                $aid = $account_data["id"];

                $result = $db->query(
                    "Select threads.*, notifications.*, accounts.*
              FROM threads
              LEFT JOIN notifications ON threads.nid=notifications.nid
              LEFT JOIN accounts ON notifications.sender=accounts.id
              WHERE notifications.nid = {$id}");


                if($cc = $db->numRows($result)){
                    $data = $db->fetchAssoc($result);
                    return $data;

                }else{
                    return false;
                }
            }else{
                return false;
            }

        }
        return false;




    }
}
