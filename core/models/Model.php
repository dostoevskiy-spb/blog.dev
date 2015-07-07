<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 27.03.14
 * Time: 14:28
 * All rights are reserved
 */

namespace models;

use db\DbConnector;


class Model
{
    private $_dbConnector;
    protected $_table;

    public function __construct()
    {
        $this->_dbConnector = new DbConnector;
    }

    protected function getDbConnector()
    {
        return $this->_dbConnector;
    }

    public  function getTableName()
    {
        return $this->_table;
    }
}