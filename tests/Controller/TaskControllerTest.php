<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\DataFixtures\TaskFixtures;
use App\DataFixtures\UserFixtures;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

use function PHPUnit\Framework\assertEmpty;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class TaskControllerTest extends WebTestCase
{
     /**
     * @var KernelBrowser
     */
    public $client;

    /**
     * @var UrlGeneratorInterface
     */
    public $urlGenerator;

    /**
     * @var UserRepository
     */
    public $userRepository;

    /**
     * @var TaskRepository
     */
    public $taskRepository;

    /**
     * @var EntityManagerInterface
     */
    public $entityManager;

    /**
     * @var DatabaseToolCollection
     */
    protected $databaseTool;

    public function setUp(): void
    {
        $this->client = static::createClient();

        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadAllFixtures();

        $this->urlGenerator = $this->client->getContainer()->get('router.default');
        $this->userRepository = $this->client->getContainer()->get(UserRepository::class);
        $this->taskRepository = $this->client->getContainer()->get(TaskRepository::class);
        $this->entityManager = $this->client->getContainer()->get(EntityManagerInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }

    public function testShowTaskList(): void
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_list'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testShowCreateTaksPage(): void
    {
        $user = $this->userRepository->findOneBy(['username' => 'test98']);
        $this->client->loginUser($user);

        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_create'));
        $this->assertResponseIsSuccessful();
    }

    public function testCreateTask(): void
    {
        $user = $this->userRepository->findOneBy(['username' => 'test98']);
        $this->client->loginUser($user);

        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_create'));

        $formData = [
            'task[title]' => 'nouvelle tache',
            'task[content]' => 'tache de test: creation '
        ];
        $buttonCrawlerNode = $crawler->selectButton('Ajouter');
        $form = $buttonCrawlerNode->form();

        $form->setValues($formData);
        $this->client->submit($form);

        $this->client->followRedirect();
        $this->assertSelectorExists('.alert-success');

        $newTask = $this->taskRepository->findOneBy(['title' => 'nouvelle tache']);

        $this->assertNotEmpty($newTask);
    }

    public function testEditTask(): void
    {
        $user = $this->userRepository->findOneBy(['username' => 'test98']);
        $this->client->loginUser($user);

        $task = $this->taskRepository->findOneBy([]);
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('task_edit', ['id' => $task->getId()]));
        $this->assertResponseIsSuccessful();

        $formData = [
            'task[title]' => 'la tache modifier',
        ];

        $buttonCrawlerNode = $crawler->selectButton('Modifier');
        $form = $buttonCrawlerNode->form();

        $form->setValues($formData);
        $this->client->submit($form);

        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('.alert-success');

        $updatedTask = $this->taskRepository->findOneBy(['title' => 'la tache modifier']);
        $this->assertNotEmpty($updatedTask);
    }

    public function testToggleTask(): void
    {
        $task = $this->taskRepository->findOneBy([]);
        $isDone = $task->isDone();
        $this->client->request('GET', $this->urlGenerator->generate('task_toggle', ['id' => $task->getId()]));

        $newIsDone = !$isDone;
        $this->assertNotSame($isDone, $newIsDone);
    }

    public function testDeleteTaskWithRoleAdmin(): void
    {
        $user = $this->userRepository->findOneBy(['username' => 'admin98']);
        $this->client->loginUser($user);

        $task = $this->taskRepository->findOneBy([]);

        $this->client->request('GET', $this->urlGenerator->generate('task_delete', ['id' => $task->getId()]));

        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('.alert-success');
    }

    public function testUsernotAllowedDeleteTask(): void
    {
        $task = $this->taskRepository->findOneBy([]);
        $task->setAuthor(null);

        $this->entityManager->flush();
        $this->entityManager->refresh($task);

        $user = $this->userRepository->findOneBy(['username' => 'test98']);
        $this->client->loginUser($user);

        $UpdatedTask = $this->taskRepository->findOneBy(['id' => $task->getId()]);
        $this->client->request('GET', $this->urlGenerator->generate('task_delete', ['id' => $UpdatedTask->getId()]));

        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('.alert-danger');
    }
}
