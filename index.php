<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 27.03.14
 * Time: 13:36
 * All rights are reserved
 */
define('CORE_PATH', __DIR__ . '/core');
define('VIEW_PATH', __DIR__ . '/core/views');
define('DOCROOT', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
require(CORE_PATH . DIRECTORY_SEPARATOR . 'main' . DIRECTORY_SEPARATOR . 'App.php');
use main\App;
App::create()->setDefaultController('blog')->start();