<?php

namespace App\DataFixtures;

use App\Entity\Cart;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CartFixtures extends Fixture implements DependentFixtureInterface
{
    public const USER_CART_REFERENCE = 'user_cart';
    public const ADMIN_CART_REFERENCE = 'admin_cart';

    public function load(ObjectManager $manager)
    {
        $userCart = new Cart();
        $userCart->setUser($this->getReference(UserFixtures::USER_REFERENCE));
        $manager->persist($userCart);

        $adminCart = new Cart();
        $adminCart->setUser($this->getReference(UserFixtures::ADMIN_REFERENCE));
        $manager->persist($adminCart);

        $manager->flush();

        $this->addReference(self::ADMIN_CART_REFERENCE, $adminCart);
        $this->addReference(self::USER_CART_REFERENCE, $userCart);
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
