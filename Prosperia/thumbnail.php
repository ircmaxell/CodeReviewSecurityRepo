<?php
require_once "lib/Prosperia/bootstrap.php";
require_once "inc/misc.php";

use Prosperia\Tokn\ToknFile as ToknFile;
use Prosperia\Stor as Stor;
use Prosperia\Stor\StorFromFile as StorFromFile;
use Prosperia\Thumbnail as Thumbnail;

if (!isset($_REQUEST['token']) || empty($_REQUEST['token']))
{
    header("HTTP/1.1 400 Bad Request");
    echo "<span style=\"color: red; font-weight: bold; font-size: 24pt;\">400 Bad Request</span><br />";
    echo "<br />";
    echo "Your browser sent a request that could not be understood.";
    exit;
}

if (!isset($_REQUEST['size']) || empty($_REQUEST['size']))
{
    $width = null;
}
else
{
    $width = $_REQUEST['size'];
}

if (file_exists("var/tokn/".$_REQUEST['token']))
{
    $token = new ToknFile($_REQUEST['token']);
    
    if (file_exists("var/stor/".$token->getReference()))
    {
        $stor = new Stor(new StorFromFile("var/stor/".$token->getReference()));
        $thumbnail = new Thumbnail($stor, $width);
        
        header("Content-Disposition: inline");
        header("Content-Type: " . $stor->getType());
        header("Content-Length: " . $thumbnail->size());
        
        set_time_limit(0);
        print $thumbnail->raw();
        
        exit;
    }
    else
    {
        header("HTTP/1.1 410 Gone");
        echo "<span style=\"color: red; font-weight: bold; font-size: 24pt;\">410 Gone</span><br />";
        echo "<br />";
        echo "The requested URL is no longer available on this server.";
        exit;
    }
}
else
{
    header("HTTP/1.1 404 Not Found");
    echo "<span style=\"color: red; font-weight: bold; font-size: 24pt;\">404 Not Found</span><br />";
    echo "<br />";
    echo "The requested URL was not found on the server.";
    exit;
}

header("HTTP/1.1 500 Internal Server Error");
echo "<span style=\"color: red; font-weight: bold; font-size: 24pt;\">500 Internal Server Error</span><br />";
echo "<br />";
echo "The server encountered an internal error and was unable to complete your request.";
exit;
?>