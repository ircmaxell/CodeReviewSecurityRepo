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

use XssBadWebApp\Models\GuestBook as GuestBookModel;
use XssBadWebApp\Views\SmartyView;
use XssBadWebApp\Views\PhpView;
use XssBadWebApp\Utilities\Security;
use XssBadWebApp\Exceptions\NotFoundException;
use \LimitIterator;
use \ArrayIterator;
use \RuntimeException;

class GuestBook {

    protected $pageSize = 5;
    protected $request = null;
    protected $session = null;
    
    public function __construct(
        \XssBadWebApp\Utilities\Request $request,
        \XssBadWebApp\Utilities\Session $session
    ) {
        $this->request = $request;
        $this->session = $session;
    }
    
    public function add(array $errors = array()) {
        if (!$this->session->get('user')->isRegistered()) {
            header('Location: index.php');
            exit();
        }
        $view = new PHPView('GuestBook/add');
        $data = $this->request->post('gb_item', array());
        $data += array('id' => 0, 'name' => '', 'location' => '', 'greeting' => '');
        $view->assignAll($data);
        $view->assign('errors', $errors);
        $token = base64_encode(Security::makeRandomString());
        $this->session->set('csrf.token', $token);
        $view->assign('csrf', $token);
        return $view;
    }
    
    public function dispatch() {
        $action = $this->request->get('action', 'index');
        $action = preg_replace('/[^a-z0-9]/i', '', $action);
        if ($action != 'dispatch' && is_callable(array($this, $action))) {
            return $this->$action();
        }
        throw new NotFoundException('Invalid Action');
    }
    
    public function edit() {
        if (!$this->session->get('user')->isRegistered()) {
            header('Location: index.php');
            exit();
        }
        $id = $this->request->get('id', 0);
        $data = GuestBookModel::load($id);
        $this->request->set('gb_item', $data->asArray(), 'post');
        return $this->add();
    }
    
    public function index() {
        $view = new SmartyView('GuestBook/index');
        $page = (int) $this->request->get('page', 1);
        $start = ($page - 1) * $this->pageSize;
        $limit = 0;
        $data = GuestBookModel::loadAll(-1);
        $it = new LimitIterator(
            new ArrayIterator($data),
            $start,
            $this->pageSize
        );
        $view->assign('current_page', floor($start / $this->pageSize) + 1);
        $view->assign('prev_page', floor($start / $this->pageSize));
        $view->assign('next_page', floor($start / $this->pageSize) + 2);
        $view->assign('pages', ceil(count($data) / $this->pageSize));
        $view->assign('data', $it);
        $view->assign('user', $this->session->get('user'));
        $view->assign('message', $this->request->get('message', ''));
        return $view;
    }
    
    public function save() {
        if (!$this->session->get('user')->isRegistered()) {
            header('Location: index.php');
            exit();
        }
        $token = $this->session->get('csrf.token', null);
        if (!$token || !$this->request->post($token)) {
            throw new RuntimeException('Invalid CSRF Token');
        }
        $data = $this->request->post('gb_item', array());
        $errors = GuestBookModel::validate($data);
        if (!empty($errors)) {
            return $this->add($errors);
        }
        $data['id'] = isset($data['id']) && $data['id'] ? $data['id'] : 0;
        $model = GuestBookModel::load($data['id']);
        $model->setName($this->session->get('user')->getName());
        $model->setLocation($data['location']);
        $model->setGreeting($data['greeting']);
        $model->save();
        $this->_redirect('index.php');
    }
    
    protected function _redirect($url) {
        header('Location: ' . $url);
        exit();
    }
}
