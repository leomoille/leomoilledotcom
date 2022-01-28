<?php

namespace App\Core;

use App\Controllers\MainController;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Main
{
    /**
     * @return void
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function start()
    {
        $uri = $_SERVER['REQUEST_URI'];

        if (!empty($uri) && $uri !== '/' && $uri[-1] === '/') {
            $uri = substr($uri, 0, -1);
            http_response_code(301);
            header('Location: ' . $uri);
        }

        $params = explode('/', $_GET['p']);

        if ($params[0] != '') {
            $controller = '\\App\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';

            if (class_exists($controller)) {
                $controller = new $controller();
                $action = (isset($params[0])) ? array_shift($params) : 'index';

                if (method_exists($controller, $action)) {
                    (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action(
                    );
                } else {
                    header('Location: /');
                }
            } else {
                header('Location: /');
            }
        } else {
            $controller = new MainController();
            $controller->index();
        }
    }
}
