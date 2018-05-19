<?php

include_once 'config/dbclass.php';


class Route
{
    /**
     * Start routing, load controller and run method
     */
    static function start()
    {


        $methodName     = 'index';
        $controllerName = 'Main';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($routes[1])) {
            $controllerName = $routes[1];
        }

        if (!empty($routes[2])) {
            $methodName = $routes[2];
        }

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

            $controller->$method();

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
        header('Location:' . $host . '404');
    }
}