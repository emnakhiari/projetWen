<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\SerializerInterface;


#[Route('/UserApi')]
class UserApiController extends AbstractController
{
    #[Route('/show', name: 'app_user_api', methods: ['GET'])]
    public function index(Request $request,UserRepository $rep,SerializerInterface $serializer): JsonResponse
    {
        $users=$rep->findAll();
       $UserJson=$serializer->serialize($users, 'json',['groups'=>['user']]);
      
        return new JsonResponse($UserJson, 200, ['Content-Type' => 'application/json']);
    }

    
}
