<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 27.03.14
 * Time: 13:56
 * All rights are reserved
 */

class Request
{

    protected $_pathInfo;
    protected $_requestUri;

    public function __construct()
    {
        if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
            if (isset($_GET))
                $_GET = $this->clearSlashes($_GET);
            if (isset($_POST))
                $_POST = $this->clearSlashes($_POST);
            if (isset($_REQUEST))
                $_REQUEST = $this->clearSlashes($_REQUEST);
            if (isset($_COOKIE))
                $_COOKIE = $this->clearSlashes($_COOKIE);
        }
    }

    public function clearSlashes(&$data)
    {
        if (is_array($data)) {
            if (count($data) == 0)
                return $data;
            $keys = array_map('stripslashes', array_keys($data));
            $data = array_combine($keys, array_values($data));

            return array_map(array($this, 'clearSlashes'), $data);
        } else
            return stripslashes($data);
    }

    public function getPathInfo()
    {
        if($this->_pathInfo===null)
        {
            $pathInfo=$this->getRequestUri();

            if(($pos=strpos($pathInfo,'?'))!==false)
                $pathInfo=substr($pathInfo,0,$pos);

            $pathInfo=$this->decodePathInfo($pathInfo);

            $scriptUrl=$this->getScriptUrl();
            $baseUrl=$this->getBaseUrl();
            if(strpos($pathInfo,$scriptUrl)===0)
                $pathInfo=substr($pathInfo,strlen($scriptUrl));
            elseif($baseUrl==='' || strpos($pathInfo,$baseUrl)===0)
                $pathInfo=substr($pathInfo,strlen($baseUrl));
            elseif(strpos($_SERVER['PHP_SELF'],$scriptUrl)===0)
                $pathInfo=substr($_SERVER['PHP_SELF'],strlen($scriptUrl));
            else
                throw new CException(Yii::t('yii','CHttpRequest is unable to determine the path info of the request.'));

            $this->_pathInfo=trim($pathInfo,'/');
        }
        return $this->_pathInfo;
    }

    public function getRequestUri()
    {
        if($this->_requestUri===null)
        {
            if(isset($_SERVER['HTTP_X_REWRITE_URL'])) // IIS
                $this->_requestUri=$_SERVER['HTTP_X_REWRITE_URL'];
            elseif(isset($_SERVER['REQUEST_URI']))
            {
                $this->_requestUri=$_SERVER['REQUEST_URI'];
                if(!empty($_SERVER['HTTP_HOST']))
                {
                    if(strpos($this->_requestUri,$_SERVER['HTTP_HOST'])!==false)
                        $this->_requestUri=preg_replace('/^\w+:\/\/[^\/]+/','',$this->_requestUri);
                }
                else
                    $this->_requestUri=preg_replace('/^(http|https):\/\/[^\/]+/i','',$this->_requestUri);
            }
            elseif(isset($_SERVER['ORIG_PATH_INFO']))  // IIS 5.0 CGI
            {
                $this->_requestUri=$_SERVER['ORIG_PATH_INFO'];
                if(!empty($_SERVER['QUERY_STRING']))
                    $this->_requestUri.='?'.$_SERVER['QUERY_STRING'];
            }
            else
                throw new CException(Yii::t('yii','CHttpRequest is unable to determine the request URI.'));
        }

        return $this->_requestUri;
    }

    private function decodePathInfo($pathInfo)
    {
        return urldecode($pathInfo);
    }
}