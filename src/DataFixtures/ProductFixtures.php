<?php

namespace App\DataFixtures;

use App\Entity\Collection;
use App\Entity\Product;
use Cocur\Slugify\Slugify;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Instancy Slugify
        $slugify = new Slugify();
        // Instancy Faker
        $faker = Factory::create('fr_FR');
        // Get all collections
        $repository = $manager->getRepository(Collection::class);
        $collections = $repository->findAll();

        for ($i = 0; $i < 50; $i++){
            // Tmp var to get same name
            $name = $faker->word;
            // Instancy Collection Item Fixtures
            $product = new Product();
            $product->setName(ucwords($name));
            $product->setSlug($slugify->slugify($name));
            $product->setPictureUrl($faker->imageUrl(710, 960, 'cats'));
            $product->setDateAdd(new \DateTime());
            $product->setPrice(rand(10, 100));
            $product->setSku('PRODUCT-' . $i);
            $product->setCollection($collections[rand(0, count($collections) - 1)]);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
