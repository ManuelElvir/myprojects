<?php

namespace App\Tests\Repository;

use App\Repository\FileTypeRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class FileTypeRepositoryTest extends KernelTestCase
{
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }
    
    public function testGetFileTypeCount(): void
    {
        $this->databaseTool->loadFixtures(array(
            'App\DataFixtures\FileFixtures'
        ));
        $fileTypeCount = $this->getContainer()->get(FileTypeRepository::class)->count([]);
        $this->assertGreaterThan(0, $fileTypeCount, 'Incorrect status count');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}
