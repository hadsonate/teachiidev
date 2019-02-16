<?php
require_once 'libs/View.php';
require_once 'components/MailboxComponent.php';
require_once 'models/Account.php';

class MailboxView extends View
{

    protected $memos, $tasks, $inbox, $starred, $flagged, $sent, $trashed, $filter;

    public function __construct()
    {
        //echo "Dashboard View Block";
        parent::__construct();

    }

    public function htmlMailbox(){
        $html = new MailboxComponent();
        $html->setView('mailbox')
            ->setFilter($this->filter)
            ->setInbox($this->inbox)
            ->setStarred($this->starred)
            ->setFlagged($this->flagged)
            ->setSent($this->sent)
            ->setTrashed($this->trashed)
            ->render('views/blocks/account/mailbox.phtml');
    }


    public function getContent(){
        $this->htmlMailbox();
        return $this;
    }

    public function setInbox($inbox){
        $this->inbox = $inbox;
        return $this;
    }

    public function setFilter($filter){
        $this->filter = $filter;
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
