<?php

include_once 'config/dbclass.php';


class Route
{
    /**
     * Start routing, load controller and run method
     */
    static function start()
    {
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        $controllerName = !empty($routes[1]) ?  $routes[1] : 'Main';
        $methodName     = !empty($routes[2]) ?  $routes[2] : 'index';
        $id             = !empty($routes[3]) ?  $routes[3] : null;

        $controllerPath = "classes/" .  strtolower($controllerName) . '.php';
        if (file_exists($controllerPath)) {

            include $controllerPath;

        } else {

            Route::ErrorPage404();
        }


        $dbClass    = new DBClass();

        $connection = $dbClass->getConnection();

        $controller = new $controllerName($connection);

        $method     = $methodName;

        if (method_exists($controller, $method)) {

            $controller->$method($id);

        } else {

            Route::ErrorPage404();
        }

    }

    /*
     * Return 404 page
     */
    private function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . 'main/page404');
    }
}