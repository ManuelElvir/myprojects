<?php

namespace App\EventSubscriber;

use App\Service\AdminNotifier;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Mailer\Mailer;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(private AdminNotifier $adminNotifier) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ExceptionEvent::class => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        $this->adminNotifier->notifyEmail('New Error '. $event->getThrowable()->getCode(), $event->getThrowable()->getMessage());
    }
}
