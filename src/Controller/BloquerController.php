<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BloquerController extends AbstractController
{
    #[Route('/bloquer', name: 'app_bloquer')]
    public function index(): Response
    {
        return $this->render('bloquer/index.html.twig', [
            'controller_name' => 'BloquerController',
        ]);
    }
}
