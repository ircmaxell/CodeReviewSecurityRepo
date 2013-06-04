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
		<title>Login</title>
                <style>
					{literal}
                    .error {
                        color: #ff0000;
                        border: 1px solid #ff0000;
                    }
					{/literal}
                </style>
	</head>
	<body>
		{if $message}<h3>{$message}</h3>{/if}
        <form action="index.php?controller=User&action=doRegister" method="post">
            <table>
                <tr>
    				<td>User Name: </td>
    				<td><input name="username" value="" /></td>
    			</tr>
                <tr>
    				<td>Password: </td>
    				<td><input name="password" value="" type="password" /></td>
    			</tr>
				<tr>
    				<td>Confirm Password: </td>
    				<td><input name="conf_password" value="" type="password" /></td>
    			</tr>
    		</table>
            <input type="hidden" name="{$csrf}" value="1" />
            <input type="submit" name="login" value="Login" />
        </form>

	</body>
</html>