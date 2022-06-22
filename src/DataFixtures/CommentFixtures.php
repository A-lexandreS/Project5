<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 3; ++$i) {
            $dateTime = $this->faker->dateTime();
            $comment = new Comment();
            $comment->setEvent($this->getReference(EventFixtures::EVENT_REFERENCE))
                ->setUser($this->faker->word())
                ->setComment($this->faker->sentence())
                ->setCommentDate(DateTimeImmutable::createFromMutable($dateTime));
            $manager->persist($comment);
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
