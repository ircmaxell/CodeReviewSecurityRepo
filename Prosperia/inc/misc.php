<?php

function selfURL()
{
    $s = empty($_SERVER["HTTPS"]) ? ''
        : ($_SERVER["HTTPS"] == "on") ? "s"
        : "";
    
    $protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0,
        strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")).$s;
    
    $port = ($_SERVER["SERVER_PORT"] == "80") ? ""
        : (":".$_SERVER["SERVER_PORT"]);
        
    return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
}

function generateRandomChars($length, $charset = null)
{
    if (!isset($charset))
        $charset = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    
    $random = null;
    
    for ($j = 0; $j <= $length; $j++)
    {
        $random .= $charset[rand(0, strlen($charset) - 1)];
    }
    
    return $random;
}