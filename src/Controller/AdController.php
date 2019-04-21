<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AnnonceType;
use App\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ad_index")
     * @param AdRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ad(AdRepository $repository)
    {
        //$repo = $this->getDoctrine()->getRepository(Ad::class);
        $ads = $repository->findAll();

        return $this->render('ad/ad.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Allow to create an ad
     *
     * @Route("ads/new", name="ads_create")
     */
    public function create()
    {
        $ad = new Ad();

        // Build a form
        $form = $this->createForm(AnnonceType::class, $ad);

        return $this->render('ad/new.html.twig', [
                'form' => $form->createView()
        ]);
    }


    /**
     * Allow to display an ad
     *
     * @Route("/ads/{slug}", name="ads_show")
     * @param Ad $ad
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Ad $ad)
    {
        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }

}
