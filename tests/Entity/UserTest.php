<?php

namespace Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @var User
     */
    public $user;

    public function setUp(): void
    {
        $this->user = new User();
    }

    public function testGetId(): void
    {
        $this->assertEmpty($this->user->getId());
    }

    public function testGetSalt()
    {
        $this->assertSame(null, $this->user->getSalt());
    }

    public function testGetUserIdentifier()
    {
        $this->user->setUsername('test98');
        $this->assertSame('test98', $this->user->getUserIdentifier());
    }

    public function testRemoveTaskUser()
    {
        $task = new Task;

        $this->user->addTask($task);
        $this->assertNotEmpty($this->user->getTasks());

        $this->user->removeTask($task);
        $this->assertNotContains($task, $this->user->getTasks());
    }
}
