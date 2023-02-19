<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->passwordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $user = new User;
            $user->setUsername($faker->userName());
            $user->setEmail($faker->email());
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    'test'
                )
            );
            $manager->persist($user);
            $manager->flush();
        }
    }
}
