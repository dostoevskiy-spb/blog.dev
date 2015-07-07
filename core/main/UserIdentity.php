<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 31.03.14
 * Time: 20:02
 * All rights are reserved
 */

namespace main;

use models\UserModel;

class UserIdentity
{

    use Query;

    protected $_model;
    protected $_password;
    protected $_salt = 'SuFhl1nmZolZ9ULgkghy';

    /**
     * @param $user
     * @param $password
     */
    public function __construct($user, $password)
    {
        $this->_model    = $user;
        $this->_password = $password;
    }


    /**
     * Выполняем вход
     * @throws HttpException
     */
    public function login()
    {
        if ($this->isLegalUser()) {
            $session = session_start();
            session_regenerate_id();
            if ($session) {
                $_SESSION['username'] = $this->_model->username;
                $this->_model->updateUserAgent();
            } else
                throw new HttpException('Неверное имя пользователя или пароль');

            return App::isAuthorized();
        } else
            throw new HttpException('Неверное имя пользователя или пароль');
    }

    /**
     * Разлогиниваем пользователя
     */
    public static function logout()
    {
        if (App::isAuthorized()) {
            if (($session = session_status()) == PHP_SESSION_NONE)
                session_start();
            unset($_SESSION['username']);

            return session_destroy();
        }

        return FALSE;
    }

    /**
     * @return bool
     */
    protected function isLegalUser()
    {
        $truePassword = $this->_model->password;
        $password     = crypt($this->_password, $this->_salt);
        if ($truePassword === $password)
            return TRUE;
        else
            return FALSE;
    }


}