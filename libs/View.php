<?php
require_once 'components/IndexComponent.php';
class View
{
    protected $message;
    protected $message_type;
    protected $view;
    protected  $page_title;
    protected  $head_title;
    protected $settings;

	public function __construct()
	{
        $config = $this->getConfig();
        $this->settings = $config->settings;
	}

    /**
     * @return View
     */

    public function getContent(){
        return $this;
    }

    /**
     * @param $viewScript
     * @return View
     */
    public function render($viewScript)
	{
		require($viewScript.'');
        return $this;
	}


    /**
     * @return string
     */

	public function getMessage(){
	    if($this->message)
        return array("message"=>$this->message, "type"=>$this->message_type );
	    else return false;
    }

    /**
     * @param $message
     * @return View
     */

    public function setMessage($message, $type = 'success'){
        unset($_SESSION['global_message']);
        unset($_SESSION['message_code']);
        $this->message_type = $type;
        $this->message = $message;
        return $this;
    }

    /**
     * @param $value
     * @return View
     */

    public function setView($value){
        $this->view = $value;
        return $this;
    }

    /**
     * @return string
     */

    public function getView(){
        return $this->view;
    }


    /**
     * @param $value
     * @return View
     */

    public function setPageTitle($value){
        $this->page_title = $value;
        return $this;
    }

    /**
     * @return string
     */

    public function getPageTitle(){
        return $this->page_title ? $this->page_title : 'Webapp Protoype';
    }

    public function setHeadTitle($value){
        $this->head_title = $value;
        return $this;
    }

    /**
     * @return string
     */

    public function getHeadTitle(){
        return $this->head_title ? $this->head_title : false;
    }

    public function htmlBlock($block_name){
        $view = $this->view;
        switch($block_name){
            case "head":
            case "header":
            case "footer":
                $this->setView($block_name)
                    ->render("views/index/block/{$block_name}.phtml");
                break;
            default:
                $this->setView($block_name)
                    ->render("views/blocks/{$view}/{$block_name}.phtml");
        }

    }

    public function getBlock($block_name){
        $this->htmlBlock($block_name);
        return $this;
    }

    public function getConfig(){
        return $GLOBALS['config'];
    }

    public function getUrl($link){
        return $GLOBALS['base_url'].$link;
    }
}
