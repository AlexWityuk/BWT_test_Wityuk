<?php

class Router {
    
    private $routes;
    
    function __construct() {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include ($routesPath);
    }
    
    private function getURI(){
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }
    /**
     * Return request string
     * @return string
     */
    public function run(){
        
        //Получить строку запроса
        $uri = $this->getURI();
        
        //Прверить наличие такого запроса в routes.php
        foreach ($this->routes as $uriPattern => $path){

            if (preg_match("~$uriPattern~", $uri)) {
                //echo '+';
                
                //Если есть совпадение, 
                //определить какой контролер
                //и action обрабатывает запрос
                
                //Получаем внутренний путь из внешнего согласно правилу.
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                
                $segments = explode('/', $internalRoute);
                array_shift($segments);
                array_shift($segments);
     
                $controllerName = array_shift($segments).'Controller';
                
                //Делает заглавной первую букву в имени контроллера
                $controllerName = ucfirst($controllerName);
                //echo $controllerName;
                
                $actionName = 'action'.ucfirst(array_shift($segments));
                //echo $actionName;
                
                //echo '<br>Класс:'.$controllerName;
                //echo '<br>Метод:'.$actionName;

                //Подключить файл класса-контроллера
                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

                if (file_exists($controllerFile)) {
                    include_once ($controllerFile);
                }
                
                //Создать объект, вызвать метод (т.е. action)
                $controllerObject = new $controllerName;
                
                $result = $controllerObject->$actionName();
                
                if ($result!=null) {
                    break;
                }
            }
        }
    }
}