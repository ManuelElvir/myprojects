<?php
namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class TaskWidget
{
    public string $title;
    public string $project;
    public string $status;
    public string $milestone;
    public string $workerAvatar;
    public string $ownerAvatar;
}