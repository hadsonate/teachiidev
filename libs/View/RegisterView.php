<?php
require_once 'libs/View.php';
require_once 'components/Form/RegisterComponent.php';
require_once 'models/Account.php';

class RegisterView extends View
{

    public function __construct()
    {
        //echo "Register View Block";
        parent::__construct();

    }


    public function htmlRegisterForm(){
        $form = new RegisterComponent();
        $form->setView('register')
            ->render('views/blocks/account/register.phtml');
    }


    public function getContent(){
        $this->htmlRegisterForm();
        return $this;
    }



}