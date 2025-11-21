<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            ['firstName' => 'admin',     'lastName' => 'admin',      'login' => 'admin',       'password' => 'test123'],
            ['firstName' => 'Mariusz',   'lastName' => 'Nowak',      'login' => 'm.nowak',     'password' => 'test123'],
            ['firstName' => 'Zdzisław',  'lastName' => 'Kowalski',   'login' => 'z.kowalski',  'password' => 'test123'],
            ['firstName' => 'Karolina',  'lastName' => 'Źdźbło',     'login' => 'k.zdzblo',    'password' => 'test123'],
            ['firstName' => 'Michał',    'lastName' => 'Wabik',      'login' => 'm.wabik',     'password' => 'test123'],
        ];

        $i = 1;
        foreach ($usersData as $data) {
            $user = new User();
            $user->setFirstName($data['firstName']);
            $user->setLastName($data['lastName']);
            $user->setLogin($data['login']);

            $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
            $user->setPassword($hashedPassword);
            $this->addReference('user_' . $i, $user);
            $i++;

            $manager->persist($user);
        }

        $manager->flush();
    }
}
