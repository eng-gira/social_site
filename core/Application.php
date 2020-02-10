<?php

    class Application
    {
        private $controller = "homeController";
        private $action = "index";
        private $params = array();

        public function __construct()
        {
            $this->cleanURL();

            if(file_exists(CONTROLLER . $this->controller . '.php'))
            {
                if(method_exists($this->controller, $this->action))
                {
                    call_user_func_array([$this->controller, $this->action], $this->params);
                }
                else
                {
                    echo "action doesn't exist<br>";
                    call_user_func_array(['homeController','pageNotFound'],[]);
                }
            }
            else 
            {
                echo "controller (" . $this->controller . ") doesn't exist <br>";
                call_user_func_array(['homeController','pageNotFound'],[]);
            }
        }

        private function cleanURL()
        {
            $url = trim($_SERVER['REQUEST_URI'], '/');
            $init = strpos($url, "public")+strlen("public");
            $request = substr($url, $init);
            if(!empty($request))
            {
                $els = substr($request, 0, 1) == "/" ? explode("/", substr($request,1)) : explode("/", $request);
                $this->controller=isset($els[0])? $els[0] . "Controller" : 'homeController';
                $this->action=isset($els[1])? $els[1] : 'index';
                unset($els[0], $els[1]);
                $this->params = !empty($els) ? array_values($els) : [];
            }
        }
    }
?>