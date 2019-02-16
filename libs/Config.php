<?php

class Config
{
    var $settings = array();

    /**
     * set database configuration
     * @return array
     */

    function getConfig()
    {
        $this->settings['unsecure_base_url'] = 'http://localhost:8888/teachiidev/';
        $this->settings['secure_base_url'] = 'http://localhost:8888/teachiidev/';
        $this->settings['css_dir'] = 'skins/default/css';
        $this->settings['js_dir'] = 'skins/default/js';
        $this->settings['img_dir'] = 'skins/default/images';
        $this->settings['base_url_name'] = explode('/',$this->settings['unsecure_base_url'])[3];
        return $this->settings;
    }
}
