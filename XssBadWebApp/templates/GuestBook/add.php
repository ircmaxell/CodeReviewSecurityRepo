<!--
/**
 * A Bad Web Application.  Note that this is intentionally vulnerable to several
 * security vulnerabilities.  DO NOT INSTALL THIS ON A PUBLIC SERVER!
 * 
 * WARNING: FOR RESEARCH USE ONLY!  DO NOT USE!
 * 
 * DISCLAIMER: This application is for education use only.  Installing it on a 
 * public facing server will expose the server to several security vulnerabilities
 * The author takes absolutely no resposibility for any damage that may occur
 * from the use or misuse of any of this code.
 *
 * PHP version 5.3
 *
 * @category   XssBadWebApp
 * @package    Templates
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @copyright  2011 The Authors
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 */
-->
<html>
	<head>
		<title>Add A Message!!</title>
                <style>
                    .error {
                        color: #ff0000;
                        border: 1px solid #ff0000;
                    }
                </style>
	</head>
	<body>
        <form action="index.php?action=save" method="post" id="addform">
            <table>
                <tr>
    				<td>Location: </td>
    				<td><input id="location" name="gb_item[location]" value="<?php echo $location; ?>" <?php if (isset($errors['location'])) { ?>class="error"<?php } ?>/></td>
    			</tr>
                <tr>
    				<td>Greeting: </td>
                    <td><textarea id="greeting" name="gb_item[greeting]" <?php if (isset($errors['greeting'])) { ?>class="error"<?php } ?>><?php echo $greeting; ?></textarea></td>
    			</tr>
    		</table>
            <input type="hidden" name="gb_item[id]" value="<?php echo $id; ?>" />
            <input type="hidden" name="<?php echo $csrf; ?>" value="1" />
            <input type="submit" name="Save" value="Save" />
        </form>

	</body>
</html>