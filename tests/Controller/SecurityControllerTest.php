<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SecurityControllerTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    public $client;

    /**
     * @var UrlGeneratorInterface
     */
    public $urlGenerator;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->urlGenerator = $this->client->getContainer()->get(UrlGeneratorInterface::class);
    }

    public function testShowLoginPage(): void
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('app_login'));
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("button", "Se connecter");
    }

    public function testLoginUser(): void
    {
        $crawler =  $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('app_login'));

        $buttonCrawlerNode = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerNode->form([
            'username' => 'admin98',
            'password' => 'test'
        ]);

        $this->client->submit($form);

        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("h1", "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !");
    }
}
