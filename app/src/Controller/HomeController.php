<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param AdRepository $adRepository
     * @param UserRepository $userRepository
     * @return Response
     */
    public function home(AdRepository $adRepository, UserRepository $userRepository)
    {
        return $this->render('home/home.html.twig', [
            'ads' => $adRepository->findByBestAds(3),
            'users' => $userRepository->findByBestUsers(3)
        ]);
    }
}
