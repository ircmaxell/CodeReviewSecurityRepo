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

use XssBadWebApp\Utilities\DataFile;

class GuestBook extends AbstractModel {
    
    protected static $dataFile = null;
    protected static $modelName = 'GuestBook';
    
    protected $id = '';
    protected $name = '';
    protected $location = '';
    protected $greeting = '';
    
    public static function validate(array $data) {
        $errors = array(
            'location' => 'Location cannot be empty',
            'greeting' => 'Greeting cannot be empty',
        );
        $data += array('location' => '', 'greeting' => '');
        foreach (array('location', 'greeting') as $var) {
            if (strlen($data[$var]) >= 5) {
                unset($errors[$var]);
            }
        }
        return $errors;
    }
    
    public function __construct() {
        $this->id = 1;
        $file = static::getDataFile();
        while ($file->has($this->id)) {
            $this->id++;
        }
    }
    
    public function asArray() {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'greeting' => $this->greeting
        );
    }
    
    public function getGreeting() {
        return $this->greeting;
    }

    public function getId() {
        return $this->id;
    }
    
    public function getLocation() {
        return $this->location;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setGreeting($new) {
        $this->greeting = $new;
    }
    
    public function setLocation($new) {
        $this->location = $new;
    }
    
    public function setName($new) {
        $this->name = $new;
    }

}
