<?php

namespace App\DataFixtures;

use App\Entity\Collection;
use App\Entity\Product;
use Cocur\Slugify\Slugify;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public const PRODUCT_REFERENCE = 'product';

    public function load(ObjectManager $manager)
    {
        // Instancy Slugify
        $slugify = new Slugify();
        // Instancy Faker
        $faker = Factory::create('fr_FR');
        // Get all collections
        $repository = $manager->getRepository(Collection::class);
        $collections = $repository->findAll();

        $nameRef = $faker->word;
        $productRef = new Product();
        $productRef->setName(ucwords($nameRef));
        $productRef->setSlug($slugify->slugify($nameRef));
        $productRef->setPictureUrl($faker->imageUrl(710, 960, 'cats'));
        $productRef->setDateAdd(new \DateTime());
        $productRef->setPrice(rand(10, 100));
        $productRef->setSku('PRODUCT-0');
        $productRef->setCollection($collections[rand(0, count($collections) - 1)]);
        $productRef->setStock(rand(10, 100));
        $manager->persist($productRef);

        for ($i = 1; $i < 50; $i++){
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
            $product->setStock(rand(10, 100));

            $manager->persist($product);
        }

        $manager->flush();

        $this->addReference(self::PRODUCT_REFERENCE, $productRef);
    }

    public function getDependencies()
    {
        return array(
            CollectionFixtures::class,
        );
    }
}
