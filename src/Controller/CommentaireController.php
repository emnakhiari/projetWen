<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twilio\Rest\Client;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;



use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommentaireRepository;
use App\Repository\SignalerRepository;

use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Form\RechBackType;
use App\Form\RechProdType;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;

class CommentaireController extends AbstractController
{
    private $flashBag;

    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }
    #[Route('/commentaire/mail', name: 'app_commentaire_mail')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('lbeya99@gmail.com')
            ->to('lbeya@gmail.com')
            ->subject('Test email')
            ->text('This is a test email sent via Symfony.');
    
        $mailer->send($email);
        
        return $this->redirectToRoute('app_affiche_classroom');
    }
    
    
    #[Route('/Commentaire/add', name: 'app_add_Commentaire')]
    public function addCommentaire(Request $request,ManagerRegistry $doctrine,MailerInterface $mailer,TexterInterface $texter): Response
    {   
        $commentaire=new Commentaire();
        $commentaire ->setIdproduit(1);
        $commentaire ->setIdUtilisateur(1);
        $commentaire->setDate(new \DateTime('now'));

        //cération du formulaire
        $form=$this->createForm(CommentaireType::class,$commentaire);

        //remplir l'objet a partir du formulaire
        //les getters
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $commentaire = $form->getData();
            $id = $commentaire->getCommentaire();
            if ($id == NULL) {
                $this->addFlash('error', 'Vous devez inserer un commentaire');
                return $this->redirectToRoute('app_affiche_classroom');
            }
            //gestionaire
            $em=$doctrine->getManager();
            //ajout
            $em->persist($commentaire);
            $em->flush();

            //$email0=$commentaire->findOneEmailByIdArticle($id);
            $email = (new Email())
            ->from('lbeya99@gmail.com')
            ->to('lbeya99@gmail.com')
            ->subject('DealTroc')
            ->html('<html><body><h1><span style="color:pink;">Welcome to DealTroc</span></h1><h1><p><span style="color:green">Someone commented your article</p></body></html>');

    
        $mailer->send($email);

                        // Replace with your Twilio Account SID and Auth Token
                        $sid = 'ACdecd415a5f91bbc7debfdbe0ecf5cd81';
                        $token = 'c847473b2ec18849c3db65865a328b9a';
                
                        // Create a new Twilio client instance
                        $twilioClient = new Client($sid, $token);
                
                        // Replace with the phone number you want to send the SMS to
                        $toNumber = '+21695816137';
                
                        // Replace with the Twilio phone number you want to send the SMS from
                        $fromNumber = '+12766378349';
                
                        // Replace with the SMS message you want to send
                        $messageBody = 'Hello, this is eya';
                
                        // Use the Twilio client to send the SMS message
                        $twilioClient->messages->create(
                            $toNumber, // The phone number to send the SMS to
                            [
                                'from' => $fromNumber, // The Twilio phone number to send the SMS from
                                'body' => $messageBody, // The message body
                            ]
                        );
                            

            $this->addFlash('success', 'Votre commentaire a été ajouté avec succès !');
            return $this->redirectToRoute('app_affiche_classroom');
        }
        



              //on va envoyer le formulaire a la vue
              return $this->renderForm('Commentaire/add.html.twig', [
                'myForm' => $form,
            ]);
}

    #[Route('/commentaire', name: 'app_commentaire')]
    public function index(): Response
    
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }

    
    #[Route('/commentaire/RechParUser', name: 'app_GetAll_commentaire')]
    public function GetAll_(CommentaireRepository $repo,SignalerRepository $repo1,Request $request): Response
    {
        $commentaire=new Commentaire();
        $Form=$this->createForm(RechBackType::class,$commentaire);


        $Form->handleRequest($request);
        if ($Form->isSubmitted() && $Form->isValid()) {
            $commentaire = $Form->getData();
            $id = $commentaire->getIdUtilisateur();
            if ($id == NULL) {
                $this->addFlash('error', 'Vous devez inserer un id');
                return $this->redirectToRoute('app_GetAll_commentaire');
            }
            $commentaires = $repo->findBy(array('idUtilisateur' => $id));
        } else {
            $commentaires = $repo->findAll();
        }
        $commentaire = $Form->getData();
        $id = $commentaire->getIdUtilisateur();
    $nbrComment =$repo->countCommentaire($id);

    $nbrCommentSignaler = $repo->countByCommentaireIsSignaler($id);

    return $this->render('commentaire/back.html.twig',
        array('form'=>$Form->createView(),
        'listes'=>$commentaires,
        'nbr'=>$nbrComment,
        'id'=>$id,
        'nbr2'=>0,
        'nbr1'=>$nbrCommentSignaler

     ));


    }

    #[Route('/commentaire/RechParArticle', name: 'app_GetAll1_commentaire')]
    public function GetAll1_(CommentaireRepository $repo,SignalerRepository $repo1,Request $request): Response
    {
        $commentaire=new Commentaire();
        $Form=$this->createForm(RechProdType::class,$commentaire);


        $Form->handleRequest($request);
        if ($Form->isSubmitted() && $Form->isValid()) {
            $commentaire = $Form->getData();
            $id = $commentaire->getIdproduit();
            if ($id == NULL) {
                $this->addFlash('error', 'Vous devez inserer un id');
                return $this->redirectToRoute('app_GetAll_commentaire');
            }
            $commentaires = $repo->findBy(array('idproduit' => $id));
        } else {
            $commentaires = $repo->findAll();
        }
        $commentaire = $Form->getData();
        $id = $commentaire->getIdproduit();
    $nbrComment =$repo->countCommentaireArticle($id);
    $nbrCommentSignaler = $repo->countByCommentaireIsSignaler($id);

    return $this->render('commentaire/back.html.twig',
        array('form'=>$Form->createView(),
        'nbr'=>0,
        'listes'=>$commentaires,
        'nbr2'=>$nbrComment,
        'nbr3'=>$nbrCommentSignaler,
        'id'=>$id,

     ));


    }


   /* #[Route('/Commentaire/add', name: 'app_add_Commentaire')]
    public function addCommentaire(Request $request,ManagerRegistry $doctrine): Response
    {   
        $commentaire=new Commentaire();
        $commentaire ->setIdproduit(1);
        $commentaire ->setIdUtilisateur(1);
        $commentaire->setDate(new \DateTime('now'));
        //cération du formulaire
        $form=$this->createForm(CommentaireType::class,$commentaire);

        //remplir l'objet a partir du formulaire
        //les getters
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $commentaire = $form->getData();
            $id = $commentaire->getCommentaire();
            if ($id == NULL) {
                $this->addFlash('error', 'Vous devez inserer un commentaire');
                return $this->redirectToRoute('app_affiche_classroom');
            }
            //gestionaire
            $em=$doctrine->getManager();
            //ajout
            $em->persist($commentaire);
            $em->flush();

            $this->addFlash('success', 'Votre commentaire a été ajouté avec succès !');
            return $this->redirectToRoute('app_affiche_classroom');
        }



              //on va envoyer le formulaire a la vue
              return $this->renderForm('Commentaire/add.html.twig', [
                'myForm' => $form,
            ]);
}*/


////////////////////////////
#[Route('/Commentaire/Modif/{id}', name: 'app_modif_Commentaire')]
public function ModifCommentaire($id,CommentaireRepository $repo,Request $request,ManagerRegistry $doctrine): Response
{
    $commentaire= $repo->find($id);
    //cération du formulaire
    $form=$this->createForm(CommentaireType::class,$commentaire);
    $idUtilisateurConnecte = 1;
    $idUtilisateurCommentaire = $commentaire->getIdUtilisateur();
    if ($idUtilisateurConnecte !== $idUtilisateurCommentaire) {
        //throw new AccessDeniedException('Vous n\'êtes pas autorisé à supprimer ce commentaire');
       $this->addFlash('error', 'Impossible modifier ce commentaire');

       //$this->addFlash('error', 'Test error message');
      // var_dump($this->flashBag->all());
       //return $this->render('Commentaire/essai.html.twig');
       return $this->redirectToRoute('app_affiche_classroom');
    }
    //remplir l'objet a partir du formulaire
    //les getters
    $form->handleRequest($request);
    if($form->isSubmitted()){
        //gestionaire
        $em=$doctrine->getManager();
        //ajout
        $em->persist($commentaire);
        $em->flush();
        $this->addFlash('success', 'Votre commentaire a été modifié avec succès !');
        return $this->redirectToRoute('app_affiche_classroom');
    }
          //on va envoyer le formulaire a la vue
          return $this->renderForm('Commentaire/add.html.twig', [
            'myForm' => $form,
        ]);
}

////////////////////////////////////
#[Route('/Commentaire/del/{id}', name: 'app_del_classroom')]
public function supp($id,CommentaireRepository $repo,ManagerRegistry $doctrine): Response
{
    $Commentaire= $repo->find($id);
    $em=$doctrine->getManager();
        $em->remove($Commentaire);
        $em->flush();
    
    #3-redirection vers la liste pour l'affichage
    return $this->redirectToRoute('app_affiche_classroom');
}
/////////////////////////
#[Route('/Commentaire1/del/{id}', name: 'app_del1_classroom')]

public function supprimerCommentaire($id,Request $request)
{
    // Récupère le commentaire depuis la base de données en utilisant l'id
    $commentaire = $this->getDoctrine()->getRepository(Commentaire::class)->find($id);

    if (!$commentaire) {
        throw $this->createNotFoundException('Aucun commentaire trouvé pour l\'id ' . $id);
    }
    // Vérifie si l'utilisateur connecté est l'auteur du commentaire
    $idUtilisateurConnecte = 1;
    $idUtilisateurCommentaire = $commentaire->getIdUtilisateur();

    if ($idUtilisateurConnecte !== $idUtilisateurCommentaire) {
       $this->addFlash('error', 'Impossible de supprimer ce commentaire');
       return $this->redirectToRoute('app_affiche_classroom');
    }

    // Supprime le commentaire de la base de données
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($commentaire);
    $entityManager->flush();
    // Affiche un message de confirmation
    $this->addFlash('success', 'Le commentaire a été supprimé avec succès');

    // Redirige l'utilisateur vers la page d'accueil ou une autre page
    $this->addFlash('success', 'Votre commentaire a été supprimé avec succès !');
    return $this->redirectToRoute('app_affiche_classroom');
}

////////Afficher tous avec query
#[Route('/Commentaire/Affiche', name: 'app_affiche_classroom')]
public function Affiche(CommentaireRepository $commentRepository): Response
{   $idUser=1;
    $qb = $commentRepository->createQueryBuilder('c')
    ->Where('c.idproduit =:x')
    ->andWhere('c.commentaire NOT LIKE :comment ')
    ->setParameter('x', $idUser)
    ->setParameter('comment', 'Signaler');

    $query = $qb->getQuery();
    $comments = $query->getResult();
    return $this->renderForm('Commentaire/list.html.twig', [
        'listes' => $comments
    ]);
    }
              
///////////////////////////////// rech
#[Route('/Commentaire/TypeP', name: 'app_type_classroom')]
public function AfficheTypeP(CommentaireRepository $commentRepository): Response
{     $qb = $commentRepository->createQueryBuilder('c')
                            ->Where('c.type LIKE :type')
                            ->setParameter('type', 'P%');

                        
    $query = $qb->getQuery();
    $comments = $query->getResult();
    return $this->render('Commentaire/list.html.twig', [
        'listes' => $comments
    ]);
    }

//////////////////////////////////// recherche par id unique
#[Route('/Commentaire/rech/{id}', name: 'app_rech_classroom')]
public function rech($id,CommentaireRepository $repo): Response
{
    $comment =$repo->find($id);

    if (!$comment) {
        throw $this->createNotFoundException(
            'Aucun commentaire trouvé pour l\'id '.$id
        );
    }

    return $this->render('commentaire/Recherche.html.twig', [
        'comment' => $comment,
    ]);
}

//////////////////////////////////// Recherche qui retourne une liste
#[Route('/Commentaire/find/{id}', name: 'app_find_classroom')]
public function find($id,CommentaireRepository $repo): Response
{
    $comment =$repo->findByIdUser($id);

    return $this->render('commentaire/list.html.twig',[
       "listes" => $comment]);
    
}

//////////////////////////////////// le nombre de commentaire par chaque user
#[Route('/Commentaire/calcul/{idUser}', name: 'app_calcul_commentaire')]
public function calcule($idUser,CommentaireRepository $repo): Response
{
    $comment =$repo->countCommentaire($idUser);

    return $this->render('commentaire/nombreEst.html.twig',[
       'nbr'=>$comment,
       'id'=>$idUser
    ]);
    }


    //////////////////////////////////// rech les commentaire dont le type commence par P 
#[Route('/Commentaire/StartWithP', name: 'app_StartWithP_classroom')]
public function findStartWithP(CommentaireRepository $repo): Response
{
    $comment =$repo->findTypeStartwithP();

    return $this->render('commentaire/list.html.twig',[
       "listes" => $comment]);
    
}

}
