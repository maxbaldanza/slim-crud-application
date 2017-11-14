<?php

namespace App\Homepage\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class IndexController
{
    private $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this->view->render(
            $response,
            'app/homepage/index.twig'
        );
    }
}
