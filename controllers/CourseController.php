<?php
require_once 'libs/Controller.php';
require_once 'libs/Model.php';

class CourseController extends Controller
{

    public function __construct($prefix = 'course')
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


        $this->view->setView('course')
            ->setPageTitle('Class-List-Page')
            ->render('views/pages/main-wide.phtml');
    }

    public function ClassListAction()
    {

        $n = $_SESSION['message_code'];
        switch ($n){
            case 1500:
                $msg = "You are not authorize to see this page. Please sign in!";
                //$this->view->setMessage($msg, 'error');
                break;
            case 1600:
                $msg = "You are successfully logged in!";
                //$this->view->setMessage($msg, 'success');
                break;
            default:
                break;
        }

        //$model_notifs = Model::getModel('notifications');
        $this->view->setView('course')
            ->setPageTitle('Class-List-Page')
            ->setHeadTitle('Class List Page')
            ->render('views/pages/main-wide.phtml');
        //$this->view;
    }

}
