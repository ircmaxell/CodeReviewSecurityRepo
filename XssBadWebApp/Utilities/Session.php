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
 * @package    Utilities
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @copyright  2011 The Authors
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 */

namespace XssBadWebApp\Utilities;

class Session {
    
    protected $sessionName = 'XssBadWebApp';
    
    public function __construct($sessionName = 'XssBadWebApp') {
        $this->sessionName = $sessionName;
        $this->setup();
        $this->start();
    }
    
    public function destroy() {
        $_SESSION = array();
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        session_destroy();
    }
    
    public function get($name, $default = null) {
        return $this->has($name) ? $_SESSION[$name] : $default;
    }
    
    public function getId() {
        return session_id();
    }
    
    public function has($name) {
        return isset($_SESSION[$name]);
    }
    
    public function regenerate() {
        session_regenerate_id();
    }
    
    public function set($name, $value) {
        $_SESSION[$name] = $value;
    }
    
    public function start() {
        session_start();
    }
    
    protected function setup() {
        if ($this->getId()) {
            $this->destroy();
        }
        session_name($this->sessionName);
    }
    
}
