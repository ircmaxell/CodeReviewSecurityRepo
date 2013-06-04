<?php
require_once "lib/Prosperia/bootstrap.php";

use Prosperia\Tokn\ToknFile as ToknFile;
use Prosperia\Stor as Stor;
use Prosperia\Stor\StorFromFile as StorFromFile;
use Prosperia\Thumbnail as Thumbnail;

if (!isset($_REQUEST['token']) || empty($_REQUEST['token']) ||
    !isset($_REQUEST['key']) || empty($_REQUEST['key']))
{
    header("HTTP/1.1 400 Bad Request");
    echo "<span style=\"color: red; font-weight: bold; font-size: 24pt;\">400 Bad Request</span><br />";
    echo "<br />";
    echo "Your browser sent a request that could not be understood.";
    exit;
}

if (file_exists("var/tokn/".$_REQUEST['token']))
{
    $token = new ToknFile($_REQUEST['token']);
    
    if (file_exists("var/stor/".$token->getReference()))
    {
        $stor = new Stor(new StorFromFile("var/stor/".$token->getReference()));
        
        if ($_REQUEST['key'] == $stor->getSecretKey())
        {
            $thumbnail = new Thumbnail($stor);
            
            unlink("var/stor/".$token->getReference());
            unlink("var/tokn/".$token->getName());
            
            echo "<span style=\"color: red; font-weight: bold; font-size: 24pt;\">File deleted</span><br />";
            echo "<br />";
            echo $thumbnail->html();
            echo "<br />";
            echo "The image you wanted delete has been successfully deleted from the server.";
            exit;
        }
        else
        {
            header("HTTP/1.1 403 Forbidden");
            echo "<span style=\"color: red; font-weight: bold; font-size: 24pt;\">403 Forbidden</span><br />";
            echo "<br />";
            echo "You don't have permission to access the requested resource.";
            exit;
        }
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