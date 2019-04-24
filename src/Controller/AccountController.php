<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        dump($error);
        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'lastUsername' => $lastUsername
        ]);
    }

    /**
     * @Route("/logout", name="account_logout")
     * @return void
     */
    public function logout()
    {

    }

    /**
     * @Route("/register", name="account_register")
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @return Response
     */
    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        //create a new user
        $user = new  User();

        // Create a new registration form
        $form = $this->createForm(RegistrationType::class, $user);

        // Manage the registration form with Request function
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash the password with bcrypt
            $hash = $userPasswordEncoder->encodePassword($user ,$user->getHash());
            $user->setHash($hash);

            // Show the alert message
            $this->addFlash(
              'success',
                "Your account has created successfully"
            );

            // Save in database
            $manager->persist($user);
            $manager->flush();

            // Redirect after created an account
            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
