<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public const USER_REFERENCE = 'user';
    public const ADMIN_REFERENCE = 'admin';

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Instancy Admin
        $admin = new User();
        $admin->setEmail('admin@admin.fr');
        $admin->setFirstName('Pierre');
        $admin->setLastName('Grimaud');
        $password = $this->encoder->encodePassword($admin, 'admin');
        $admin->setPassword($password);
        $admin->setRoles([
            'ROLE_ADMIN'
        ]);

        $manager->persist($admin);

        // Instancy User
        $user = new User();
        $user->setEmail('user@user.fr');
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $password = $this->encoder->encodePassword($user, 'user');
        $user->setPassword($password);
        $user->setRoles([
            'ROLE_USER'
        ]);

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::ADMIN_REFERENCE, $admin);
        $this->addReference(self::USER_REFERENCE, $user);
    }
}
