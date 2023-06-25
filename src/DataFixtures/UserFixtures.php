<?php

namespace App\DataFixtures;

use App\Entity\Status;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $userAdmin = (new User())
        ->setEmail('admin@example.com')
        ->setUsername('admin')
        ->setPassword('$2y$13$7hpZ/AoL9//25UBo3nUdEeb.7bz4NIIvM0y3ZnI5yYKt6FKbg3AHW')
        ->setRoles(['ROLE_ADMIN', 'ROLE_USER'])
        ->setIsVerified(true)
        ->setCreatedAt(new \DateTime('now'))
        ->setUpdatedAt(new \DateTime('now'));

        $manager->persist($userAdmin);

        $user = (new User())
        ->setEmail('manuel.njiakim@gmail.com')
        ->setUsername('manuel.njiakim')
        ->setPassword('$2y$13$7hpZ/AoL9//25UBo3nUdEeb.7bz4NIIvM0y3ZnI5yYKt6FKbg3AHW')
        ->setRoles(['ROLE_USER'])
        ->setIsVerified(false)
        ->setCreatedAt(new \DateTime('now'))
        ->setUpdatedAt(new \DateTime('now'));

        $manager->persist($user);
        
        $manager->flush();
    }
}
