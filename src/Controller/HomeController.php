<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function home()
    {
        $name = ["Lior, Alex, Maxime"];
        return $this->render('home/home.html.twig', [
            'title' => 'Home Controller',
            'age' => '13',
            'table' => $name,
        ]);
    }
}
