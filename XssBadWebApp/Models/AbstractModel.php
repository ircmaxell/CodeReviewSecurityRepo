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

abstract class AbstractModel {
    
    protected static $dataFile = null;
    protected static $modelName = '';
    
    protected $id = '';
    protected $name = '';
    protected $location = '';
    protected $greeting = '';
    
    /**
     *
     * @return \XssBadWebApp\Utilities\DataFile The data file
     */
    public static function getDataFile() {
        if (is_null(static::$dataFile)) {
            static::$dataFile = new DataFile(static::$modelName);
        }
        return static::$dataFile;
    }
    
    public static function has($id) {
        return static::load($id)->getId() == $id;
    }
    
    public static function load($id) {
        $model = null;
        if ($id) {
            $model = static::getDataFile()->get($id);
        }
        return $model ? $model : new static;
    }
    
    public static function loadAll($dir = 1) {
        $all = static::getDataFile()->getAll();
        usort(
            $all,
            function($a, $b) use ($dir) {
                if ($a->getId() == $b->getId()) {
                    return 0;
                }
                return ($a->getId() < $b->getId()) ? -1 * $dir : $dir;
            }
        );
        return $all;
    }
    
    abstract public function asArray();

    abstract public function getId();
    
    public function save() {
        static::getDataFile()->set($this->getId(), $this);
    }

}