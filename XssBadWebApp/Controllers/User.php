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
 * @package    Controllers
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @copyright  2011 The Authors
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 */

namespace XssBadWebApp\Controllers;

use XssBadWebApp\Models\User as UserModel;
use XssBadWebApp\Views\SmartyView;
use XssBadWebApp\Views\PhpView;
use XssBadWebApp\Utilities\Security;
use XssBadWebApp\Exceptions\NotFoundException;
use \RuntimeException;

class User {
    
    protected $request = null;
    protected $session = null;
    
    public function __construct(
        \XssBadWebApp\Utilities\Request $request,
        \XssBadWebApp\Utilities\Session $session
    ) {
        $this->request = $request;
        $this->session = $session;
    }
    
    public function dispatch() {
        $action = $this->request->get('action', 'index');
        $action = preg_replace('/[^a-z0-9]/i', '', $action);
        if ($action != 'dispatch' && is_callable(array($this, $action))) {
            return $this->$action();
        }
        throw new NotFoundException('Invalid Action');
    }

    public function doLogin() {
        if ($this->session->get('user')->isRegistered()) {
            header('Location: index.php');
            exit();
        }
        $name = $this->request->post('username');
        $password = $this->request->post('password');
        $user = UserModel::load($name);
        var_dump($name, $user, $user->isRegistered(), $user->checkPassword($password));
        if ($user->isRegistered() && $user->checkPassword($password)) {
            $this->session->set('user', $user);
            $this->session->regenerate();
            header('Location: index.php');
            die();
        }
        return $this->login();
    }
    
    public function doRegister() {
        if ($this->session->get('user')->isRegistered()) {
            header('Location: index.php');
            exit();
        }
        $token = $this->session->get('csrf.token', null);
        if (!$token || !$this->request->post($token)) {
            throw new RuntimeException('Invalid CSRF Token');
        }
        $name = $this->request->post('username');
        $password = $this->request->post('password');
        $conf = $this->request->post('conf_password');
        if ($password && $password == $conf && !UserModel::has($name)) {
            $user = new UserModel();
            $user->setName($name);
            $user->setPassword($password);
            $user->setRegistered(true);
            $user->save();
            header('Location: index.php?controller=User&action=login&message=Registered+Successfully');
            die();
        } elseif ($password != $conf || !$password) {
            $message = 'Passwords must match and be non-empty';
        } else {
            $message = 'User Name Already Taken';
        }
        return $this->register($message);
    }
    
    public function login() {
        if ($this->session->get('user')->isRegistered()) {
            header('Location: index.php');
            exit();
        }
        $view = new SmartyView('User/login');
        $view->assign('message', $this->request->get('message', ''));
        return $view;
    }
    
    public function logout() {
        $this->session->destroy();
        header('Location: index.php');
        die();
    }
    
    public function register($message = '') {
        if ($this->session->get('user')->isRegistered()) {
            header('Location: index.php');
            exit();
        }
        $view = new SmartyView('User/register');
        $token = base64_encode(Security::makeRandomString());
        $this->session->set('csrf.token', $token);
        $view->assign('csrf', $token);
        $view->assign('message', $message);
        return $view;
    }
    
}