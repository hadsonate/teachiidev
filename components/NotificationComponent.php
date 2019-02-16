<?php
require_once 'libs/View.php';
class NotificationComponent extends View
{

    protected $notif, $filter;
    public function __construct()
    {
        parent::__construct();
    }

    public function setFilter($filter){
        $this->filter = $filter;
        return $this;
    }

    public function getFilter(){
        return $this->filter;
    }
    public function setNotif($notif){
        $this->notif = $notif;
        return $this;
    }

    public function getNotif(){
        return $this->notif;
    }
}
