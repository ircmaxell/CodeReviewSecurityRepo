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
 * @package    Application
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @copyright  2011 The Authors
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 */

namespace XssBadWebApp\Application;

use \XssBadWebApp\Utilities\Request;
use \XssBadWebApp\Utilities\Session;
use \XssBadWebApp\Models\User as UserModel;

class Application {
    
    protected $request = null;
    protected $session = null;
    
    public function __construct() {
        $this->request = new Request($_GET, $_POST, $_SERVER);
        $this->session = new Session();
    }
    
    public function setup() {
        if (!$this->session->has('user')) {
            $this->session->set('user', new UserModel());
        }
    }
    
    public function run() {
        $controller = $this->findController();
        $view = $controller->dispatch();
        $view->render();
    }
    
    protected function findController() {
        $controller = $this->request->get('controller', 'GuestBook');
        $className = '\XssBadWebApp\Controllers\\' . $controller;
        if (class_exists($className)) {
            return new $className($this->request, $this->session);
        }
        return new \XssBadWebApp\Controllers\GuestBook($this->request, $this->session);
    }
    
}