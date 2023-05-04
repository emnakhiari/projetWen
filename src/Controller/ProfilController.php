<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig');
    }
    #[Route('/profil/modifier/{id}', name:'update')]  
    public function ModifierButton(ManagerRegistry $doctrine, $id, Request $req): Response
    {
       $user = new User();
       $d= $doctrine->getManager() ;
       $user=$doctrine->getRepository(User::class)->find($id); 
       $form=$this->createForm(ModifierType::class,$user);
       $form->handleRequest($req);
       if($form->isSubmitted() && $form->isValid() )
       {
        
         
        $d->flush();

         return $this->redirectToRoute('app_profil');
         
       }
       
       
       return $this->render('profil/update.html.twig', [
        'form' => $form->createView(),'id' => $user->getId()
    ]);
    }
}
