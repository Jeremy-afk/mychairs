<?php

namespace App\DataFixtures;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$email,$plainPassword,$role]) {
            $user = new User();
            $password = $this->hasher->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPassword($password);

            $roles = array();
            $roles[] = $role;
            $user->setRoles($roles);

            $manager->persist($user);
        }
        $manager->flush();
    }
        private function getUserData()
        {
                yield ['aymeric@tryhard', 'tryhard', 'ROLE_USER'];
                yield ['louis@rust', 'rust', 'ROLE_USER'];
                yield ['jeremy@bg', 'tryhard', 'ROLE_ADMIN'];
                
        }
}