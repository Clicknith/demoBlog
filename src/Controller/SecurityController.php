<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {

        $user = new User;

        $form = $this->createForm(RegistrationType::class, $user);

        dump($request);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->IsValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            // Defining a Role => User  for each session login, the user has access to all features on the blog site except backoffice
            $user->setRoles(["ROLE_USER"]);

            $manager->persist($user); // Preparing the Insert
            $manager->flush(); // Executes the insertion request

            $this ->addFlash('success', 'Félicitations!! Vous êtes maintenant inscrit, vous pouvez maintenant cous connecter.');

            // Redirecting to Login Page after Registraion
            return $this->redirectToRoute('security_login');
        }
        
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
            
    }

    /**
     * @Route("/connexion", name="security_login")
     */

     public function login(AuthenticationUtils $autherticationutils): Response
     {
        $error = $autherticationutils->getLastAuthenticationError(); // Incase of incorrect username this method sends an error message to user

        $lastUsername = $autherticationutils->getLastUsername(); // This method displays the users email id by default on the email field since his/her last connection

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, // send an error message and the last inserted email-id in the template => refer line 26 on Login.html.twig
            'error' => $error
        ]);
     }

     /**
      * @Route("/deconnexion", name="security_logout")
      */
      public function logout()
      {
     
      }
}
