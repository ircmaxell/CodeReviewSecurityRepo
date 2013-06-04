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

use \RegexIterator;
use \FilesystemIterator;
use \StdClass;

class DataFile {
    
    protected $dataPath = '';
    protected $prefix = 'default';
    
    public function __construct($prefix = 'default', $path = PATH_DATA) {
        $this->dataPath = $path;
        $this->prefix = $prefix;
    }
    
    public function get($name) {
        if (($obj = $this->getRaw($name))) {
            return $obj->data;
        }
        return false;
    }
    
    public function getAll() {
        $items = array();
        foreach ($this->getAllRaw() as $row) {
            $items[] = $row->data;
        }
        return $items;
    }
    
    public function getAllRaw() {
        $it = new RegexIterator(
            new FilesystemIterator($this->dataPath . '/' . $this->getCleanPrefix()),
            '/.data$/',
            RegexIterator::MATCH,
            RegexIterator::USE_KEY 
        );
        $ret = array();
        foreach ($it as $file) {
            $ret[] = unserialize(file_get_contents($file));
        }
        return $ret;
    }
    
    public function getRaw($name) {
        if ($this->has($name)) {
            return unserialize(file_get_contents($this->makeFileName($name)));
        }
        return false;
    }
    
    public function has($name) {
        $file = $this->makeFileName($name);
        return is_file($file);
    }
    
    public function set($name, $data) {
        $file = $this->makeFileName($name);
        $obj = new StdClass();
        $obj->name = $name;
        $obj->data = $data;
        file_put_contents($file, serialize($obj));
    }
    
    protected function getCleanPrefix() {
        return preg_replace('/[^a-z0-9]/i', '', $this->prefix);
    }
    
    protected function makeFileName($name) {
        $path = $this->dataPath . '/' . $this->getCleanPrefix() . '/';
        $name = md5($name);
        $path .= $name . '.data';
        return $path;
    }
    
}