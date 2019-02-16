<?php
require_once 'libs/Controller.php';
require_once 'libs/Model.php';

class BulletinController extends Controller
{

    public function __construct($prefix = 'bulletin')
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

        $model = Model::getModel('notifications');
        $memos = $model->getCurrentMemos(5);

        $this->view->setView('bulletin')
            ->setPageTitle('Web App - Bulletin')
            ->render('views/pages/main-wide.phtml');
    }

}
