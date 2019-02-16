<?php
require_once 'libs/Controller.php';
require_once 'libs/Model.php';

class AdminController extends Controller
{

    public function __construct($prefix = 'admin')
    {
        parent::__construct($prefix);
    }

    public function IndexAction()
    {
        //add conditional to account or dashboard depends on session
        $this->CreateAction();
    }

    public function CreateAction($step=1)
    {
        $n = $_SESSION['message_code'];
        $n = $_SESSION['message_code'];
        switch ($n){
            case 1701:
                $msg = "Notification successfully created!";
                $this->view->setMessage($msg, 'success');
                break;
            default:
                break;

        }

        $this->view->setView('create')
            ->setPageTitle('Web App - Create Notification')
            ->setStep($step)
            ->setHeadTitle('Create Notification')
            ->render('views/pages/main-wide.phtml');
        //$this->view;
    }

    public function ManageAction()
    {
        $n = $_SESSION['message_code'];
        switch ($n){
            default:
                break;
        }

        $this->view->setView('manage')
            ->setPageTitle('Web App - Admin')
            ->setHeadTitle('Administrator')
            ->render('views/pages/main-wide.phtml');
        //$this->view;
    }

    public function getEmailsAction()
    {
        $request = $_REQUEST;
        $q = $request['q'];
        $model = Model::getModel('account')->getDB();

        $result = $model->query(
            "Select accounts.id, accounts.account_email
              FROM accounts
              WHERE accounts.status = 'online' AND accounts.account_email LIKE '{$q}%'"
        );

        $data = $model->fetchAll($result);
        $r = array();
        foreach($data as $d){
            $r[] = array("id"=>$d['id'], "name"=>$d['account_email']);

        }
        header('Content-Type: application/json');
        echo json_encode($r);
        exit();
    }


    public function processNotificationAction()
    {
        $request = $_REQUEST;
        $type = $request['notification_type'];
        $title = $request['title'];
        $content = $request['content'];
        $content = htmlspecialchars($content);
        //print_r(base64_decode($content));
        $recipients = $request['recipients'];
        $add_to_calendar = $request['add_to_calendar'];
        $add_to_calendar = $add_to_calendar == "on"? "yes": "no";
        $start_datetime = $request['start_datetime'];
        $start_datetime = date("Y-m-d h:m:s", strtotime($start_datetime));
        $end_datetime = $request['end_datetime'];
        $end_datetime = date("Y-m-d h:m:s", strtotime($end_datetime));
        $account_id = $_SESSION['account_data']['id'];
        $urgency = $request['urgency'];


        $model = Model::getModel('admin')->getDB();
        $content = ((string)$content);
        $model->query(
            "INSERT INTO notifications
                  (title,
                  content,
                  sender,
                  add_to_calendar,
                  start_datetime,
                  end_datetime,
                  notif_type,
                  urgency)
                  VALUES
                  ('{$title}',
                  '{$content}',
                  {$account_id},
                  '{$add_to_calendar}',
                  '{$start_datetime}',
                  '{$end_datetime}',
                  '{$type}',
                  {$urgency})"
        );
        $last_id = $model->lastInsertedID();
        if($last_id){
            $rs = explode(',', trim($recipients));
            foreach($rs as $r){
                $x = trim($r);
                $model->query(
                    "INSERT INTO threads
                  (nid,
                  recipient)
                  VALUES
                  ({$last_id},
                  '{$x}')"
                );
            }
        }

        $_SESSION['message_code'] = 1701;
        header("Location: /admin/create", true, 301);
        //echo html_entity_decode($content);
        exit();
    }


}
