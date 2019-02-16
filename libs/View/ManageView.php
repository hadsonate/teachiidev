<?php
require_once 'libs/View.php';
require_once 'components/Form/ManageComponent.php';
require_once 'models/Admin.php';

class ManageView extends View
{

    public function __construct()
    {
        parent::__construct();

    }

    public function htmlManageForm(){
        $form = new ManageComponent();
        $form->setView('manage')
            ->render('views/blocks/admin/manage.phtml');
    }


    public function getContent(){
        $this->htmlManageForm();
        return $this;
    }


}
