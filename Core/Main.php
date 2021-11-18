<?php

namespace App\Core;

use App\Controllers\MainController;

class Main
{
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

            // TODO: Vérifier que le controller existe
            $controller = new $controller();

            $action = (isset($params[0])) ? array_shift($params) : 'index';

            if (method_exists($controller, $action)) {
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            } else {
                // TODO: Page 404 à mettre en place
                http_response_code(404);
                echo 'Uhuh, la page que vous souhaitez voir n\'existe plus... Ou n\'a jamais existé ?';
            }
        } else {
            $controller = new MainController();
            $controller->index();
        }
    }
}
