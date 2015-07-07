<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 27.03.14
 * Time: 14:20
 * All rights are reserved
 */
namespace main;

/**
 * Набор часто используемых фунций
 * Class Query
 * @package main
 */
trait Query
{


    /**
     * Хелпер для получения Referrer;
     * @return null
     */
    public static function getReferer()
    {
        return self::extract($_SERVER, 'HTTP_REFERER');
    }

    /**
     * Хелпер для получения параметров из get-строки
     *
     * @param string $name
     * @param null   $default
     *
     * @return null
     */
    public static function getRouteParam($name = '', $default = NULL)
    {
        return $name ? (self::extract($_GET, $name, $default)) : $_GET;
    }

    /**
     * Хелпер для умного извлечения элементов массива $_POST
     * @param string $name
     * @param null   $default
     *
     * @return null
     */
    public static function getInput($name = '', $default = NULL)
    {
        return $name ? (self::extract($_POST, $name, $default)) : $_POST;
    }

    /**
     * Хелпер для умного извлечения элементов массива
     * @param array $array
     * @param       $name
     * @param null  $default
     *
     * @return null
     */
    public static function extract(array $array, $name, $default = NULL)
    {
        return isset($array[$name]) ? $array[$name] : $default;
    }

    /**
     * Проверяем, аяксовый ли запрос
     * @return bool
     */
    public function isAjax()
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ? TRUE : FALSE;
    }

    /**
     * Выполняем редирект
     * @param     $url
     * @param int $code
     */
    public function redirect($url, $code = 302)
    {
        header('Location: ' . $url, TRUE, $code);
    }

    /**
     * Получаем User Agent пользователя
     * @return bool|string
     */
    public static function getUserAgent()
    {
        return self::extract($_SERVER, 'HTTP_USER_AGENT', FALSE);
    }

    /**
     * Узнаем, отправлен ли запрос методом POST
     * @return bool
     */
    public function isPostRequest(){
        return isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'],'POST');
    }
}

trait Configger
{
    protected $_dbConfig;


    public function getDatabaseConfig()
    {
        return require(__DIR__ . '/../config/dbConfig.php');;
    }
}

trait DateTimeHelper
{
    public function getDateTime($format = "Y-m-d H:i:s")
    {
        return (new \DateTime())->format($format);
    }
}