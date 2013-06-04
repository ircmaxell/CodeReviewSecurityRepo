<?php
require_once "lib/Prosperia/bootstrap.php";

use Prosperia\Tokn\ToknFile as ToknFile;

$tokns = array();
$tokn_references = array();
$stors = array();

echo "<span style=\"color: darkorange; font-weight: bold;\">" .
    "Searching for tokens referencing nonexistant storage objects</span>...<br />\n";

$stale_token_count = 0;
$removed_token_count = 0;

foreach (glob("var/tokn/*") as $tokenpath)
{
    $tokenpath = str_replace("var/tokn/", null, $tokenpath);
    $token = new ToknFile($tokenpath);
    
    $tokns[] = $token->getName();
    $tokn_references[] = $token->getReference();
    
    if (!file_exists("var/stor/".$token->getReference()))
    {
        $stale_token_count++;
        echo "<span style=\"color: darkred; font-weight: bold;\">" .
            "Stale token <i>$tokenpath</i> (referenced <i>" .$token->getReference(). 
            "</i>)</span>";
        
        if (@unlink("var/tokn/".$tokenpath))
        {
            $removed_token_count++;
            echo " <span style=\"color: green; font-weight: bold;\">Deleted.</span><br />\n";
        }
        else
        {
            echo " <span style=\"color: red; font-weight: bold;\">Unable to delete.</span><br />\n";
        }
        
        unset($tokns[array_search($tokenpath, $tokns)]);
        unset($tokn_references[array_search($token->getReference(), $tokn_references)]);
    }
}
echo "<span style=\"color: orange; font-weight: bold;\">Found $stale_token_count " .
    "stale tokens.</span> <span style=\"color: green; font-weight: bold;\">".
    "$removed_token_count removed.</span><br />\n";

echo "<br />\n";
echo "<span style=\"color: darkorange; font-weight: bold;\">" .
    "Searching for storage objects not referenced by any tokens</span>...<br />\n";

$dangling_stor_count = 0;
$removed_stor_count = 0;

foreach (glob("var/stor/*") as $storpath)
{
    $storpath = str_replace("var/stor/", null, $storpath);
    $stors[] = $storpath;
    
    if(array_search($storpath, $tokn_references) === false)
    {
        $dangling_stor_count++;
        echo "<span style=\"color: darkred; font-weight: bold;\">" .
            "Dangling storage object <i>$storpath</i></span>";
        
        if (@unlink("var/stor/".$storpath))
        {
            $removed_stor_count++;
            echo " <span style=\"color: green; font-weight: bold;\">Deleted.</span><br />\n";
        }
        else
        {
            echo " <span style=\"color: red; font-weight: bold;\">Unable to delete.</span><br />\n";
        }
        
        unset($stors[array_search($storpath, $stors)]);
    }
}
echo "<span style=\"color: orange; font-weight: bold;\">Found $dangling_stor_count " .
    "dangling storages.</span> <span style=\"color: green; font-weight: bold;\">".
    "$removed_stor_count removed.</span><br />\n";

?>