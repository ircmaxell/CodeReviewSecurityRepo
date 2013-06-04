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

require_once 'Smarty/Smarty.class.php';

use \Smarty;

class SmartyView implements View {
    
    protected $smarty = null;
    
    protected $templateName = '';
    
    public function __construct($templateName) {
        $this->templateName = $templateName . '.tpl';
        $this->smarty = new Smarty();
        $this->smarty->template_dir = PATH_TEMPLATES;
        $this->smarty->compile_dir = PATH_TEMPLATE_CACHE;
    }
    
    public function assign($name, $value) {
        $this->smarty->assign($name, $value);
    }
    
    public function assignAll(array $values) {
        foreach ($values as $key => $value) {
            $this->assign($key, $value);
        }
    }
    
    public function render() {
        $this->smarty->display($this->templateName);
    }
    
}

