<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Episode;
use App\DataFixtures\SeasonFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR'); 
        for ($i = 0; $i <= 349; $i++) {
            $episode = new Episode();  
            $episode->setNumber($i%10);
            $episode->setTitle($faker->word);
            $episode->setSynopsis($faker->text(300));

            $manager->persist($episode);
            $this->addReference('episode_' . $i, $episode);
            $episode->setSeasonId($this->getReference('season_' . $i%6));
        }  
        $manager->flush();
    }

    public function getDependencies()  
    {
        return [SeasonFixtures::class];  
    }
}
