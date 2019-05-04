<?php

namespace App\Controller;

use App\Entity\UpdatePassword;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * The login function
     * @Route("/login", name="account_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
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
     * The logout function
     * @Route("/logout", name="account_logout")
     * @return void
     */
    public function logout()
    {

    }

    /**
     * The register function
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
            $hash = $userPasswordEncoder->encodePassword($user, $user->getHash());
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

    /**
     * The profile update
     * @Route("/account/profile", name="account_profile")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function profile(Request $request, ObjectManager $manager)
    {
        $user = $this->getUser();

        $form = $this->createForm(AccountType::class, $user);

        // Manage the registration form with Request function
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Your changes have been saved"
            );

            return $this->redirectToRoute('account_profile');
        }

        return $this->render('account/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/account/update-password", name="account_password")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, ObjectManager $manager)
    {
        $passwordUpdate = new UpdatePassword();

        // Get the current user password
        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getHash())) {
                // Verify the current user password
                $form->get('oldPassword')->addError(new FormError('The current password does not match'));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $userPasswordEncoder->encodePassword($user, $newPassword);

                $user->setHash($hash);
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Your password has been changed'
                );

                return $this->redirectToRoute('account_profile');
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/account", name="account_index")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function myAccount()
    {
        return $this->render('user/user.html.twig', [
            'user' => $this->getUser()
        ]);
    }


    /**
     * Allow display the bookings list of users
     * @Route("/account/bookings", name="account_bookings")
     * @return Response
     */
    public function bookings()
    {
        return $this->render('account/bookings.html.twig');
    }
}
