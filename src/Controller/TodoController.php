<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/todo")]

class TodoController extends AbstractController
{
    #[Route('/', name: 'app_todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        // Afficher notre tableau de todo
        // sinon je l'initialise puis j'affiche
        if(!$session->has('todos')){
            $todos = array(
                'achat' =>'acheter cle usb',
                'cours' =>'Finaliser mon cours',
                'correction'=>'corriger mes examens'
            );
            $session->set('todos', $todos);
            $this->addFlash('info', "La liste des todos vient d'etre initialiser");
        }
        // si j ai mon tableau de todo dans ma session je ne fait que l'afficher

        return $this->render('todo/index.html.twig');
    }

    #[Route(
        '/add/{name}/{content}',
        name: 'todo.add',
        defaults: ['content' => 'sf6'])
    ]
    public function addTodo(Request $request, $name, $content): RedirectResponse{
        $session = $request->getSession();
        //vérifier si j'ai mon tableau de todo dans ma session
        if($session->has('todos')){
            // si oui
            $todos = $session->get('todos');
            if(isset($todos[$name])){
                // si on a déjà un todo avec le meme name
                // si oui afficher erreur
                $this->addFlash('error', "Le todo d'id $name existe déjà dans la liste");
            }else{
                $todos[$name] = $content;
                $this->addFlash('success', "Le todo d'id $name a été ajouté avec success");
                //si non on ajoute et on affiche un message de success
                $session->set('todos', $todos);
            }

        }else{
            //si non

            // afficher une erreur et on av rediriger ver le controller index
            $this->addFlash('error', "La liste des todos n'est pas encore intialisée");
        }
        return $this->redirectToRoute('app_todo');
    }

    #[Route('/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse{
        $session = $request->getSession();
        //vérifier si j'ai mon tableau de todo dans ma session
        if($session->has('todos')){
            // si oui
            $todos = $session->get('todos');
            if(!isset($todos[$name])){
                // si on a déjà un todo avec le meme name
                // si oui afficher erreur
                $this->addFlash('error', "Le todo d'id $name n'existe pas dans la liste");
            }else{
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash('success', "Le todo d'id $name a été modifié avec success");
                //si non on ajoute et on affiche un message de success

            }

        }else{
            //si non

            // afficher une erreur et on av rediriger ver le controller index
            $this->addFlash('error', "La liste des todos n'est pas encore intialisée");
        }
        return $this->redirectToRoute('app_todo');
    }

    #[Route('/delete/{name}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name): RedirectResponse{
        $session = $request->getSession();
        //vérifier si j'ai mon tableau de todo dans ma session
        if($session->has('todos')){
            // si oui
            $todos = $session->get('todos');
            if(!isset($todos[$name])){
                // si on a déjà un todo avec le meme name
                // si oui afficher erreur
                $this->addFlash('error', "Le todo d'id $name n'existe pas dans la liste");
            }else{
                unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash('success', "Le todo d'id $name a été suprimé avec success");
                //si non on ajoute et on affiche un message de success

            }

        }else{
            //si non

            // afficher une erreur et on av rediriger ver le controller index
            $this->addFlash('error', "La liste des todos n'est pas encore intialisée");
        }
        return $this->redirectToRoute('app_todo');
    }

    #[Route('/reset', name: 'todo.reset')]
    public function resetodo(Request $request){
        $session = $request->getSession();
        $session->remove('todos');

        return $this->redirectToRoute('app_todo');
    }

    #[Route(
        '/multi/{entier1}/{entier2}',
        name: 'todo.multi',
        requirements: ['entier1' => '\d+', 'entier2' => '\d+']
    )]
    public function multiplication($entier1, $entier2){
        $resultat = $entier1*$entier2;
        
        return new Response("<h1>$resultat</h1>");
    }



}
