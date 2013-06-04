<?php

namespace Prosperia\Stor;

class StorFromData implements IStorLoader
{
    private $stordata = array();
    
    public function __construct($originalFilename, $type, $content)
    {
        $this->stordata = array(
            'originalFilename'  =>  $originalFilename,
            'type'  =>  $type,
            'size'  =>  (int)strlen($content),
            'hash'  =>  sha1($content),
            'content'   =>  $content,
            'secretKey' =>  generateRandomChars(16)
        );
    }
    
    public function fetch()
    {
        return $this->stordata;
    }
    
    public function load()
    {
        // Do nothing.
    }
}