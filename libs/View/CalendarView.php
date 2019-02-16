<?php
require_once 'libs/View.php';
require_once 'libs/View.php';
require_once 'components/Page/CalendarComponent.php';

class CalendarView extends View
{

    public function __construct()
    {
        parent::__construct();

    }



    public function htmlCalendarBlock(){
        $form = new CalendarComponent();
        $form->setView('create')
            ->render('views/blocks/page/calendar.phtml');
    }


    public function getContent(){
        $this->htmlCalendarBlock();
        return $this;
    }

}
