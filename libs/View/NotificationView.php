<?php
require_once 'libs/View.php';
require_once 'components/NotificationComponent.php';
require_once 'models/Notifications.php';

class NotificationView extends View
{

    protected $notif, $filter;

    public function __construct()
    {
        //echo "Dashboard View Block";
        parent::__construct();

    }

    public function htmlMailbox(){
        $html = new NotificationComponent();
        $html->setView('notification')
            ->setNotif($this->notif)
            ->render('views/blocks/page/notification.phtml');
    }


    public function getContent(){
        $this->htmlMailbox();
        return $this;
    }

    public function setNotif($content){
        $this->notif = $content;
        return $this;
    }

}
