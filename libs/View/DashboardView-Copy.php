<?php
require_once 'libs/View.php';
require_once 'components/DashboardComponent.php';
require_once 'models/Account.php';

class DashboardView extends View
{

    protected $memos, $tasks, $inbox, $starred, $flagged, $sent, $trashed, $events;

    public function __construct()
    {
        //echo "Dashboard View Block";
        parent::__construct();

    }

    public function htmlDashboard(){
        $html = new DashboardComponent();
        $html->setView('dashboard')
            ->setMemos($this->memos)
            ->setTasks($this->tasks)
            ->setEvents($this->events)
            ->setInbox($this->inbox)
            ->setStarred($this->starred)
            ->setFlagged($this->flagged)
            ->setSent($this->sent)
            ->setTrashed($this->trashed)
            ->render('views/blocks/account/dashboard.phtml');
    }


    public function getContent(){
        $this->htmlDashboard();
        return $this;
    }

    public function setMemos($memos){
        $this->memos = $memos;
        return $this;
    }

    public function setTasks($tasks){
        $this->tasks = $tasks;
        return $this;
    }

    public function setEvents($events){
        $this->events = $events;
        return $this;
    }

    public function setInbox($inbox){
        $this->inbox = $inbox;
        return $this;
    }

    public function setStarred($starred){
        $this->starred = $starred;
        return $this;
    }

    public function setFlagged($flagged){
        $this->flagged = $flagged;
        return $this;
    }


    public function setSent($sent){
        $this->sent = $sent;
        return $this;
    }

    public function setTrashed($trashed){
        $this->trashed = $trashed;
        return $this;
    }


}
