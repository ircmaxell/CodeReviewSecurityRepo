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
        <title>500 - Internal Server Error</title>
    </head>
    <body>
        <h1>Error: 500 - Internal Server Error</h1>
        <h3>There was a problem rendering your page</h3>
        {$request->getRawArray('post')|var_dump}
        <h2>{$exception->getMessage()}</h2>
    </body>
</html>