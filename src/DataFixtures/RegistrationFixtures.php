<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Registration;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RegistrationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $event = new Event();
        $registration = new Registration();
        $registration->setEvent($event)
            ->setFirstName('Alex')
            ->setLastName('Col')
            ->setEmail('alex@outlook.fr')
            ->setQuantity(4);

        $manager->persist($registration);

        $manager->flush();

    }
}