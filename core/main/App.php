<?php

namespace main;

use controllers\Controller;
use models\UserModel;
use Exception;
require(CORE_PATH . DIRECTORY_SEPARATOR . 'main/DbConnector.php');

spl_autoload_register(function ($class) {
    $add  = explode("\\", $class);
    if (count($add) > 1)
        $add = implode('/', $add);
    else
        $add = array_shift($add);
    if (is_file($path = CORE_PATH . DIRECTORY_SEPARATOR . $add . '.php')) {
        require $path;
    } else {
        die($path);
    }

});

class App
{
    use Query;

    /** @var  Controller */
    protected $controller;
    protected $action;
    protected $id;
    protected $defaultController;
    protected $user;

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(UserIdentity $user)
    {
        $this->user = $user;
    }

    /**
     * @return bool
     */
    public static function isAuthorized()
    {
        if (($session = session_status()) == PHP_SESSION_NONE)
            session_start();
        $status = session_status();
        if (in_array($status, [PHP_SESSION_NONE, PHP_SESSION_DISABLED]))
            return FALSE;
        $username = self::extract($_SESSION, 'username');
        if (!$username)
            return FALSE;
        if (!$model = (new UserModel())->getUser($username)) {
            return FALSE;
        }
        if ($model->useragent == crypt(self::getUserAgent(), $model->useragent)) {
            return TRUE;
        }

        return FALSE;
    }


    public static function create()
    {

        return new App;
    }

    public function start()
    {

        $this->process();
    }

    protected function process()
    {
        $route = $this->parseUrl();

        $this->runController($route);
    }

    public function parseUrl()
    {
        $_uri     = $_SERVER['REQUEST_URI'];
        $uriArray = explode('/', $_uri);
        $uriArray = array_map('stripslashes', $uriArray);
        $uriArray = array_map(function ($el) {
            $el = preg_replace('/[^a-zA-Z0-9_]/', '', $el);
            $el = stripslashes($el);

            return strtolower($el);
        }, $uriArray);

        $uriArray = array_filter(
            $uriArray,
            function ($el) {
                return !empty($el);
            }
        );

        return $uriArray;
    }

    private function runController($route)
    {

        $this->controller = empty($route) ? $this->getDefaultController() : array_shift($route);
        if (!empty($route)) {
            $this->action = array_shift($route);
        }
        if (!empty($route)) {
            $this->id = (int) array_shift($route);
        }

        $cname   = ucfirst($this->controller) . 'Controller';
        $caction = 'action' . ucfirst($this->action);
        $cfile   = CORE_PATH . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $cname . '.php';
        if (!is_file($cfile)) {
            die('Такого контроллера не существует');
        }
        require($cfile);

        $this->controller = new $cname;
        set_exception_handler(function ($e) {
            $this->controller->renderText($e->getMessage());
        });
        if (empty($this->action)) {
            $this->controller->actionIndex();
        } else {
            try {
                if (method_exists($this->controller, $caction)) {
                    if (empty($this->id)) {
                        $this->controller->$caction();
                    } else {
                        $this->controller->$caction($this->id);
                    }
                } else {
                    throw new HttpException('Такого экшена не существует');
                }
            } catch (HttpException $e) {
                $this->controller->renderText($e->getMessage());
            }
        }
    }

    public function setDefaultController($c)
    {
        $this->defaultController = $c;

        return $this;
    }

    public function getDefaultController()
    {
        return $this->defaultController;

    }

}