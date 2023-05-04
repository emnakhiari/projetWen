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
        $a=$rep->findAll();
        $UserJson=$serializer->serialize($a, 'json',['groups'=>["user"]]);
        return new JsonResponse($UserJson);
    }
    #[Route('/{id}/new', name: 'app_rendez_json_vous_new', methods: ['GET', 'POST'])]
    public function new(Request $request,UserRepository $patientRep ,UserRepository $rep,NormalizerInterface $Normalizer): Response
    {
        $user = new User();
        $rendezVou->setDate($request->get('date'));
        $rendezVou->setHeureDebut($request->get('heureDebut'));
        $rendezVou->setHeureFin($request->get('heureFin'));
        $rendezVou->setSymptomes($request->get('symptomes'));
        $rendezVousRepository->save($rendezVou, true);
        $jsonContent = $Normalizer->normalize($rendezVou, 'json', ['groups' => 'rendezVous']);
        return new Response(json_encode($jsonContent));


    }
}
