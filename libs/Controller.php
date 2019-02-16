<?php


class Controller
{
    protected $view;
    protected $action;
    protected $controller;
    protected $params = array();

	public function __construct($prefix = '')
	{
        $prefix = $prefix?:"index";
	    $dir = $prefix ? 'libs/View/' : '';
        $prefix = ucfirst($prefix);
        $view_class = $prefix.'View';
        $dir.$view_class.'.php';
        if (file_exists($dir.$view_class.'.php')) {
            require_once $dir.$view_class.'.php';
            $this->view = new $view_class();
        }

	}

	public function setView($value){
        $this->action = $value;

    }

    public function getView(){
        return $this->view;
    }


    public function setActionName($value){
        $this->action = $value;
    }

    public function getActionName(){
        return $this->action;
    }

    public function setControllerName($value){
        $this->controller = $value;
    }

    public function getControllerName(){
        return $this->controller;
    }

    // must be array
    public function setParams($value){
	    // add array condition
        $this->params = $value;
    }

    public function getParams(){
        return $this->params;
    }

    public function getUrl($link){

        return $GLOBALS['base_url'].$link;
    }

}
