<?php

namespace Prosperia\Tokn;

class ToknFile implements ITokn
{
    private $name = null;
    private $reference = null;
    
    public function __construct($name)
    {
        $this->name = $name;
        $this->read();
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getReference()
    {
        return $this->reference;
    }
    
    public function read()
    {
        $this->reference = @file_get_contents("var/tokn/".$this->name, false, NULL, -1, 40);
        
        if ($this->reference === FALSE)
        {
            throw new \Exception("Failed to open stream: " . "var/tokn/".$this->name);
        }
    }
    
    public function write()
    {
        // Do nothing.
    }
}