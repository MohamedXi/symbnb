<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AdFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');
        $slugify = new Slugify();

        // For the content in the database
        for ($i = 1; $i <= 30; $i++) {
            $ad = new Ad(); // Ad variable

            $title = $faker->sentence();
            $slug = $slugify->slugify($title);
            $coverImage = $faker->imageUrl('1000, 350');
            $intro = $faker->paragraph(2);
            $content = '<p>' . join('</p><p>', $faker-> paragraphs(5)) . '</p>';

            $ad->setTitle($title)
                ->setSlug($slug)
                ->setCoverImage($coverImage)
                ->setIntroduction($intro)
                ->setContent($content)
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 5));
            $manager->persist($ad); // Persist the content
        }
        $manager->flush();
    }
}
