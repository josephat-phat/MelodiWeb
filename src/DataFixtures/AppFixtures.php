<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Image;
use Faker\Factory;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $fake = Factory::create('FR-fr');
        $slugify = new Slugify();

        for($i=1; $i<40; $i++){
            $ad = new Ad();

            $titre = $fake->sentence(6);
            $slug = $slugify->slugify($titre);
            $image = $fake->imageUrl(1000,300);
            $introduction = $fake->paragraph(2);
            $contenu = '<p>' .join('</p><p>',$fake->paragraphs(5)) .'</p>';

            $ad->setTitre($titre)
            ->setAdresse($slug)
            ->setAppImage($image)
            ->setIntroduction($introduction)
            ->setContenu($contenu)
            ->setPrix(mt_rand(40,200))
            ->setChambre(mt_rand(1,5));

            for($j = 1; $j<=mt_rand(2,5);$j++){
                $image = new Image();

                $image->setUrl($fake->imageUrl())
                    ->setCaption($fake->sentence())
                    ->setAd($ad);
                $manager->persist($image);
            }
            $manager->persist($ad);

        }
        $manager->flush();
    }
}
