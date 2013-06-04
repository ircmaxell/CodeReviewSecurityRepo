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
 * @package    Models
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @copyright  2011 The Authors
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 */

namespace XssBadWebApp\Models;

use XssBadWebApp\Utilities\Security;

class User extends AbstractModel {
    
    protected $name = '';
    protected $password = '';
    protected $registered = 0;
    
    protected static $modelName = 'User';
    
    private $algo = 'sha256';
    private $cycles = 2;
    private $iterations = 5000;
    private $salt = '';
    
    public function asArray() {
        return array(
            'name' => $this->name,
            'password' => $this->password,
            'registered' => $this->registered
        );
    }
    
    public function checkPassword($password) {
        $test = Security::PBKDF2($password, $this->salt, $this->algo, $this->cycles, $this->iterations);
        return $this->password == $test;
    }
    
    public function getId() {
        return $this->name;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function isRegistered() {
        return $this->registered == 1;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setPassword($new) {
        $this->salt = Security::makeRandomString(10);
        $this->password = Security::PBKDF2(
            $new, 
            $this->salt, 
            $this->algo, 
            $this->cycles, 
            $this->iterations
        );
    }
    
    public function setRegistered($new) {
        $this->registered = $new ? 1 : 0;
    }
    
}