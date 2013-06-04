<?php

namespace Prosperia\Tokn;

class ToknData implements ITokn
{
    private $name = null;
    private $reference = null;
    
    public function __construct($name, $reference)
    {
        $this->name = $name;
        $this->reference = $reference;
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
        // Do nothing.
    }
    
    public function write()
    {
        $result = @file_put_contents("var/tokn/".$this->name, $this->reference . "\n");
        
        if ($result === FALSE)
        {
            throw new \Exception("Failed to open stream: " . "var/tokn/".$this->name);
        }
    }
}