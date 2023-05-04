<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\ResetPasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Form\UtilisateurType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Persistence\ManagerRegistry ;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\Extension\Core\Type\{TextType,ButtonType,EmailType,HiddenType,PasswordType,TextareaType,SubmitType,NumberType,DateType,MoneyType,BirthdayType};
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class InscriptionController extends AbstractController
{
    private $passwordHasher;

public function __construct(UserPasswordHasherInterface $passwordHasher)
{
    $this->passwordHasher = $passwordHasher;
}
    

    /**
 * @Route("/inscription", name="app_inscription")
 * Method({"GET", "POST"})
 */
 public function new(ManagerRegistry  $doctrine, Request $request, SluggerInterface $slugger,MailerInterface $mailer) {
    $Utilisateur= new User();
    $Cls= $doctrine->getManager() ;
    $form=$this->createForm(RegistrationType::class,$Utilisateur);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()) {
    
        $Utilisateur->setRoles(['ROLE_USER']);
         $Utilisateur->setPassword($this->passwordHasher->hashPassword($Utilisateur, $Utilisateur->getPassword()));

        $brochureFile = $form->get('image')->getData();

        // this condition is needed because the 'brochure' field is not required
        // so the PDF file must be processed only when a file is uploaded
        if ($brochureFile) {
            $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $brochureFile->move(
                    $this->getParameter('persone_image'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochureFilename' property to store the PDF file name
            // instead of its contents
            $Utilisateur->setImage($newFilename);
        }
     $Utilisateur = $form->getData();
     $entityManager = $doctrine->getManager();
     $entityManager->persist($Utilisateur);
     $entityManager->flush();
     $email = (new TemplatedEmail())
     ->from('DealTroc@gmail.com')
     ->to($Utilisateur->getEmail())
     //->cc('cc@example.com')
     //->bcc('bcc@example.com')
     //->replyTo('fabien@example.com')
     //->priority(Email::PRIORITY_HIGH)
     ->subject('Bienvenue'. $Utilisateur->getUsername().'sur DealTroc')
     ->text('Sending emails is fun again!')
     ->htmlTemplate('mailBienvenu.html.twig');

     $mailer->send($email);
     return $this->redirectToRoute('security_login');
    }
    return $this->render('inscription/index.html.twig',['form' => $form->createView()]);
    
   

}


#[Route('/oubli/{token}', name: 'forgottenPasswordObli')]
public function verifCode(Request $req,string $token,UserRepository $rep,ManagerRegistry $m , UserPasswordHasherInterface $encode) : Response
{
    $user=$rep->findOneByResetToken($token);
    if($user)
    {
        $form=$this->createForm(ResetPasswordFormType::class);
        $form->handleRequest($req);
        
        if($form->isSubmitted() )
        {
            $user->setResetToken('');
            $user->setPassword(
                $encode->hashPassword(
                    $user,$form->get('password')->getData()
                ));
                $l= $m->getManager();
                $l->persist($user);
                $l->flush();
                return $this->redirectToRoute('security_login');
        }
        return $this->render('inscription/reset_password.html.twig',['requestPassForm'=>$form->createView()]);
    }
   
    return $this->redirectToRoute('security_login');
 
}

#[Route('/forgotPassword', name: 'forgottenPassword')]
public function ForgetPassword(Request $req,UserRepository $rep,ManagerRegistry $m ,MailerInterface $mailer, TokenGeneratorInterface $tok) : Response
{
    $form=$this->createForm(ResetPasswordRequestFormType::class);
    $form->handleRequest($req);
 
    if($form->isSubmitted() )
    {
       

        $user=$rep->findOneByEmail($form->get('email')->getData());
        if($user)
        {
            $token =$tok->generateToken();
            $user->setResetToken($token);
            $l= $m->getManager();
            $l->persist($user);
            $l->flush();
            $url = $this->generateUrl('forgottenPasswordObli',['token'=>$token],UrlGeneratorInterface :: ABSOLUTE_URL);
            $context = compact('url','user');

            $email = (new TemplatedEmail())
            ->from('DealTroc@gmail.com')
            ->to($user->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Bienvenue'. $user->getUsername().'sur DealTroc')
            ->text('Sending emails is fun again!')
            ->context($context)
            ->htmlTemplate('verifierPassword.html.twig');
       
            $mailer->send($email);
        
        }
            return $this->redirectToRoute('security_login');
        
        
    }


    return $this->render('inscription/reset_password_request.html.twig',['requestPassForm'=>$form->createView()]);
}

 /**
 * @Route("/connexion",name="security_login")
 */
public function login(AuthenticationUtils  $authenticationUtils,UserRepository $rep)
{
     // get the login error if there is one
$error = $authenticationUtils->getLastAuthenticationError();


// last username entered by the user
$lastUsername = $authenticationUtils->getLastUsername();

    
    
    return $this->render('inscription/login.html.twig',['lastUsername'=>$lastUsername,
                                                    'error' => $error]);
    //return $this->redirectToRoute('app_home');
}

/**
* @Route("/deconnexion",name="security_logout")
*/
public function logout()
{ }



}