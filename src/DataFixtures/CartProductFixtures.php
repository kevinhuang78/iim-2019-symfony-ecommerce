<?php

namespace App\DataFixtures;

use App\Entity\CartProduct;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CartProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cartProduct = new CartProduct();
        $cartProduct->setCart($this->getReference(CartFixtures::USER_CART_REFERENCE));
        $cartProduct->setProduct($this->getReference(ProductFixtures::PRODUCT_REFERENCE));
        $cartProduct->setQuantity(1);
        $manager->persist($cartProduct);

        $cartProduct = new CartProduct();
        $cartProduct->setCart($this->getReference(CartFixtures::USER_CART_REFERENCE));
        $cartProduct->setProduct($this->getReference(ProductFixtures::PRODUCT_TWO_REFERENCE));
        $cartProduct->setQuantity(1);
        $manager->persist($cartProduct);

        $cartProduct = new CartProduct();
        $cartProduct->setCart($this->getReference(CartFixtures::ADMIN_CART_REFERENCE));
        $cartProduct->setProduct($this->getReference(ProductFixtures::PRODUCT_REFERENCE));
        $cartProduct->setQuantity(1);
        $manager->persist($cartProduct);

        $cartProduct = new CartProduct();
        $cartProduct->setCart($this->getReference(CartFixtures::ADMIN_CART_REFERENCE));
        $cartProduct->setProduct($this->getReference(ProductFixtures::PRODUCT_TWO_REFERENCE));
        $cartProduct->setQuantity(1);
        $manager->persist($cartProduct);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CartFixtures::class,
            ProductFixtures::class,
        );
    }
}
