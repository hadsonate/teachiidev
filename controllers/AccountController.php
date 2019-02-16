<?php
require_once 'libs/Controller.php';
require_once 'libs/Model.php';

class AccountController extends Controller
{

    public function __construct($prefix = 'account')
    {
        parent::__construct($prefix);
    }

    public function IndexAction()
    {
        //add conditional to account or dashboard depends on session
        if($_SESSION['user_is_loggedin'] === false){
            $this->LoginAction();
        }else{
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

    public function LoginAction()
    {
        $n = $_SESSION['message_code'];
        switch ($n){
            case 1500:
                $msg = "You are not authorize to see this page. Please sign in!";
                $this->view->setMessage($msg, 'error');
                break;
            case 1501:
                $msg = "Invalid username. Username cannot be found!";
                $this->view->setMessage($msg, 'error');
                break;
            case 1502:
                $msg = "Invalid password. Password is incorrect!";
                $this->view->setMessage($msg, 'error');
                break;
            case 1601:
                $msg = "You are now logged out!";
                $this->view->setMessage($msg, 'success');
                break;
            default:
                break;
        }

        //$this->view->setMessage("Login page under construction!");
        $this->view->setView('account')
            ->setPageTitle('Web App - Login')
            ->render('views/pages/main-wide.phtml');
        //$this->view;
    }

    public function RegisterAction()
    {
        $n = $_SESSION['message_code'];
        switch ($n){
            case 1001:
                $msg = "Username is not available! Try another username.";
                $this->view->setMessage($msg, 'error');
                break;
            case 1002:
                $msg = "XXXX";
                $this->view->setMessage($msg, 'error');
                break;
            case 'success':
                $msg = "Successfully registered";
                $this->view->setMessage($msg, 'success');
            default:
                break;

        }

        unset($_SESSION['message_code']);

        $this->view->setView('register')
            ->setPageTitle('Web App - Register')
            ->render('views/pages/main-wide.phtml');
        //$this->view;
    }


    public function DashboardAction()
    {
        if (!$_SESSION['account_data']) {
            $redirect_url =  $this->getUrl('index');
            header("Location: {$redirect_url}", true, 301);
        }
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
        $this->view->setView('dashboard')
            ->setPageTitle('Teach II - Account Dashboard')
            ->setHeadTitle('Account Dashboard')
            ->render('views/pages/main-wide.phtml');
        //$this->view;
    }

    public function MailboxAction($filter = "inbox")
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

        $inbox = $model_notifs->getMailboxInbox();
        $starred = $model_notifs->getMailboxInbox("starred");
        $flagged = $model_notifs->getMailboxInbox("flagged");
        $sent = $model_notifs->getMailboxInbox("sent");
        $trashed = $model_notifs->getMailboxInbox("trashed");
        //$this->view->setMessage("Login page under construction!");
        $this->view->setView('dashboard')
            ->setInbox($inbox)
            ->setFilter($filter)
            ->setStarred($starred)
            ->setFlagged($flagged)
            ->setSent($sent)
            ->setTrashed($trashed)
            ->setPageTitle('Web App - Mailbox')
            ->setHeadTitle('Mailbox')
            ->render('views/pages/main-wide.phtml');
        //$this->view;
    }


    public function RegisterPostAction()
    {
        $request = $_REQUEST;
        $username = strtolower((string)$request['username']);
        $password = md5($request['password']);
        $email = $request['email'];

        $first_name = (string)$request['first_name'];
        $last_name = (string)$request['last_name'];
        $dob_year = $request['dob_year'];
        $dob_month = $request['dob_month'];
        $dob_day = $request['dob_day'];
        $dob = $dob_year.'-'.($dob_month<10?"0{$dob_month}":($dob_month)).'-'.
            ($dob_day<10?"0{$dob_day}":($dob_day));
        $dob = $dob." 00:00:00";

        //die();
        $model = Model::getModel('account')->getDB();
        //$model->test();

        $result = $model->query(
            "SELECT username, password FROM accounts WHERE username = '{$username}' LIMIT 1"
        );
        $set_type = "teacher";
        if($model->numRows($result)){
            $_SESSION['message_code'] = 1001;
        }else{
            $temp_key = md5(date('Y-m-d H:i:s'));
            $akid = strtotime( date('Y-m-d H:i:s'));
            $model->query(
                "INSERT INTO account_keys (akid,account_key,status,key_type) VALUES ({$akid}, '{$temp_key}', 'ok', '{$set_type}')"
            );

            $model->query(
                "
            INSERT INTO accounts (roles, status, is_locked, account_key, username,password,account_email)

            VALUES ('user', 'online', 'no', {$akid}, '{$username}', '{$password}', '{$email}')
           "
            );

            $last_aid = $model->lastInsertedID();



            $model->query(
                "
            INSERT INTO account_details (
            aid,
            first_name,
            last_name,
            date_of_birth,
            email
            )

            VALUES (
            {$last_aid}, 
            '{$first_name}',
            '{$last_name}',
            '{$dob}',
            '{$email}')
           "
            );

            $_SESSION['user_is_loggedin'] = true;
            $GLOBALS['user_is_loggedin'] = true;
            $_SESSION['message_code'] = 'success';
        }

        //echo $model->sql_error();
        //echo "http://webapp.loc/account/register/{$enn}";
        $redirect_url = $this->getUrl('account/dashboard');
        header("Location: {$redirect_url}?trigger=profile", true, 301);
        exit();

    }

    public function UpdateProfilePostAction()
    {
        $request = $_REQUEST;
        $username = strtolower((string)$request['username']);
        $password = md5($request['password']);
        $email = $request['email'];

        $first_name = (string)$request['first_name'];
        $last_name = (string)$request['last_name'];
        $dob_year = $request['dob_year'];
        $dob_month = $request['dob_month'];
        $dob_day = $request['dob_day'];
        $dob = $dob_year.'-'.($dob_month<10?"0{$dob_month}":($dob_month)).'-'.
            ($dob_day<10?"0{$dob_day}":($dob_day));
        $dob = $dob." 00:00:00";

        //die();
        $model = Model::getModel('account')->getDB();
        //$model->test();

        $result = $model->query(
            "UPDATE account_details SET first_name ='{$first_name}', last_name ='{$last_name}', date_of_birth = '{$dob}', email='{$email}'"
        );

        $result = $model->query(
            "Select accounts.id, accounts.username, accounts.password, account_details.*, account_keys.*
              FROM accounts
              LEFT JOIN account_details ON accounts.id=account_details.aid
              LEFT JOIN account_keys ON accounts.account_key=account_keys.akid
              WHERE accounts.username = '{$username}' OR accounts.account_email = '{$username}' LIMIT 1"
        );

        $data = $model->fetchAssoc($result);
        $_SESSION['account_data'] = $data;
        $_SESSION['user_is_loggedin'] = true;
        $GLOBALS['user_is_loggedin'] = true;
        $_SESSION['message_code'] = 1600;
        $redirect_url = $this->getUrl('account/dashboard');
        header("Location: {$redirect_url}?trigger=profile", true, 301);
        exit;

    }

    public function LogoutAction()
    {
        unset($_SESSION['account_data']);
        unset($_SESSION['user_is_loggedin']);
        unset($GLOBALS['user_is_loggedin']);
        $redirect_url = $this->getUrl('');
        header("Location: {$redirect_url}", true, 301);
        exit;
    }

    public function LoginPostAction()
    {
        $model = Model::getModel('account')->getDB();
        $request = $_REQUEST;
        $username = $request['username'];
        $password = md5($request['password']);

        $result = $model->query(
            "Select accounts.id, accounts.username, accounts.password, account_details.*, account_keys.*
              FROM accounts
              LEFT JOIN account_details ON accounts.id=account_details.aid
              LEFT JOIN account_keys ON accounts.account_key=account_keys.akid
              WHERE accounts.username = '{$username}' OR accounts.account_email = '{$username}' LIMIT 1"
        );


        $canLogIn = $model->numRows($result);
        if(isset($canLogIn)){
            $data = $model->fetchAssoc($result);
            if($data['password'] != $password){
                $_SESSION['message_code'] = 1502;
                $redirect_url = $this->getUrl('');
                header("Location: {$redirect_url}", true, 301);
                exit;
            }else{
                $_SESSION['account_data'] = $data;
                $_SESSION['user_is_loggedin'] = true;
                $GLOBALS['user_is_loggedin'] = true;
                $_SESSION['message_code'] = 1600;
                $redirect_url = $this->getUrl('account/dashboard');
                header("Location: {$redirect_url}?trigger=profile", true, 301);
                exit;
            }

        }else{
            $_SESSION['message_code'] = 1501;
            $redirect_url = $this->getUrl('');
            header("Location: {$redirect_url}", true, 301);
            exit;
        }


    }

    public function HelpPostAction()
    {
        $model = Model::getModel('account')->getDB();
        $request = $_REQUEST;
        $purpose = $request['purpose'];
        $subject = $request['subject'];
        $comment = $request['comment'];
        $inqdate = date('Y-m-d H:i:s');
        $aid = (int)$_SESSION['account_data']['id'];
        $result = $model->query("SELECT 1 FROM `inquery` LIMIT 1");

       if ($result == false) {
           $model->query("CREATE TABLE `inquiry` (
            iid INT(11) AUTO_INCREMENT PRIMARY KEY,
            aid INT(11) NOT NULL,
            purpose VARCHAR(30) NOT NULL,
            subject VARCHAR(80) NOT NULL,
            comment VARCHAR(120),
            inquiry_date TIMESTAMP
            )"
           );
       }
           $model->query(
               "
            INSERT INTO inquiry (
            iid,
            aid,
            purpose,
            subject,
            comment,
            inquiry_date
            )

            VALUES (
            null,
            {$aid},
            '{$purpose}', 
            '{$subject}',
            '{$comment}',
            '{$inqdate}')
           "
           );
           $_SESSION['message_code'] = 1600;
           $redirect_url = $this->getUrl('account/dashboard');
           header("Location: {$redirect_url}?trigger=help&submit=contactus", true, 301);
           exit;
    }

    public function NewClassEntryAction()
    {
        /** @var Schedule $model */
        $model = Model::getModel('schedule')->getDB();
        $model->checkIfTableExists($model->loadDB());

        $request = $_REQUEST;
        $title = $request['entry_title'];
        $description = $request['entry_description'];
        $entryFrom = date('Y-m-d H:i:s', $request['entry_class_from']);
        $entryTo = date('Y-m-d H:i:s', $request['entry_class_to']);

        $aid = (int)$_SESSION['account_data']['id'];

        $model->query(
            "
            INSERT INTO schedule (
            sid,
            aid,
            entry_title,
            entry_description,
            entry_class_from,
            entry_class_to
            )

            VALUES (
            null,
            {$aid},
            '{$title}', 
            '{$description}',
            '{$entryFrom}',
            '{$entryTo}')
           "
        );

        $_SESSION['message_code'] = 1600;
        $redirect_url = $this->getUrl('account/dashboard');
        header("Location: {$redirect_url}", true, 301);
        exit;
    }
}
