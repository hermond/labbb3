<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-09-27
 * Time: 00:02
 * To change this template use File | Settings | File Templates.
 */

namespace model;


class user {

    /**
     * @var string with correct username
     */
    private static $CorrectUser = "axel";
    /**
     * @var string with correct password
     */
    private static $CorrectPassword = "losenord";
    /**
     * @var string locations in $_SESSION
     */
    private static $loggedIn = "loggedIn";
    private static $checkSecurity = "checkSecurity";
    private static $ipAdress = "ipAdress";
    private static $webBrowswer = "webBrowser";
    /**
     * @var string locations in $_SERVER
     */
    private static $userAgent = "HTTP_USER_AGENT";
    private static $remoteAddr = "REMOTE_ADDR";


    /**
     * @return string with valid/correct username
     */
    private function getUserName()
    {
        return self::$CorrectUser;
    }
    /**
     * @return string with valid/correct password
     */
    private function getPassword()
    {
        return self::$CorrectPassword;
    }


    /**
     * @param $username
     * @param $password
     * @return bool (true) if password and username matches
     * @throws \Exception
     */
    public function userValidation($username, $password)
    {
        if($username == $this->getUserName() &&
            $password == $this->getPassword())
        {
          $this->setSession();
            return true;
        }
        else{
            throw new \Exception("Wrong username och password");
        }
    }

    /**
     * Sets the session for user and saves useragent and
     * remoteadress in another session
     */
    public function setSession()
    {
        $_SESSION[self::$checkSecurity] = array();
        $_SESSION[self::$checkSecurity][self::$webBrowswer] =
            $_SERVER[self::$userAgent];
        $_SESSION[self::$checkSecurity][self::$ipAdress] =
            $_SERVER[self::$remoteAddr];

        $_SESSION[self::$loggedIn] = True;
    }

    /**
     * Unsets the session
     */
    public function unsetSession()
    {
        unset($_SESSION[self::$loggedIn]);
    }

    /**
     * @return bool if user is logged in our not
     */
    public function isLoggedIn()
    {
        return isset($_SESSION[self::$loggedIn]);
    }

    /**
     * @return bool (true)if the session is valid
     * @throws \Exception if session is not valid
     */
    public function isSessionValid()
    {
        if(isset($_SESSION[self::$checkSecurity]))
        {
            if ($_SESSION[self::$checkSecurity][self::$webBrowswer]
                != $_SERVER[self::$userAgent] ||
                $_SESSION[self::$checkSecurity][self::$ipAdress]
                != $_SERVER[self::$remoteAddr])
            {
                throw new \Exception("Something is wrong with the session!");
            }
            else{
                return true;
            }
        }
    }


}