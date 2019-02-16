<?php
require_once 'libs/View.php';
require_once 'components/Form/LoginComponent.php';
require_once 'models/Account.php';

class LoginView extends View
{

    public function __construct()
    {
        //echo "Login View Block";
        parent::__construct();
        //$account = new Account();
        //$account->getDB()->test();

    }

    public function htmlLoginForm(){
        $form = new LoginComponent();
        $form->setView('login')
            ->render('views/blocks/account/login.phtml');
    }


    public function getContent(){
        $this->htmlLoginForm();
        return $this;
    }


}