<?php
require_once 'libs/View.php';
require_once 'components/DashboardComponent.php';
#require_once 'models/Account.php';

class DashboardView extends View
{

    protected $memos;

    public function __construct()
    {
        //echo "Dashboard View Block";
        parent::__construct();

    }

    public function htmlDashboard(){
        $html = new DashboardComponent();
        $html->setView('dashboard')
            ->render('views/blocks/account/dashboard.phtml');
    }


    public function getContent(){
        $this->htmlDashboard();
        return $this;
    }



}
