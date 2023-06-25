<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

enum USER_ROLES  {
    case ADMIN;
    case USER;
}

class FileControllerTest extends WebTestCase
{
    
    /**
     * insert users and files into the database
     * 
     * @return array $users : list of created users
     */
    private function loadFixtures(): array
    {
        /** @var AbstractDatabaseTool */
        $databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $users = $databaseTool->loadAliceFixture(array(
            __DIR__ . '/users.yml',
        ));
        $databaseTool->loadFixtures(array(
            'App\DataFixtures\FileFixtures'
        ));
        return $users;
    }

    /**
     * return an authenticated client
     * 
     * @param USER_ROLES $user : role of the user for the session
     * @return \Symfony\Bundle\FrameworkBundle\KernelBrowser $client
     */
    private function getAuthenticatedClient(USER_ROLES $role): \Symfony\Bundle\FrameworkBundle\KernelBrowser
    {
        $client = static::createClient();
        $users = $this->loadFixtures();
        /** @var User user */
        $user = $users[$role===USER_ROLES::ADMIN?'user_admin':'user_user'];

        $container = $client->getContainer();
        $sessionSavePath = $container->getParameter('session.save_path');
        $sessionStorage = new MockFileSessionStorage($sessionSavePath);

        $session = new Session($sessionStorage);
        $session->start();
        
        $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
        $session->set('_security_main', serialize($token));

        $session->save();

        $sessionCookie = new Cookie(
            $session->getName(),
            $session->getId(),
        );
        $client->getCookieJar()->set($sessionCookie);

        return $client;
    }

    public function testFileIndexPage(): void
    {
        $client = $this->getAuthenticatedClient(USER_ROLES::ADMIN);

        $crawler = $client->request('GET', '/admin/files');

        $this->assertResponseRedirects();
    }
}
