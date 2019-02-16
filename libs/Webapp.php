<?php

class Webapp
{

    protected $view;
    protected $action;
    protected $controller;
    protected $params = array();
    protected $config = array();

	public function __construct()
	{

        $_SESSION['message_code'] = isset($_SESSION['message_code'])?:"";
	    if(!isset($_SESSION['account_data']) || $_SESSION['account_data'] === false){
            unset($_SESSION['user_is_loggedin']);
        }

        $GLOBALS['config'] = $config = new Config();

        $this->config = $config->getConfig();
        $base_url = $this->getBaseUrl(false);
        if (!empty($_SERVER['HTTPS'])){
            $base_url = $this->getBaseUrl(true);
        }
        $GLOBALS['base_url'] = $base_url;

        if(!isset($_SESSION['account_data'])) $_SESSION['account_data'] = false;
        $uri = $_SERVER['REQUEST_URI'];
        $request_uri = str_replace("/" . $this->config['base_url_name'],"",$uri);
        $clean_token = explode('?',$request_uri);
		$tokens = explode('/',rtrim($clean_token[0], '/'));
        if(!isset($_SESSION['user_is_loggedin'])) $_SESSION['user_is_loggedin'] = false;

        if (isset($tokens[2])) {
            $this->action = $tokens[2];
        } else {
            $this->action = 'Index';
        }
		if(is_array($tokens)){
		    $controllerName = isset($tokens[1])?ucfirst($tokens[1]):'';
		    $this->controller = $controllerName;
            $controllerName = $controllerName == false ? 'IndexController' : $controllerName."Controller";
        }else{
            $this->controller = 'Index';
            $controllerName = 'IndexController';
        }

		if (strtolower($this->controller) == 'ajax') {
		    $ajaxFile = 'controllers/ajax/' . $this->action;
            require_once($ajaxFile);
        } elseif(strtolower($this->controller) != 'pages'
            && $this->action != "login"
            && $this->action != "register"
            && $this->action != "logout"
            && strtolower($this->action) != "loginpost"
            && strtolower($this->action) != "registerpost"
            && $_SESSION['user_is_loggedin'] === false){
            //allowed all
            //$_SESSION['message_code'] = 1500;
            //header("Location:{$base_url}account/login", true, 301);
            //exit;
        }elseif ($_SESSION['user_is_loggedin'] === true &&
            ($this->action == "login"
            or $this->action == "register")){
            header("Location: {$base_url}account/dashboard", true, 301);
            exit;
        }


        try{
            if (file_exists('controllers/'.$controllerName.'.php')) {
                require_once('controllers/'.$controllerName.'.php');
                if ($this->action !== "Index") {
                    $controller = new $controllerName($this->action);
                    $actionName = $this->action . 'Action';
                    if(isset($tokens[3])) {
                        $controller->{$actionName}($tokens[3]);
                    }
                    else {
                        $controller->{$actionName}();
                    }
                }
                else
                {
                    // default action
                    $controller = new $controllerName();
                    $controller->IndexAction();
                }
            }
            else {

                require_once('controllers/ErrorController.php');
                $controllerName = 'ErrorController';
                $controller = new $controllerName;

                $controller->IndexAction();
            }
            $controller->setControllerName($this->controller);
            $controller->setActionName($this->action);
            //$controller->setView();
        }catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            require_once('controllers/ErrorController.php');
            $controllerName = 'Error';
            $controller = new $controllerName;
            $controller->IndexAction();
        }

	}

    public function getConfig(){
        return $this->config;
    }

    public function getBaseUrl($secure = false){
        if($secure){
            return $this->config['secure_base_url'];
        }else{
            return $this->config['unsecure_base_url'];
        }

    }
}
