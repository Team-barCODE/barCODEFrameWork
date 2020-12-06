<?php

class BaseApplication extends Application
{
    protected $login_action = array('acount', 'signin');

    public function test()
    {
        return "こんにちは";
    }

    public function getRootDir()
    {
        return dirname(__FILE__);
    }

    protected function registerRoutes()
    {
        return array();
    }

    protected function configure()
    {
        $this->db_manager->connect('master', array(
            'dsn' => 'mysql:dbname=testblog;host=localhost',
            'user' => 'root',
            'password' => 'root'
        ));
    }
}
