<?php
require_once 'libs/Controller.php';
require_once 'libs/Model.php';

class PagesController extends Controller
{

    public function __construct($prefix = 'pages')
    {
        parent::__construct($prefix);
    }

    public function IndexAction()
    {
        //add index action here
    }


    public function ContactAction()
    {

        //$this->view->setMessage("Login page under construction!");
        $msg = "Page under construction!";
        $this->view->setMessage($msg, 'error');
        $this->view->setView('contact')
            ->setPageTitle('Web App - Contact Us')
            ->render('views/pages/main-wide.phtml');
    }

    public function AboutAction()
    {
        //$this->view->setMessage("Login page under construction!");
        $msg = "Page under construction!";
        $this->view->setMessage($msg, 'error');
        $this->view->setView('about')
            ->setPageTitle('Web App - About')
            ->render('views/pages/main-wide.phtml');
    }

    public function NotificationAction($id)
    {

        $n = $_SESSION['message_code'];
        switch ($n){
            case 1500:
                $msg = "You are not authorize to see this page. Please sign in!";
                $this->view->setMessage($msg, 'error');
                break;
            case 1600:
                $msg = "You are successfully logged in!";
                $this->view->setMessage($msg, 'success');
                break;
            default:
                break;
        }

        $model_notifs = Model::getModel('notifications');
        $content = $model_notifs->getNotification($id);
        $this->view->setView('notification')
            ->setNotif($content)
            ->setPageTitle('Web App - Notification')
            ->setHeadTitle('Notification')
            ->render('views/pages/main-wide.phtml');
        //$this->view;
    }

}
