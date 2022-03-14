<?php

namespace App\DataFixtures;

use App\Entity\Registration;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RegistrationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $registration = new Registration();
        $event = $this->getReference('event');

        $registration->setEvent($event)
            ->setFirstName('Alex 2')
            ->setLastName('Col 2')
            ->setEmail('alex@outlook.fr')
            ->setQuantity(4);

        $manager->persist($registration);
        

        $manager->flush();

    }
    public function getDependencies()
    {
        return [
            EventFixtures::class,
        ];
    }
}