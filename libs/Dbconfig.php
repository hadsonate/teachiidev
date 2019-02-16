<?php

class Dbconfig
{
    var $settings = array();

    /**
     * set database configuration
     * @return array
     */

    function getConfig()
    {
        $this->settings['dbhost'] = 'localhost';
        $this->settings['dbname'] = 'teachii';
        $this->settings['dbusername'] = 'root';
        $this->settings['dbpassword'] = '';

        return $this->settings;
    }
}
