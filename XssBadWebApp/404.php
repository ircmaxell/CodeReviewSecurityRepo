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

require_once 'bootstrap.php';

header('Status: 404 Not Found');
$request = new \XssBadWebApp\Utilities\Request($_GET, $_POST, $_SERVER);
$view = new \XssBadWebApp\Views\TwigView('404_error');
$view->assign('referrer', $request->server('HTTP_REFERRER'));
$view->assign('ipAddress', $request->ipAddress());
$view->assign('url', $request->server('REQUEST_URI'));
$view->assign('action', '');
$view->render();
