<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class LoginControllerTest extends WebTestCase
{

    private function loadFixtures(): void
    {
        /** @var AbstractDatabaseTool */
        $databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $databaseTool->loadAliceFixture(array(
            __DIR__ . '/users.yml',
        ));
    }

    public function testLoginPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Sign in to My Projects');
        $this->assertSelectorTextContains('label[for="username"]', 'Email address');
        $this->assertSelectorTextContains('label[for="password"]', 'Password');
        $this->assertSelectorNotExists('div[role="alert"]');
    }

    public function testLoginRequireCsrf(): void
    {
        $client = static::createClient();
        // $crawler = $client->request('GET', '/login');
        // $form = $crawler->selectButton('Sign in')->form([
        //     '_username'=>'test@test.com',
        //     '_password'=>'password',
        //     '_csrf_token'=>'token',
        // ], method: 'POST');
        // $client->submit($form);
        // $this->assertResponseRedirects();
        
        $client->request('POST', '/login', [
            '_username'=>'test@test.com',
            '_password'=>'password',
            '_csrf_token'=>'token',
        ]);
        $client->followRedirect();
        $this->assertSelectorTextContains('h2', 'Sign');
        $this->assertSelectorTextContains('div[role="alert"]', 'Invalid CSRF token.');
    }

    public function testSuccessfulLogin(): void
    {
        $client = static::createClient();
        $this->loadFixtures();

        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Sign in')->form([
            '_username'=>'admin@example.com',
            '_password'=>'12345678',
        ], method: 'POST');
        $client->submit($form);

        // withou loading login page
        // $csrf = $client->getContainer()->get('security.csrf.token_manager')->getToken('authenticate');
        // $client->request('POST', '/login', [
        //     '_username'=>'admin@example.com',
        //     '_password'=>'12345678',
        //     '_csrf_token'=>$csrf,
        // ]);
        
        $this->assertResponseRedirects('http://localhost/', expectedCode: 302);
    }
}
