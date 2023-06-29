<?php
namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class ActivityWidget
{
    public string $date;
    public string $title;
    public string $link;
}