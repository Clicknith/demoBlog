<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
<<<<<<< HEAD
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
=======
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
>>>>>>> b4b04c116d82e89d213b6680c20d85586fc4f2fd

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {

        $user = new User;

        $form = $this->createForm(RegistrationType::class, $user);
<<<<<<< HEAD
        
        return $this->render('security/registration.html.twig');
            'form' => $form->createView()
=======

        dump($request);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->IsValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $manager->persist($user); // Preparing the Insert
            $manager->flush(); // Executes the insertion request

            $this ->addFlash('success', 'Félicitations!! Vous êtes maintenant inscrit, vous pouvez maintenant cous connecter.');

            // Redirecting to Login Page after Registraion
            return $this->redirectToRoute('security_login');
        }
        
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
            
>>>>>>> b4b04c116d82e89d213b6680c20d85586fc4f2fd
    }

    /**
     * @Route("/connexion", name="security_login")
     */

     public function login()
     {

        return $this->render('security/login.html.twig');
     }

     /**
      * @Route("/deConnexion", name="security_logout")
      */
      public function logout()
      {
     
      }
}
