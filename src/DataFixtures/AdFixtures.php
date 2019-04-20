<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AdFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // For the content in the database
        for ($i = 1; $i <= 30; $i++) {
            $ad = new Ad(); // Ad variable
            $ad->setTitle("Ad title n°$i")
                ->setSlug("ad-title-n-$i")
                ->setCoverImage("http://placehold.it/1000x300")
                ->setIntroduction("Hello everybody, this an introduction")
                ->setContent("<p>I'm a rich content</p>")
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 5));
            $manager->persist($ad); // Persist the content
        }
        $manager->flush();
    }
}
