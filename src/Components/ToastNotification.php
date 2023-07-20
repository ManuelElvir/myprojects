<?php
namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;


#[AsTwigComponent]
class ToastNotification
{
    public string $type;
    public string $title;
    public string $message;
}