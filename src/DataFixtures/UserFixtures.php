<?php

namespace App\DataFixtures;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $user->setName('john doe');
        $user->setEmail('john.doe@email.com');
        $user->setRoles(['ROLE_USER']);

        $date = date('Y-m-d H:i:s');
        $createdAt = new \DateTimeImmutable($date);
        $user->setCreatedAt($createdAt);

        $password = $this->hasher->hashPassword($user, '1234');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}
