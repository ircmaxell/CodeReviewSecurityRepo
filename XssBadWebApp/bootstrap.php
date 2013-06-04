<?php
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
 * @package    Core
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @copyright  2011 The Authors
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 */

namespace XssBadWebApp;

define('PATH_BASE', __DIR__);

define('PATH_DATA', PATH_BASE . '/data');

define('PATH_TEMPLATES', PATH_BASE . '/templates');

define('PATH_TEMPLATE_CACHE', PATH_BASE . '/_cache/templates_c');

spl_autoload_register(function($className) {
    $nsLen = strlen(__NAMESPACE__);
    if (substr($className, 0, $nsLen + 1) == __NAMESPACE__ . '\\') {
        $path = strtr(substr($className, $nsLen), '\\', '/') . '.php';
        if (file_exists(PATH_BASE . $path)) {
            require_once PATH_BASE . $path;
        }
    }
});

$_SESSION = array();