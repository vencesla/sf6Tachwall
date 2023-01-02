<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(Request $request): Response
    {
        // session_start with php
        $session = $request->getSession();
        if($session->has('nbVisit')) {
            $nbreVisit = $session->get('nbVisit') + 1;
        }else {
            $nbreVisit = 1;
        }
        $session->set('nbVisit', $nbreVisit);
        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }
}
