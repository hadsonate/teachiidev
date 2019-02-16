<?php
require_once 'libs/View.php';
require_once 'components/IndexComponent.php';
//require_once 'models/Account.php';

class IndexView extends View
{
    protected $content;


    public function __construct()
    {
        parent::__construct();

    }

    public function htmlIndex(){

        $html = new IndexComponent();
        $html->setView('index')
            ->render('views/index/index.phtml');
        $this->content = $html;
    }




    public function getContent(){
        $this->htmlIndex();
        return $this;
    }




}
