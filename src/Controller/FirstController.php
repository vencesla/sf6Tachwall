<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route(
        '/first',
        name: 'first')]
    public function index(): Response
    {
        $name = 'Henry';
        $firstname = 'joelle';
        return $this->render('first/index.html.twig', [
            'firstname' => $firstname,
            'name' => $name
        ]);
    }

    ##[Route('/sayHello/{name}/{firstname}', name: 'app_first')]
    public function sayHello(Request $request, $name, $firstname): Response
    {
        return $this->render('first/hello.html.twig', [
            'nom' => $name,
            'prenom' => $firstname,
        ]);
    }


}
