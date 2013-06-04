<?php

class Autoloader
{
    protected $namespace = '';
    protected $path = '';

    public function __construct($namespace, $path)
    {
        $this->namespace = ltrim($namespace, '\\');
        $this->path = rtrim($path, '/\\') . DIRECTORY_SEPARATOR;
    }
    
    public function load($class)
    {
        $class = ltrim($class, '\\');
        
        if (strpos($class, $this->namespace) === 0)
        {
            $subfolders = explode('\\', $class);
            $class = array_pop($subfolders);
            $subfolders[] = '';
            
            $fpath = $this->path . implode(DIRECTORY_SEPARATOR, $subfolders);
            $fpath .= str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
            
            if (file_exists($fpath))
            {
                require $fpath;
            }
        }
    }
    
    public function register()
    {
        return spl_autoload_register(array($this, 'load'));
    }
    
    public function unregister()
    {
        return spl_autoload_unregister(array($this, 'load'));
    }
}