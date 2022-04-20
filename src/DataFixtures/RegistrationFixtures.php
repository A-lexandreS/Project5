<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Registration;
use Faker\Factory;


class RegistrationFixtures extends Fixture implements DependentFixtureInterface
{


    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        for($i=0; $i < 10; $i++)
        {
            $booking = new Registration();
            $booking->setEvent($this->getReference(EventFixtures::EVENT_REFERENCE))
                ->setFirstName($this->faker->word())
                ->setLastName($this->faker->word())
                ->setEmail($this->faker->email())
                ->setQuantity($this->faker->randomDigit());
            $manager->persist($booking);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            EventFixtures::class,
        ];
    }
}