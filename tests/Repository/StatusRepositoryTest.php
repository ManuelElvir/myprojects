<?php

namespace App\Tests\Repository;

use App\DataFixtures\StatusFixtures;
use App\Repository\StatusRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class StatusRepositoryTest extends KernelTestCase
{
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }
    
    public function testGetStatusCount(): void
    {
        $statusCount = $this->getContainer()->get(StatusRepository::class)->count([]);
        $this->assertGreaterThan(0, $statusCount, 'Incorrect status count');
    }
}
