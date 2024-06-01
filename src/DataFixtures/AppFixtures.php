<?php

// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        // create a super admin user
        $user = new User();
        $user->setEmail('negarshahbazi.official@gmail.com');
        $user->setFirstName('negar');
        $user->setLastName('shahbazi');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setTel('0601762669');
        $user->setAddress('44 rue charles de gaulle, 42000 saint etienne');
      
        

        // hash the password (e.g. using bcrypt)
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            '123456' // SAISIRE TON PASSWORD
        );
        $user->setPassword($hashedPassword);

        $manager->persist($user);
        $manager->flush();
    }
}
