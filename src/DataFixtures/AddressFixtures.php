<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AddressFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $address = new Address();
        $address->setUser($this->getReference(UserFixtures::USER_REFERENCE));
        $address->setStreet("10 rue de Test");
        $address->setZipcode("75012");
        $address->setCity("Paris");
        $address->setCountry("France");
        $manager->persist($address);

        $address = new Address();
        $address->setUser($this->getReference(UserFixtures::ADMIN_REFERENCE));
        $address->setStreet("15 avenue de Fixtures");
        $address->setZipcode("69001");
        $address->setCity("Lyon");
        $address->setCountry("France");
        $manager->persist($address);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
