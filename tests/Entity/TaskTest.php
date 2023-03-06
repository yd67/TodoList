<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    /**
     * @var Task
     */
    public $task;

    public function setUp(): void
    {
        $this->task = new Task();
    }

    public function testTaskGetSetCreatedAt(): void
    {
        $date = new \DateTime;
        $this->task->setCreatedAt($date);
        $this->assertSame($date, $this->task->getCreatedAt());
    }

    public function testTaskGetSetIsDone(): void
    {
        $this->task->setIsDone(true);
        $this->assertSame(true, $this->task->getIsDone());
    }
}
