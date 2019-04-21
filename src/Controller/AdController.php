<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AnnonceType;
use App\Repository\AdRepository;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $ad = new Ad();

        // Build a form
        $form = $this->createForm(AnnonceType::class, $ad);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "The ad has <i>{$ad->getTitle()}</i> successfully registered"
            );

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }

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
