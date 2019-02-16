<?php
require_once 'libs/Controller.php';

class ErrorController extends Controller
{

	public function IndexAction()
	{
		$this->view->setMessage("The controller doesn't exist!");
		$this->view->render('views/pages/error.phtml');
	}
}