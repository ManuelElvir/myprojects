<?php

namespace App\Model;

class File
{
    public $filename;
    public $url;
    public $ownerName;
    public $type;

    /**
     * @var \DateTime|null
     */
    public $createdAt;
}
