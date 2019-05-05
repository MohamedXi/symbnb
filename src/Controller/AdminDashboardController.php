<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     * @param ObjectManager $manager
     * @return Response
     */
    public function dashboard(ObjectManager $manager)
    {

        $users = $manager
            ->createQuery('SELECT COUNT(u) FROM App\Entity\User u')
            ->getSingleScalarResult();

        $ads = $manager
            ->createQuery('SELECT COUNT(a) FROM App\Entity\Ad a')
            ->getSingleScalarResult();

        $bookings = $manager
            ->createQuery('SELECT COUNT(b) FROM App\Entity\Ad b')
            ->getSingleScalarResult();

        $comments = $manager
            ->createQuery('SELECT COUNT(c) FROM App\Entity\Comment c')
            ->getSingleScalarResult();


        $bestAds = $manager
            ->createQuery('SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture
                FROM App\Entity\Comment c
                JOIN c.ad a
                JOIN a.author u
                GROUP BY a
                ORDER BY note DESC
            ')
            ->setMaxResults(5)
            ->getResult();


        return $this->render('admin/dashboard/dashboard.html.twig', [
            'stats' => compact('users', 'ads', 'bookings', 'comments'),
            'bestAds' => $bestAds
        ]);
    }
}
