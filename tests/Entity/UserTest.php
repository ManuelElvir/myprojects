<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{

    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }

    public function getEntity(): User
    {
        $user = (new User())
            ->setEmail('test@example.com')
            ->setUsername('testUser');
        $user->setPassword(sha1('Test1234'));
        return $user;
    }

    public function assertHasErrors(User $code, int $number = 0)
    {
        self::bootKernel();
        $errors = self::getContainer()->get('validator')->validate($code);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidEmailEntity()
    {
        $this->assertHasErrors($this->getEntity()->setEmail('blablacar'), 1);
    }

    public function testInvalidBlankUsernameEntity()
    {
        $this->assertHasErrors($this->getEntity()->setUsername(''), 1);
    }

    public function testInvalidBlankPasswordEntity()
    {
        $this->assertHasErrors($this->getEntity()->setPassword(''), 1);
    }
}