<?php

namespace App\Controller;

use Twilio\Rest\Client;
use App\Entity\Signaler;
use App\Form\SignalerType;
use App\Entity\Commentaire;
use App\Repository\SignalerRepository;
use App\Repository\CommentaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class SignalerController extends AbstractController
{
    #[Route('/signaler', name: 'app_signaler')]
    public function index(): Response
    {
        return $this->render('signaler/index.html.twig', [
            'controller_name' => 'SignalerController',
        ]);
    }

    #[Route('/signal/add/{id}', name: 'app_add_signal')]
    public function addSignal($id,Request $request,ManagerRegistry $doctrine,CommentaireRepository $repo,SignalerRepository $repo1): Response
    {   $signal=new Signaler();
        $comment=new Commentaire();

        $comment= $repo->findOneById($id);
        $idUserC = $comment->getIdUtilisateur();
        
        $signal ->setCommentaire($comment);
        $signal ->setUserProp($idUserC);
        $signal ->setUserAction(1);

        //cération du formulaire
        $form=$this->createForm(SignalerType::class,$signal);

        //remplir l'objet a partir du formulaire
        //les getters
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $signal = $form->getData();
            $ch = $signal->getCause();
            if ($ch == NULL) {
                $this->addFlash('error', 'Vous devez inserer une cause');
                return $this->redirectToRoute('app_affiche_classroom');
            }
            //gestionaire
            $em=$doctrine->getManager();
            //ajout
            $em->persist($signal);
            $em->flush();

            $nbr= $repo1->countBySignalC($id);
           /* if($nbr == 2 ){
                $Commentaire= $repo->find($id);
                $em=$doctrine->getManager();
                    $em->remove($Commentaire);
                    $em->flush();
                    $this->addFlash('error', 'Ce commentaire a été retiré');
                    return $this->redirectToRoute('app_affiche_classroom');
            }*/
            if ($nbr == 1) {
                $Commentaire = $repo->find($id);
                $Commentaire->setCommentaire("Signaler");
                $em = $doctrine->getManager();
                $em->persist($Commentaire);
                $em->flush();
                $this->addFlash('error', 'Ce commentaire a été retiré');

                
                        // Replace with your Twilio Account SID and Auth Token
                        $sid = 'AC51068d2d77a6e95960b5150a241f2e2a';
                        $token = '89a86a4b3cd8da668a967314ad19ea22';
                
                        // Create a new Twilio client instance
                        $twilioClient = new Client($sid, $token);
                
                        // Replace with the phone number you want to send the SMS to
                        $toNumber = '+21695816137';
                
                        // Replace with the Twilio phone number you want to send the SMS from
                        $fromNumber = '+16076382779';
                
                        // Replace with the SMS message you want to send
                        $messageBody = 'Vous avez été sugnalé, voyre commentaire a été retiré';
                
                        // Use the Twilio client to send the SMS message
                       /* $twilioClient->messages->create(
                            $toNumber, // The phone number to send the SMS to
                            [
                                'from' => $fromNumber, // The Twilio phone number to send the SMS from
                                'body' => $messageBody, // The message body
                            ]
                        );*/
                            

                return $this->redirectToRoute('app_affiche_classroom');
            }
            


            $this->addFlash('success', 'Votre cause a été ajouté avec succès !');
            return $this->redirectToRoute('app_affiche_classroom');
            //return $this->render('commentaire/essai.html.twig',[
               // 'Comm'=>$comment
            //]);
        }

           //on va envoyer le formulaire a la vue
           return $this->renderForm('signaler/add.html.twig', [
            'myForm' => $form,
        ]);
}


}
