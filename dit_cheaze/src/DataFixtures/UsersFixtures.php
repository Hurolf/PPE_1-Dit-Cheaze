<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new Users();
        $user ->setPseudo('Admin');
        $user->setEmail('admin@admin.fr');
        $user->setPassword($this->passwordEncoder->encodePassword(
                       $user, 'test'
        ));

        $manager->persist($user);

        $manager->flush();
    }
}
