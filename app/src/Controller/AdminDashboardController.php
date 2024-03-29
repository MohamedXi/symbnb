<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Service\Statistics;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     * @param ObjectManager $manager
     * @param Statistics $statistics
     * @param CommentRepository $commentRepository
     * @return Response
     */
    public function dashboard(ObjectManager $manager, Statistics $statistics, CommentRepository $commentRepository)
    {
        $stats      = $statistics->getStats();
        $bestAds    = $statistics->getAdsStats('DESC');
        $worstAds   = $statistics->getAdsStats('ASC');

        return $this->render('admin/dashboard/dashboard.html.twig', [
            'stats'     => $stats,
            'bestAds'   => $bestAds,
            'worstAds'  => $worstAds,
            'comment'   => $commentRepository
        ]);
    }
}
