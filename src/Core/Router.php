<?php
namespace Web\FrontController\Core;

class Router
{
    public static function runApi($routes){
        //имя класса
        $controller= 'Web\FrontController\Controllers\\' . ucfirst(strtolower($routes[2])).'Controller';
        //имя метода в классе
        $action=strtolower($_SERVER['REQUEST_METHOD']).'Action';
        $params=!empty($routes[3])?$routes[3]:null;
        $controller=new $controller();
        $controller->$action($params);
    }
    public static function run(){

        $controller='Index';
        $action='index';
        $params=null;
        ///info/contacts/1
        //['', 'info', 'contacts']
        // Для примера возьмем запрос /info/rules (по аналогии будут обработаны и остальные запросы)
        $routes=explode('/',$_SERVER['REQUEST_URI']); // разбивает запрос по /, формирует массив
        // тогда мы получим массив вида: ['', 'info', 'rules']

        // имя класса контроллера
        //['', 'info', 'contacts']
        if (!empty($routes[1])){
                if ($routes[1]=='api'){
                    self::runApi($routes);
                    return;
                }else {
                    $controller=$routes[1];
                }
        }
        //имя метода
        if (!empty($routes[2])){ // если второй елемент массива не empty
            $action=$routes[2]; // присваеваем переменной $action значение второго элемента массива
            // $action = rules
            // $action = contacts
        }
        //параметры
        if (!empty($routes[3])){ // если третий елемент массива не empty
            $params=$routes[3]; // присваеваем переменной $params значение третьего элемента массива
        }

        $controller= 'Web\FrontController\Controllers\\' . ucfirst(strtolower($controller)).'Controller'; // формируем имя класса контроллера
        // $controller = 'InfoController'
        $action=strtolower($action).'Action'; // формируем имя метода
        // $action = 'rulesAction'

        if (!class_exists($controller)){
            echo 'Класс не найден';
            return;
        }
        if(!method_exists($controller,$action)){
            echo 'Метод не найден';
            return;
        }
        $controller = new $controller(); // создаем объект контроллера
        // $controller = new InfoController()
        $controller->$action($params); // у созданного объета вызываем метод
        // $controller->rulesAction()
        // переходим в метод rulesAction в классе InfoController
    }
}