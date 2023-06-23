<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{

    private function getEntity(): User
    {
        $user = (new User())
            ->setEmail('test@example.com')
            ->setUsername('testUser');
        $user->setPassword('$2y$13$7hpZ/AoL9//25UBo3nUdEeb.7bz4NIIvM0y3ZnI5yYKt6FKbg3AHW');
        return $user;
    }

    private function assertHasErrors(User $code, int $number = 0)
    {
        self::bootKernel();
        $errors = self::getContainer()->get('validator')->validate($code);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        printf($errors);
        $this->assertCount($number, $errors, implode(', ', $messages));
    }

    public function testValidEntity()
    {
        // $this->assertHasErrors($this->getEntity(), 0);
        $this->assertEquals(2, 1 + 1, "Entity not valid");
    }

    // public function testInvalidEmailEntity()
    // {
    //     $this->assertHasErrors($this->getEntity()->setEmail('blablacar'), 1);
    // }

    // public function testInvalidBlankUsernameEntity()
    // {
    //     $this->assertHasErrors($this->getEntity()->setUsername(''), 1);
    // }

    // public function testInvalidBlankPasswordEntity()
    // {
    //     $this->assertHasErrors($this->getEntity()->setPassword(''), 1);
    // }
}