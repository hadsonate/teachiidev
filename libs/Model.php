<?php

class Model
{
	public function __construct()
    {
    }

    public function getModel($model){
	    $model = ucfirst($model);
        require_once('models/'.$model.'.php');
        $object = new $model();
        return $object;
    }
}