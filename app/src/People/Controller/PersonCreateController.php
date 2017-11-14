<?php

namespace App\People\Controller;

use App\People\Person;
use App\People\Repository\PeopleRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Slim\Interfaces\RouterInterface;
use Slim\Views\Twig;

class PersonCreateController
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

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this->view->render(
            $response,
            'app/people/create.twig'
        );
    }

    public function createPost(ServerRequestInterface $request, ResponseInterface $response)
    {
        $person = Person::create(
            Uuid::uuid4(),
            $request->getParam('name')
        );

        $this->peopleRepository->save($person);

        return $response->withRedirect($this->router->pathFor('people/index'));
    }
}
