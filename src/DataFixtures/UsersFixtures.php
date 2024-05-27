<?php

namespace App\DataFixtures;

use App\Entity\Users;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UsersFixtures extends Fixture
{
    /**
     * Permet de hasher le mot de passe
     */
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        private SluggerInterface $slugger
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $createdAt = $createdAt ?? new DateTimeImmutable();

        $admin = new Users();

        $admin->setEmail('audrey.sonkes@gmail.com')
            ->setpassword(
                $this->passwordEncoder->hashPassword($admin, 'admin')
            )
            ->setRoles(['ROLE_ADMIN]']);

        $manager->persist($admin);

        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 10; $i++) {

            $user = new Users();

            $user->setEmail($faker->email)
                ->setPassword(
                    $this->passwordEncoder->hashPassword($user, 'Tiphaine')
                );

            $manager->persist($user);
        }

        $manager->flush();
    }
}
