<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;



class MiniBlogApplication extends Application
{
    public function test(){
        return 'text';
        exit;
    }
    protected $login_action = array('account','signin');

    public function getRootDir()
    {
        // create a log channel
        $log = new Logger('name');

        $log->pushHandler(new StreamHandler(__DIR__.'/your.log', Logger::WARNING));
        return dirname(__FILE__);
    }

    protected function registerRouters(){
        // create a log channel
        $log = new Logger('name');

        $log->pushHandler(new StreamHandler(__DIR__.'/your.log', Logger::WARNING));
        return array();
    }

    protected function configure(){
        // create a log channel
        $log = new Logger('name');

        $log->pushHandler(new StreamHandler(__DIR__.'/your.log', Logger::WARNING));

        $this->db_manager->connect('master',array(
            'dsn' => 'mysql:dbname=blogtest;host=localhost',
            'user' => 'root',
            'password' => '',
        ));
    }
}