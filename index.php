<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-09-26
 * Time: 23:47
 * To change this template use File | Settings | File Templates.
 */

require_once("model/user.php");
require_once("view/HTMLview.php");
require_once("controller/Login.php");

session_start();
/**
 * @var object
 */
$Login = new \controller\Login();
echo $Login->Controll();