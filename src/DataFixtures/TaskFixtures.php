<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
/**
 * @codeCoverageIgnoreCoverage
 */
class TaskFixtures extends Fixture
{
    /**
     * load 6 task in database 
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 5; $i++) {
            $task = new Task;
            $task->setTitle($faker->sentence());
            $task->setContent($faker->text());
            $task->isDone(mt_rand(0, 1));

            $manager->persist($task);
        }
        $testTask = new Task;
        $testTask->setTitle('le tache de test');
        $testTask->setContent('un contenu');
        $testTask->isDone(false);

        $manager->persist($testTask);
        
         $manager->flush();
    }
}
