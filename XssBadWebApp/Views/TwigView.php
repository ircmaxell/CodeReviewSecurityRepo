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
 * @package    Views
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @copyright  2011 The Authors
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 */

namespace XssBadWebApp\Views;

require_once 'Twig/Autoloader.php';
\Twig_Autoloader::register();

use \Twig_Loader_Filesystem;
use \Twig_Environment;

class TwigView implements View {
    
    protected $data = array();
    protected $template = null;
    
    public function __construct($templateName) {
        $loader = new Twig_Loader_Filesystem(PATH_TEMPLATES);
        $twig = new Twig_Environment($loader);
        $this->template = $twig->loadTemplate($templateName . '.html');
    }
    
    public function assign($name, $value) {
        $this->data[$name] = $value;
    }
    
    public function assignAll(array $values) {
        $this->data = $values + $this->data;
    }
    
    public function render() {
        $this->template->display($this->data);
    }
    
}

