<?php
require_once 'libs/Controller.php';

class RegistrarController extends Controller
{

    public function __construct($prefix = 'registrar')
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
        $this->view->setView('registrar')
            ->setPageTitle('Web App - Registrar')
            ->render('views/pages/main-wide.phtml');
        //echo "test";
    }

}
