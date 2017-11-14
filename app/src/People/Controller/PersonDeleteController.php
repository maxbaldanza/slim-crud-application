<?php

namespace App\People\Controller;

use App\People\Repository\PeopleRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Slim\Interfaces\RouterInterface;
use Slim\Views\Twig;

class PersonDeleteController
{
    private $view;
    private $peopleRepository;
    private $router;

    public function __construct(Twig $view, PeopleRepository $peopleRepository, RouterInterface $router)
    {
        $this->view = $view;
        $this->peopleRepository = $peopleRepository;
        $this->router = $router;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $data)
    {
        $uuid = Uuid::fromString($data['uuid']);

        $this->peopleRepository->delete($uuid);

        return $response->withRedirect($this->router->pathFor('people/index'));
    }
}
