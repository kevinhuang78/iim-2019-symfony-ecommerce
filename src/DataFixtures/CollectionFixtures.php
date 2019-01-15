<?php

namespace App\DataFixtures;

use App\Entity\Collection;
use Cocur\Slugify\Slugify;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CollectionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Instancy Slugify
        $slugify = new Slugify();
        // Instancy Faker
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++){
            // Tmp var to get same name
            $name = $faker->word;
            // Instancy Collection Item Fixtures
            $collection = new Collection();
            $collection->setName(ucwords($name));
            $collection->setSlug($slugify->slugify($name));
            $collection->setPictureUrl($faker->imageUrl(1920, 780, 'cats'));
            $collection->setDateAdd(new \DateTime());

            $manager->persist($collection);
        }

        $manager->flush();
    }
}
