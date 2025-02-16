<?php

declare(strict_types=1);

trait AppUserAuthentication
{
    public $loginOldApp = 111;
    public $passwordOldApp = 222;

    //Метод проверки логина и пароля пользователя соответствия логину и паролю в приложении, который будет использователься в методе авторизации в классе Person
    public function authenticate($login, $password)
    {
        // if ($login === $this->loginOld and $password === $this->passwordOld) {
        //     return true;
        // } else {
        //     return false;
        // }
        //Порефакторил
        //return ($login === $this->loginOld and $password === $this->passwordOld) ? true : false;
        //Порефакторил
        return $login === $this->loginOldApp && $password === $this->passwordOldApp;
    }
}

trait MobileUserAuthentication
{
    public $loginOldMobile = 1111;
    public $passwordOldMobile = 2222;

    //Метод проверки логина и пароля пользователя соответствия логину и паролю в мобильном приложении, который будет использователься в методе авторизации в классе Person
    public function authenticate($login, $password)
    {
        return $login === $this->loginOldMobile && $password === $this->passwordOldMobile;
    }
}


class Person
{
    use AppUserAuthentication, MobileUserAuthentication {
        AppUserAuthentication::authenticate insteadof MobileUserAuthentication;
        MobileUserAuthentication::authenticate as authenticateMobile;
    }

    public $login;
    public $password;

    //Метода ввода логина и пароля пользователя
    public function setLogAnfPas($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    //Метод авторизации по ранее введнному логину и паролю. 
    public function authorization()
    {
        if ($this->authenticate($this->login, $this->password)) { //Здесь используется метод authenticateApp из трейта AppUserAuthentication
            echo "Авторизация прошла успешно в приложении" . PHP_EOL;
        } 
        if ($this->authenticateMobile($this->login, $this->password)) { //Здесь используется метод authenticateMobile из трейта MobileUserAuthentication
            echo "Авторизация прошла успешно в мобильном приложении" . PHP_EOL;
        } 
    }


}

$person1 = new Person;
$person1->setLogAnfPas(111, 222);   //Вводим логин и пароль первого пользователя
$person1->authorization();                          //Первый пользователь пытается авторизоваться

$person2 = new Person;
$person2->setLogAnfPas(1111, 2222);    //Вводим логин и пароль второго пользователя
$person2->authorization();                           //Второй пользователь пытается авторизоваться