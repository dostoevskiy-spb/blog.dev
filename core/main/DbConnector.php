<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 27.03.14
 * Time: 14:12
 * All rights are reserved
 */
namespace db;
require(CORE_PATH . DIRECTORY_SEPARATOR . '/main/helpers.php');

use main\Configger;

class DbConnector
{
    use Configger;

    protected $_pdo;

    public function __construct()
    {
        $config = $this->getDatabaseConfig();
        try {
            $this->_pdo = new \PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function query($query)
    {
        return $this->_pdo->query($query);
    }

    public function prepare($sql)
    {
        return $this->_pdo->prepare($sql);
    }

    public function getErrorCode()
    {
        return $this->_pdo->errorInfo();
    }

}