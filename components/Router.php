<?php
namespace components;

class Router {
    
    private $routes;
    
    function __construct() {
        $this->routes = array(
            'main/form' => 'main/Form',//actionForm в MainController
            'main/pogodazp' => 'main/Pogodazp',//actionPogodazp в MainController
            'main/feedback' => 'main/Feedback',//actionFeedback в MainController
            'main/feedbacklist' => 'main/Feedbacklist',//actionFeedbacklist в MainController
            'main' => 'main/Index' //action index в MainController
        );
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
                
                $actionName = 'action'.ucfirst(array_shift($segments));;

                //Подключить файл класса-контроллера
                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

                if (file_exists($controllerFile)) {
                    //Создать объект, вызвать метод (т.е. action)
                    $controllerObject =  new \controllers\MainController;
                }
                  
                //$controllerObject = new $controllerName();
                //echo $controllerName;

                $result = $controllerObject->$actionName();
                
                if ($result!=null) {
                    break;
                }
            }
        }
    }
}