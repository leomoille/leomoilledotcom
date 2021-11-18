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
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
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
