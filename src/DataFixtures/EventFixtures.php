<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Event;
use DateInterval;
use DateTimeImmutable;


class EventFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {
        $now = new DateTimeImmutable();
        $startedAt = $now->add(new DateInterval("P3D"));
        $endedAt = $now->add(new DateInterval("P21D"));
        $event = new Event();
        $event->setName('Troupe la tulipe')
            ->setpicture('img-1')
            ->setEventDate($now)
            ->setStartedAt($startedAt)
            ->setEndedAt($endedAt)
            ->setMaxRegistration(50)
            ->setPrice(10);

            $manager->persist($event);

            $this->addReference('event', $event);

            $manager->flush();
    }
}