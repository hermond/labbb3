<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hello World
 * Date: 2013-09-26
 * Time: 23:59
 * To change this template use File | Settings | File Templates.
 */

namespace view;


class HTMLview {
    /**
     * @var String messages for user feedback
     */
    private static $loginMessage = "Du har loggats in";
    private static $logoutMessage = "Du har loggats uuuut";
    private static $rememberMeMessage = "Du har loggat in med cookie,
     vi kommer ihåg dig nästa gång";
    private static $cookieLoginSuccessMessage = "Inloggningen med cookies";
    private static $userLoginExceptionMessage = "Fel användarnamn eller lösenord!!";
    private static $sessionExceptionMessage = "Något är fel på din session";
    private static $cookieExceptionMessage = "Felaktig kaka";
    private static $usernameMissingMessage = "Användarnamn saknas";
    private static $passwordMissingMessage = "Lösenord saknas";
    /**
     * @var String for location in $_SESSION
     */
    private static $message = "message";

    /**
     * @var String for locations in $_POST
     */
    private static $username = 'username';
    private static $password = 'password';
    private static $submit = 'submit';
    private static $checkbox = 'checkbox';

    /**
     * @var String for locations in $_GET
     */
    private static $login = 'login';
    private static $logout = 'logout';

    /**
     * @var String for cookie and location in $_COOKIE
     */
    private static $cookie = "user";
    /**
     * @var String for filename
     */
    private static $fileName = "cookie.txt";

    /**
     * @var String for Cookie-token
     */
    private static $cookieToken = "klsgKOI%zOYXKyD%";

    /**
     * @return string with HTML for Indexpage
     */
    public function getIndexPage()
    {
        $date = $this->getDate();
        $username = $this->getUsername();
        $message = $this->getMessage();
        return "<!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv='Content-Type'
                content='text/html; charset=UTF-8'>
                <title>$message</title>
            </head>
            <body>
            <h2>Ej inloggad</h2>
                <p>$message</p>
                <form action='?". self::$login . "' method='post' >
                <label>Username</label>
                <input type='text' name=".self::$username." value='$username'>
                <label>Password</label>
                <input type='password' name=".self::$password.">
                <label>Remember me</label>
                <input type='checkbox' name=".self::$checkbox.">
                <input type='submit' name=".self::$submit." value='submit'>
                </form>
                <p>$date</p>
            </body>
        </html>";
    }

    /**
     * @return string HTML for Admin page
     */
    public function getAdminPage ()
    {
      $message = $this->getMessage();
        return
        "<!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv='Content-Type'
                content='text/html; charset=UTF-8'>
                <title>Inloggad</title>
            </head>
            <body>
            <h2>Inloggad</h2>
                <p>$message</p>
            <form action='?".self::$logout."' method='post' >
                <input type='submit' value='Logout'>
            </form>
            </body>
        </html>";
    }

    /**
     * @return string with date in swedish format
     */
    private static function getDate()
    {
        $dayArray = array(1=>"Måndag", "Tisdag", "Onsdag", "Torsdag",
        "Fredag", "Lördag", "Söndag");

        $day= $dayArray[date("N")];

        $monthArray = array(1=>"Januari","Februari","Mars","April","Maj",
            "Juni","Juli","Augusti","September","Oktober", "November",
            "December");

        $month = $monthArray[date("n")];

        return $day . ", den " . date("d") . " " . $month .
        " år " .  date("Y") .". Klockan är [" . date("H") .
        ":" . date("i") . ":" . date("s") . "]";
    }

    /**
     * @return string
     */
    private function getMessage()
    {
        if (isset($_SESSION[self::$message]))
        {
            $message = $_SESSION[self::$message];
            $this->unsetMessageSession();
        }
        else{
            $message = "Välkommen";
        }
        return $message;
    }

    /**
     * @return string
     */
    private function getUsername()
    {
        if (isset($_POST[self::$username]))
        {
            $username = ($_POST[self::$username]);
        }
        else {
            $username = "";
        }
        return $username;
    }

    /**
     * @return string from $_POST with username.
     * @throws /Exception if username is missing
     * @throws /Exception if _$POST is empty
     */
    public function getUsernamePost()
    {
        if (isset($_POST[self::$username]))
        {
            if(strlen($_POST[self::$username])>0)
            {
                return $_POST[self::$username];
            }
            else{
                $this->setUsernameMissingMessage();
                throw new \Exception("Username is missing");
            }
        }
        else
        {
            throw new \Exception("Post crashed");
        }
    }
    /**
     * @return string from $_POST with password.
     * @throws /Exception if password is missing
     * @throws /Exception if _$POST is empty
     */
    public function getPasswordPost()
    {
        if (isset($_POST[self::$password]))
        {
            if(strlen($_POST[self::$password])>0)
            {
                return $_POST[self::$password];
            }
            else{
                $this->setPasswordMissingMessage();
                throw new \Exception("Password is missing");
            }
        }
        else
        {
            throw new \Exception("Post crashed");
        }
    }


    /**
     * @return bool
     */
    public function isLoggingIn()
    {
        return isset($_GET[self::$login]);
    }

    /**
     * @return bool
     */
    public function isLoggingOut()
    {
        return isset($_GET[self::$logout]);
    }

    /**
     * @return bool
     */
    public function isSubmitted()
    {
        return isset($_POST[self::$submit]);
    }

    /**
     * @return bool
     */
    public function isRememberMe()
    {
        return isset($_POST[self::$checkbox]);
    }

    public function setUsernameMissingMessage()
    {
        $_SESSION[self::$message] = self::$usernameMissingMessage;
    }

    public function setPasswordMissingMessage()
    {
        $_SESSION[self::$message] = self::$passwordMissingMessage;
    }

    /**
     * Set the UserLogin Exception message
     */

    public function setUserLoginExceptionMessage()
    {
        $_SESSION[self::$message] = self::$userLoginExceptionMessage;
    }
    /**
     * Set the session Exception message
     */
    public function setSessionExceptionMessage()
    {
        $_SESSION[self::$message] = self::$sessionExceptionMessage;
    }

    /**
     * Sets the logout feedback message
     */
    public function setLogoutMessageSession()
    {
        $_SESSION[self::$message] = self::$logoutMessage;
    }

    /**
     * Sets the login feedback message
     */
    public function setLoginMessageSession()
    {
        $_SESSION[self::$message] = self::$loginMessage;
    }


    /**
     * Set the cookie error message
     */
    private function setErrorMessageCookie()
    {
        $_SESSION[self::$message] = self::$cookieExceptionMessage;
    }

    /**
     * Sets the remember me feedback message
     */
    public function setCookieLoginMessage()
    {
        $_SESSION[self::$message] = self::$rememberMeMessage;
    }

    /**
     * Sets the cookie login success feedback message
     */
    public function setCookieLoginSuccessMessage()
    {
        $_SESSION[self::$message] = self::$cookieLoginSuccessMessage;
    }
    /**
     * Unsets the (all) feedback message
     */
    public function unsetMessageSession()
    {
        unset($_SESSION[self::$message]);
    }

    /**
     * Sets the remember me-cookie
     */
    public function setCookie()
    {
        $time = time() + 50;
        file_put_contents(self::$fileName, $time);
        setcookie(self::$cookie, self::$cookieToken, $time);
    }

    /**
     * Unsets the remember me-cookie
     */
    public function unsetCookie()
    {
        setcookie(self::$cookie,"", time() - 360000);
    }

    /**
     * @return bool
     * @throws /Exception if the user is not valid
     */
    public function isCookieValid()
    {

            $timeInFile = file_get_contents(self::$fileName);

             if($_COOKIE[self::$cookie] !== self::$cookieToken
                 || $timeInFile < time() )
            {
                $this->setErrorMessageCookie();
                throw new \Exception("Wrong information in cookie!");
            }
            else
            {
                return true;
            }
    }

    /**
     * @return bool
     */
    public function isThereACookie()
    {
        return isset($_COOKIE[self::$cookie]);
    }

}