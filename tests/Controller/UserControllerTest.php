<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserControllerTest extends WebTestCase
{
    public $client;
    public $urlGenerator;
    public $userRepository;
    protected $adminUser;
    public $entityManager;
    protected $databaseTool;

    public function setUp(): void
    {
        
        $this->client = static::createClient();
        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadAllFixtures();
        $this->urlGenerator = self::getContainer()->get(UrlGeneratorInterface::class);
        $this->userRepository = self::getContainer()->get(UserRepository::class);
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
        $this->adminUser = $this->userRepository->findOneBy(['username' => 'admin98']);
        $this->client->loginUser($this->adminUser); 
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }


    public function testShowAllUsers(): void
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_list'));
        $this->assertResponseIsSuccessful();
    }

    public function testCreateUser(): void
    {

        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_create'));
        $this->assertResponseIsSuccessful();

        $formData = [
            'user[username]' => 'newCreated55',
            'user[email]' => 'newUser@gmail.com',
            'user[password][first]' => 'test',
            'user[password][second]' => 'test'
        ];
        $buttonCrawlerNode = $crawler->selectButton('Ajouter');
        $form = $buttonCrawlerNode->form();

        $form->setValues($formData);
        $this->client->submit($form);

        $this->client->followRedirect();
        $this->assertSelectorExists('.alert-success');

        $user = $this->userRepository->findOneBy(['username' => 'newCreated55']);
        $this->assertNotEmpty($user);
    }

    public function testEditUser(): void
    {
        $user = $this->userRepository->findOneBy([]);
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('user_edit', ['id' => $user->getId()]));
        $this->assertResponseIsSuccessful();

        $formData = [
            'user[username]' => $user->getUsername(),
            'user[email]' => $user->getEmail(),
            'user[password][first]' => 'test',
            'user[password][second]' => 'test'
        ];

        $buttonCrawlerNode = $crawler->selectButton('Modifier');
        $form = $buttonCrawlerNode->form();

        $form->setValues($formData);
        $this->client->submit($form);

        $this->client->followRedirect();
        $this->assertSelectorExists('.alert-success');
    }
}
