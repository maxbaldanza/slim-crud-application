<?php

namespace App\People\Controller;

use App\People\Repository\PeopleRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class PersonListController
{
    private $view;
    private $peopleRepository;

    public function __construct(Twig $view, PeopleRepository $peopleRepository)
    {
        $this->view = $view;
        $this->peopleRepository = $peopleRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this->view->render(
            $response,
            'app/people/index.twig',
            [
                'people' => $this->peopleRepository->findAll()
            ]
        );
    }
}
