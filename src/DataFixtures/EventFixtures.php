<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Event;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EventFixtures extends Fixture 
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 10; $i++)
        { 
            $now = $this->faker->dateTime();
            $event = new Event();
            $startedAt = $this->faker->dateTimeBetween($now, '+2 days');
            $endedAt = $this->faker->dateTimeBetween($now, '+21 days');
            
            $event->setName($this->faker->word())
                ->setPicture($this->faker->imageUrl(640, 480,'animals', true))
                ->setEventDate(DateTimeImmutable::createFromMutable( $now ))
                ->setStartedAt(DateTimeImmutable::createFromMutable( $startedAt ))
                ->setEndedAt(DateTimeImmutable::createFromMutable( $endedAt ))
                ->setMaxRegistration(50)
                ->setPrice(10)
                ->setDescription($this->faker->text(70));

                $manager->persist($event);
        }
        $this->addReference('event', $event);
        $manager->flush();
    }
}