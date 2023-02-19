<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {

            $task = new Task;
            $task->setTitle($faker->sentence());
            $task->setContent($faker->text());
            $task->isDone(mt_rand(0, 1));

            $manager->persist($task);
            $manager->flush();
        }
    }
}
