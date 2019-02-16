<?php
require_once 'libs/Controller.php';

class CalendarController extends Controller
{

    public function __construct($prefix = 'calendar')
    {
        parent::__construct($prefix);
    }

    public function IndexAction()
    {
        $n = $_SESSION['message_code'];
        switch ($n){
            case 1500:
                $msg = "You are not authorize to see this page. Please sign in!";
                $this->view->setMessage($msg, 'error');
                break;
            default:
                $msg = "Page under construction!";
                $this->view->setMessage($msg, 'error');
                break;
        }
        $this->view->setView('calendar')
            ->setPageTitle('Web App - Calendar')
            ->setHeadTitle('Calendar Event Schedules')
            ->render('views/pages/main-wide.phtml');
    }

}
