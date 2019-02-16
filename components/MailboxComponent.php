<?php
require_once 'libs/View.php';
class MailboxComponent extends View
{

    protected $inbox, $starred, $flagged, $sent, $trashed, $filter;
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

    public function setInbox($inbox){
        $this->inbox = $inbox;
        return $this;
    }

    public function getInbox(){
        return $this->inbox;
    }

    public function setStarred($starred){
        $this->starred = $starred;
        return $this;
    }

    public function getStarred(){
        return $this->starred;
    }

    public function setFlagged($flagged){
        $this->flagged = $flagged;
        return $this;
    }

    public function getFlagged(){
        return $this->flagged;
    }


    public function setSent($sent){
        $this->sent = $sent;
        return $this;
    }

    public function getSent(){
        return $this->sent;
    }

    public function setTrashed($trashed){
        $this->trashed = $trashed;
        return $this;
    }

    public function getTrashed(){
        return $this->trashed;
    }
}
