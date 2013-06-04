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

class Request {
    
    protected $get = array();
    protected $post = array();
    protected $server = array();
    
    public function __construct(array $get, array $post, array $server) {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;
    }
    
    public function get($name, $default = null) {
        return $this->getArray($name, $default, $this->get);
    }
    
    public function getRawArray($scope) {
        return isset($this->$scope) ? $this->$scope : array();
    }
    
    public function ipAddress() {
        return $this->server('HTTP_X_FORWARDED_FOR', $this->server('REMOTE_ADDR'));
    }

    public function isPost() {
        return !empty($this->post);
    }
    
    public function post($name, $default = null) {
        return $this->getArray($name, $default, $this->post);
    }
    
    public function server($name, $default = null) {
        return $this->getArray($name, $default, $this->server);
    }
    
    public function set($name, $value, $scope = 'get') {
        if (!isset($this->$scope)) {
            throw new InvalidArgumentException('Scope Not Supported');
        }
        $var =& $this->$scope;
        $var[$name] = $value;
    }
    
    protected function getArray($name, $default, $array) {
        return isset($array[$name]) ? $array[$name] : $default;
    }
    
}
