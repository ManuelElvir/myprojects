<?php
namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;


#[AsTwigComponent]
class AlertNotification
{
    public string $type;
    public string $message;
}