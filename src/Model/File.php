<?php

namespace App\Model;

class File
{
    public $filename;
    public $url;
    public $ownerName;

    /**
     * @var \DateTime|null
     */
    public $createdAt;
}
