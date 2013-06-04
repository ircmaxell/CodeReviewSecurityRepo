<?php

namespace Prosperia\Stor;

class StorToFile implements IStorWriter
{
    private $handle = null;
    
    public function __construct($file)
    {
        $this->handle = @fopen($file, "w+b");
        
        if ($this->handle === FALSE)
        {
            throw new \Exception("Failed to open stream: " . $file);
        }
    }
    
    public function write(array $stordata)
    {
        fwrite($this->handle, $stordata['originalFilename'] . "\x01");
        fwrite($this->handle, $stordata['type'] . "\x02");
        fwrite($this->handle, $stordata['size'] . "\x03");
        fwrite($this->handle, $stordata['hash'] . "\x04");
        fwrite($this->handle, $stordata['secretKey'] . "\x05");
        
        fwrite($this->handle, $stordata['content'], (int)$stordata['size']);
    }
    
    public function __destruct()
    {
        fclose($this->handle);
    }
}