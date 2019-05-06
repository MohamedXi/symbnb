<?php


namespace App\Service;


use Doctrine\Common\Persistence\ObjectManager;

class Statistics
{
    private $manager;

    /**
     * Statistics constructor.
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function getUserCount()
    {
        return $this->manager
            ->createQuery('SELECT COUNT(u) FROM App\Entity\User u')
            ->getSingleScalarResult();
    }

    public function getAdsCount()
    {
        return $this->manager
            ->createQuery('SELECT COUNT(a) FROM App\Entity\Ad a')
            ->getSingleScalarResult();
    }

    public function getBookingsCount()
    {
        return $this->manager
            ->createQuery('SELECT COUNT(b) FROM App\Entity\Ad b')
            ->getSingleScalarResult();
    }

    public function getCommentCount()
    {
        return $this->manager
            ->createQuery('SELECT COUNT(c) FROM App\Entity\Comment c')
            ->getSingleScalarResult();
    }

    /**
     * @param $direction
     * @return mixed
     */
    public function getAdsStats($direction)
    {
        return $this->manager
            ->createQuery('SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture
                FROM App\Entity\Comment c
                JOIN c.ad a
                JOIN a.author u
                GROUP BY a
                ORDER BY note ' . $direction
            )
            ->setMaxResults(5)
            ->getResult();
    }

    public function getStats()
    {
        $users      = $this->getUserCount();
        $ads        = $this->getAdsCount();
        $bookings   = $this->getBookingsCount();
        $comments   = $this->getCommentCount();

        return compact('users', 'ads', 'bookings', 'comments');
    }
}