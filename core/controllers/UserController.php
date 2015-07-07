<?php

use main\Query;
use main\HttpException;
use main\UserIdentity;
use models\UserModel;
use controllers\Controller;

class UserController extends Controller
{
    use Query;

    public function __construct()
    {
        $this->_model = new UserModel();
    }

    public function actionLogin()
    {
        if ($username = $this->getInput('username') AND $password = $this->getInput('password')) {
            try {
                $user     = $this->getModel($username);
                $identity = new UserIdentity($user, $password);
                $identity->login();
            } catch (HttpException $e) {
                $this->render('/user/login_error', ['message' => $e->getMessage()]);
            }
            $referer = $this->getReferer();
            $this->redirect(strpos($referer, 'user/login')!==false ? '/' : $referer);
        }
    }

    public function actionLogout()
    {
        UserIdentity::logout();
        $this->redirect($this->getReferer());
    }

    /**
     * @param $username
     *
     * @return UserModel
     * @throws main\HttpException
     */
    protected function getModel($username)
    {
        if (!$user = $this->_model->getUser($username)) {
            throw new HttpException('Неверный логин или пароль');
        }

        return $user;
    }

}