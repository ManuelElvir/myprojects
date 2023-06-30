<?php
namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class MilestoneWidget
{
    public string $title;
    public string $project;
    public string $endDate;
    public string $status;
    /** 
     * @var string[] $workersAvatar 
    */
    public array $workersAvatar; 
    public string $ownerAvatar;
}