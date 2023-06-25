<?php

namespace App\DataFixtures;

use App\Entity\File;
use App\Entity\FileType;
use App\Entity\User;
use App\Repository\UserRepository;
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
        /**
         * @var User|null $user
         */
        $user = $manager->getRepository(User::class)->findOneBy(
            ['id' => '> 0'],
            ['createdAt' => 'DESC']
        );
        
        foreach (self::FILETYPES as $data) {
            $fileType = (new FileType())
            ->setName($data['name'])
            ->setValue($data['value']);

            $manager->persist($fileType);

            // add files 
            

            for ($i=0; $i <100 ; $i++) { 
                $file = (new File())
                ->setFileName("Nom de fichier $i")
                ->setFileSize(random_int(56000, 40000000))
                ->setUrl('http://localhost/assets/'.$fileType->getName().'file'.$i.'.'.$fileType->getValue())
                ->setFileType($fileType)
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());
                if($user) {
                    $file->setOwner($user);
                }

                $manager->persist($file);
            }
        }
        
        $manager->flush();
    }
}
