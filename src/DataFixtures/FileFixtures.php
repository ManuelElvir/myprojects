<?php

namespace App\DataFixtures;

use App\Entity\File;
use App\Entity\FileType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FileFixtures extends Fixture
{
    const FILETYPES = [
        'image/jpeg' => [
            'name' => 'image/jpeg',
            'value' => 'jpeg',
        ],
        'image/png' => [
            'name' => 'image/png',
            'value' => 'png',
        ],
        'image/gif' => [
            'name' => 'image/gif',
            'value' => 'gif',
        ],
        'image/svg' => [
            'name' => 'image/svg',
            'value' =>'svg',
        ],
        'document/pdf' => [
            'name' => 'document/pdf',
            'value' => 'pdf',
        ],
        'document/msword2007' => [
            'name' => 'document/word 2007',
            'value' => 'doc',
        ],
        'document/msword' => [
            'name' => 'document/word',
            'value' => 'docx',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        
        foreach (self::FILETYPES as $data) {
            $fileType = new FileType();
            $fileType->setName($data['name']);
            $fileType->setValue($data['value']);
            $manager->persist($fileType);

            // add files 
            

            for ($i=0; $i <100 ; $i++) { 
                $file = new File();
                $file->setFileName("Nom de fichier $i");
                $file->setFileSize(random_int(56000, 40000000));
                $file->setUrl('http://localhost/assets/'.$fileType->getName().'file'.$i.'.'.$fileType->getValue());
                $file->setFileType($fileType);
            }
        }
        
        $manager->flush();
    }
}
