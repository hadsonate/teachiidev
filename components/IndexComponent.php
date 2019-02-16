<?php
require_once 'libs/View.php';
class IndexComponent extends View
{

    protected $memos;
    public function __construct()
    {
        parent::__construct();
    }


    public function setMemos($memos){
        $this->memos = $memos;
        return $this;
    }

    public function getMemos(){
        return $this->memos;
    }

}
