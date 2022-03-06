<?php

namespace App\DataFixtures;

use App\Entity\Registration;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RegistrationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $registration = new Registration();
        $registration->setEvent('Event #1')
            ->setFirstName('Alex')
            ->setLastName('Col')
            ->setEmail('alex@outlook.fr')
            ->setQuantity(4);

        $manager->persist($registration);

        $manager->flush();

    }
}