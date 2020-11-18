<?php

class ClassLoader
{
    protected $dirs;

    public function register()
    {
        sql_autoload_register(array($this,'loadClass'));
    }

    public function registerDir($dir)
    {
        $this->dirs[] = $dirs;
    }

    public function loadClass()
    {
        foreach($this->dirs as $dir) {
            $file = $dir . '/' . $class . '.php';
            if(is_readable($file)){
                require $file;
                return;
            }
        }
    }
}