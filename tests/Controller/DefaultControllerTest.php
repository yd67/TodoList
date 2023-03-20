<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    public $client;

    /**
     * @var UserRepository
     */
    public $userRepository;

    /**
     * @var DatabaseToolCollection
     */
    protected $databaseTool;

    /**
     * @var User
     */
    public $user;


    /**
     * @var UrlGeneratorInterface
     */
    public $urlGenerator;

    public function setUp(): void
    {
        $this->client = static::createClient();
        
        // generate test data fixtures 
        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadAllFixtures();

        $this->urlGenerator = $this->client->getContainer()->get(UrlGeneratorInterface::class);
        $this->userRepository = $this->client->getContainer()->get(UserRepository::class);
        $this->user = $this->userRepository->findOneBy(['username' => 'admin98']);
        $this->client->loginUser($this->user);
    }

    /**
     * test home page
     * @return void
     */
    public function testShowHomePage(): void
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('homepage'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains("h1", "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !");
    }
}
