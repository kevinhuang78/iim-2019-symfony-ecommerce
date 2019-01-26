<?php

namespace App\DataFixtures;

use App\Entity\OrderCommand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class OrderCommandFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $orderCommand = new OrderCommand();
        $orderCommand->setCart($this->getReference(CartFixtures::USER_CART_REFERENCE));
        $orderCommand->setUser($this->getReference(UserFixtures::USER_REFERENCE));
        $orderCommand->setCreatedAt(new \DateTime());
        $manager->persist($orderCommand);

        $orderCommand = new OrderCommand();
        $orderCommand->setCart($this->getReference(CartFixtures::ADMIN_CART_REFERENCE));
        $orderCommand->setUser($this->getReference(UserFixtures::ADMIN_REFERENCE));
        $orderCommand->setCreatedAt(new \DateTime());
        $manager->persist($orderCommand);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            CartFixtures::class,
        );
    }
}
