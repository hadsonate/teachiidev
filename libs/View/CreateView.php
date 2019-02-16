<?php
require_once 'libs/View.php';
require_once 'components/Form/CreateComponent.php';
require_once 'models/Admin.php';

class CreateView extends View
{

    protected $step;

    public function setStep($value){
        $this->step = $value;
        return $this;
    }

    public function __construct()
    {
        parent::__construct();

    }
    public function htmlCreateForm(){
        $form = new CreateComponent();
        $step = $this->step;
        $form->setView('create')
            ->render("views/blocks/admin/create{$step}.phtml");
    }


    public function getContent(){
        $this->htmlCreateForm();
        return $this;
    }

}
