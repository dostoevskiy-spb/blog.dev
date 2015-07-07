<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 27.03.14
 * Time: 14:26
 * All rights are reserved
 */

namespace models;

use main\DateTimeHelper;
use main\UserIdentity;

class   UserModel extends Model
{
    public $id;
    public $username;
    public $password;
    public $useragent;

    protected $_table = 'users';


    public function updateUserAgent()
    {
        $update    = "UPDATE {$this->_table} SET useragent=:ua WHERE id=:id";
        $sth       = $this->getDbConnector()->prepare($update);
        $userAgent = crypt(UserIdentity::getUserAgent());
        $sth->bindParam(':ua', $userAgent, \PDO::PARAM_STR, 150);
        $sth->bindParam(':id', $this->id, \PDO::PARAM_INT, 150);

        return $sth->execute();
    }


    public function getUser($username)
    {
        $select = "SELECT * FROM {$this->_table} WHERE username=:un";
        $sth    = $this->getDbConnector()->prepare($select);
        $sth->bindParam(':un', $username, \PDO::PARAM_STR, 50);
        $sth->execute();

        if ($user = $sth->fetch()) {
            $this->id        = $user['id'];
            $this->username  = $user['username'];
            $this->password  = $user['password'];
            $this->useragent = $user['useragent'];

            return $this;
        } else {
            return FALSE;
        }

    }

}