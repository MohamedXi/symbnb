<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Role;
use App\Entity\User;
use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\Base;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');
        $faker->addProvider(new PicsumPhotosProvider($faker));

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser
            ->setFirstName('Webmaster')
            ->setLastName('Admin')
            ->setEmail('admin@symbnb.com')
            ->setTel($faker->phoneNumber)
            ->setHash($this->userPasswordEncoder->encodePassword($adminUser, 'password'))
            ->setIntroduction($faker->sentence())
            ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
            ->setPicture('https://randomuser.me/api/portraits/lego/3.jpg')
            ->addUserRole($adminRole);
        $manager->persist($adminUser);


        // For the users in the database
        $users = [];
        $genres = ['male', 'female'];

        for ($i = 1; $i <= 10; $i++) {
            $user = new User(); // User variable

            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

            $hash = $this->userPasswordEncoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstName($genre))
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setTel($faker->phoneNumber)
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
                ->setHash($hash)
                ->setPicture($picture);

            $manager->persist($user);
            $users[] = $user;
        }

        // For the ads contents in the database
        for ($i = 1; $i <= 30; $i++) {
            $ad = new Ad(); // Ad variable

            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(285,130, true);
            $imageShow = $faker->imageUrl(430,330, true);
            $intro = $faker->paragraph(2);
            $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';

            // attribute an ad to user
            $user = $users[mt_rand(0, count($users) - 1)];

            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($intro)
                ->setContent($content)
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 5))
                ->setAuthor($user);

            for ($j = 1; $j <= mt_rand(2, 5); $j++) {
                $image = new Image();

                $image->setUrl($imageShow)
                    ->setCaption($faker->sentence())
                    ->setAd($ad);

                $manager->persist($image);
            }

            // Manage the bookings
            for ($j = 1; $j <= mt_rand(0, 10); $j++) {
                $booking = new Booking();

                $createdAt = $faker->dateTimeBetween('-6 months');
                $startDate = $faker->dateTimeBetween('-3 months');

                $duration = mt_rand(3, 10);
                $endDate = (clone $startDate)->modify("+$duration");

                $amount = $ad->getPrice() * $duration;

                $booker = $users[mt_rand(0, count($users) - 1)];

                $comment = $faker->paragraph();

                $booking
                    ->setBooker($booker)
                    ->setAd($ad)
                    ->setStartDate($startDate)
                    ->setEndDate($endDate)
                    ->setCreatedAt($createdAt)
                    ->setAmount($amount)
                    ->setComment($comment);

                $manager->persist($booking);

                if (mt_rand(0, 1)){
                    $comment = new Comment();

                    $comment
                            ->setContent($faker->paragraph())
                            ->setRating(mt_rand(1, 5))
                            ->setAuthor($booker)
                            ->setAd($ad);
                    $manager->persist($comment);
                }
            }

            $manager->persist($ad); // Persist the content
        }
        $manager->flush();
    }
}
