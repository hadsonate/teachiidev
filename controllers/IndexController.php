<?php
require_once 'libs/Controller.php';
require_once 'models/User.php';

class IndexController extends Controller
{


	public function indexAction($id = 0)
	{
        $n = $_SESSION['message_code'];
        switch ($n){
            case 1500:
                $msg = "You are not authorize to see this page. Please sign in!";
                $this->view->setMessage($msg, 'error');
                break;
            default:
                $msg = "";
                $this->view->setMessage($msg, 'error');
                break;
        }
		$user = new User();
		
		$this->view->setPageTitle('Teach II Home Page');
		$this->view->render('views/pages/main-wide.phtml');
	}
}
