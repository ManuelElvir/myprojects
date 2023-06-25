<?php

namespace App\Model;

class Comment
{
    public $content;
    public $authorName;
    public $repliedTo;

    /**
     * @var array<File>
     */
    public $files = [];

    /**
     * @var \DateTime|null
     */
    public $sentAt;
}
