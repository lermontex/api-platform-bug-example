<?php

namespace App\DataFixtures;

use App\Entity\Domain;
use App\Entity\ResetTokenRequest;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $manager->persist($user);

        $domain = new Domain();
        $domain->setUser($user);
        $domain->setApiToken('test');
        $domain->setIsActive(true);
        $manager->persist($domain);

        $resetTokenRequest = new ResetTokenRequest();
        $resetTokenRequest->setDomain($domain);
        $manager->persist($resetTokenRequest);

        $manager->flush();
    }
}
