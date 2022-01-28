<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

require(ROOT . '/vendor/autoload.php');

class Controller
{
    /**
     * Check privilege for route access.
     *
     * @param string $role
     * @return bool|void
     */
    public function checkPathPrivilege(string $role)
    {
        switch ($role) {
            case 'admin':
                return !empty($_SESSION['user'])
                    && $_SESSION['user']['isAdmin'] === '1';
            case 'user':
                return !empty($_SESSION['user'])
                    && $_SESSION['user']['isAdmin'] === '0';
            default:
                header('Location: /');
        }
    }

    /**
     * Use to render pages.
     *
     * @param string $path
     * @param array $args
     *
     * @return void
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function twigRender(string $path, array $args = [])
    {
        $args['session'] = $_SESSION;

        $loader = new FilesystemLoader(ROOT . '\\Views');
        $twig = new Environment($loader, [
            //    'cache' => 'tmp',
            'debug' => true,
        ]);
        $twig->addExtension(new DebugExtension());

        echo $twig->render($path, $args);
    }
}
