<?php

namespace Prosperia;

require_once 'lib/Autoloader.php';
$autoloader = new \Autoloader(__NAMESPACE__, dirname(__DIR__));
$autoloader->register();

require_once 'inc/misc.php';

if (!is_writable("var") || !is_writable("var/stor") || !is_writable("var/tokn"))
{
    header("HTTP/1.1 500 Internal Server Error");
    echo "<span style=\"color: red; font-weight: bold; font-size: 24pt;\">500 Internal Server Error</span><br />";
    echo "<br />";
    echo "The server encountered an internal error and was unable to complete your request.";
    echo "<br />";
    echo "Please check the permissions of <tt>var</tt>, <tt>var/stor</tt> and <tt>var/tokn</tt>. It seems that write flags are missing.";
    exit;
}

if (!extension_loaded("gd"))
{
    header("HTTP/1.1 500 Internal Server Error");
    echo "<span style=\"color: red; font-weight: bold; font-size: 24pt;\">500 Internal Server Error</span><br />";
    echo "<br />";
    echo "The server encountered an internal error and was unable to complete your request.";
    echo "<br />";
    echo "The <tt>GD</tt> PHP extension was not found on the server.";
    exit;
}