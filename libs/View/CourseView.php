<?php
require_once 'libs/View.php';
require_once 'components/CourseComponent.php';
#require_once 'models/Account.php';

class CourseView extends View
{
    public function __construct()
    {
        parent::__construct();

    }

    public function htmlCourse(){
        $html = new CourseComponent();
        $html->setView('course')
            ->render('views/blocks/course/classlist.phtml');
    }


    public function getContent(){
        $this->htmlCourse();
        return $this;
    }



}
