<?php
require_once "lib/Prosperia/bootstrap.php";

use Prosperia\Tokn\ToknData as ToknData;
use Prosperia\Stor as Stor;
use Prosperia\Stor\StorFromData as StorFromData;
use Prosperia\Stor\StorToFile as StorToFile;
use Prosperia\Thumbnail as Thumbnail;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Prosperia</title>
    </head>
    <body>
<?php
if ( isset($_FILES['images']) )
{
    echo "\t\t<span style=\"color: darkorange; font-weight: bold;\">Uploading " .count($_FILES['images']['name']).
        " files</span>...<br />\n";
    
    echo "\t\t<table border=\"1\" style=\"width: 100%;\">\n";
    echo "\t\t\t<tr>\n";
    echo "\t\t\t\t<th>Filename</th>\n";
    echo "\t\t\t\t<th>Status</th>\n";
    echo "\t\t\t\t<th>Thumbnail</th>\n";
    echo "\t\t\t\t<th>Retrieve URL</th>\n";
    echo "\t\t\t\t<th>Delete URL</th>\n";
    echo "\t\t\t</tr>\n";
    
    echo "\t\t\t<tr>\n";
    echo "\t\t\t\t<td></td>\n";
    echo "\t\t\t\t<td></td>\n";
    echo "\t\t\t\t<td></td>\n";
    echo "\t\t\t\t<td>(Share this link to whom you want. This will let them see the upload.)</td>\n";
    echo "\t\t\t\t<td>(Use this link to delete your upload. " .
        "<span style=\"color: red; font-weight: bold;\">WARNING! This URL is only shown " .
        "to you once! If you lose it, you lose the ability to delete the file!</span>)</td>\n";
    echo "\t\t\t</tr>\n";
    
    for ($i = 0; $i < count($_FILES['images']['name']); $i++)
    {
        echo "\t\t\t<tr>\n";
        
        $allowed_types = array(
            'image/jpeg',
            'image/png',
            'image/gif'
        );
        
        if (in_array($_FILES['images']['type'][$i], $allowed_types, true))
        {
            $token = new ToknData(generateRandomChars(8), str_shuffle(sha1(time())));
            
            $stor = new Stor(new StorFromData(
                $_FILES['images']['name'][$i],
                $_FILES['images']['type'][$i],
                file_get_contents($_FILES['images']['tmp_name'][$i])
            ));
            
            if ($stor->getSize() !== $_FILES['images']['size'][$i])
            {
                throw new Exception("Content and content size mismatch");
            }
            
            $token->write();
            $stor->write(new StorToFile("var/stor/" . $token->getReference()));
            
            $retrieve_url = str_replace(basename(__FILE__), "g/" . $token->getName(), selfURL());
            
            $thumbnail = new Thumbnail($stor);
            $thumbnail_url = str_replace(basename(__FILE__), "t/" . $token->getName(), selfURL());
            
            $delete_url = str_replace(basename(__FILE__), "d/" . $token->getName() . "/" .
                $stor->getSecretKey(), selfURL());
            
            echo "\t\t\t\t<td>" .$_FILES['images']['name'][$i]. "</td>\n";
            echo "\t\t\t\t<td style=\"color: darkgreen; font-weight: bold;\">Successfully uploaded</td>\n";
            echo "\t\t\t\t<td><a href=\"$thumbnail_url\" target=\"_blank\">" . $thumbnail->html() . "</a></td>\n";
            echo "\t\t\t\t<td><a href=\"$retrieve_url\" target=\"_blank\">$retrieve_url</a></td>\n";
            echo "\t\t\t\t<td><a href=\"$delete_url\" target=\"_blank\">$delete_url</a></td>\n";
        }
        else
        {
            echo "\t\t\t\t<td>" .$_FILES['images']['name'][$i]. "</td>\n";
            echo "\t\t\t\t<td style=\"color: red; font-weight: bold;\">Won't upload</td>\n";
            echo "\t\t\t\t<td colspan=\"3\">" .
                "Type <i>" .$_FILES['images']['type'][$i]. "</i> is not allowed." . "</td>\n";
        }
        
        echo "\t\t\t</tr>\n";
    }
    echo "\t\t</table>\n";
    
    echo "\t\t<span style=\"color: darkgreen; font-weight: bold;\">Uploading finished.</span><br />\n";
}
else
{
?>
        <form method="POST" action="index.php" enctype="multipart/form-data">
            <label for="images[]">Images to upload: <small>(you can select multiple files)</small></label>
                <input type="file" name="images[]" multiple=""/>
            <input type="submit" value="Upload"/>
        </form>
<?php
}
?>
    </body>
</html>