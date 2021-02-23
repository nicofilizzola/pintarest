<?php

namespace App\DataFixtures;

use App\Entity\Pin;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++){
            $user = new User;
            $user->setFirstName('Name' . $i);
            $user->setLastName('Last' . $i);
            $user->setEmail('user' . $i .'@email.com');
            $user->setPassword('test');

            $pin = new Pin;
            $pin->setTitle('Pin ' . $i);
            $pin->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
            $pin->setUser($user);

            $manager->persist($user);
            $manager->persist($pin);
        }

        $manager->flush();
    }
}
