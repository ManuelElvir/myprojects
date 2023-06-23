<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture implements FixtureInterface
{
    const STATUS = [
        'not_started' => [
            'name' => 'Not Started',
            'value' => 'not_started',
            'color' => '#A0A4A6',
        ],
        'in_progress' => [
            'name' => 'In Progress',
            'value' => 'in_progress',
            'color' => '#00A5FF',
        ],
        'completed' => [
            'name' => 'Completed',
            'value' => 'completed',
            'color' => '#34FF33',
        ],
        'blocked' => [
            'name' => 'Blocked',
            'value' => 'blocked',
            'color' => '#FF3530',
        ],
        'waiting' => [
            'name' => 'Waiting',
            'value' => 'waiting',
            'color' => '#FFA500',
        ],
    ];

    public function load(ObjectManager $manager): void
    {

        foreach (self::STATUS as $data) {
            $status = new Status();
            $status->setName($data['name']);
            $status->setValue($data['value']);
            $status->setColor($data['color']);
            $manager->persist($status);
        }
        
        $manager->flush();
    }
}
