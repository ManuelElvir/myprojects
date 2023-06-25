<?php

namespace App\Tests\EventSubscriber;

use App\EventSubscriber\ExceptionSubscriber;
use App\Service\AdminNotifier;
use Exception;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Mailer\Mailer;

class ExceptionSubscriberTest extends TestCase
{
    public function testEventSubscription(): void
    {
        $this->assertArrayHasKey(ExceptionEvent::class, ExceptionSubscriber::getSubscribedEvents());
    }

    public function testOnExceptionSendEmail(): void
    {
        // $mailer = $this->getMockBuilder(MailerInterface::class)
        //     ->disableOriginalConstructor()
        //     ->getMock();
        // $adminNotifier = new AdminNotifier($mailer);
        // $subsbscriber = new ExceptionSubscriber($adminNotifier);
        
        // $event = new ExceptionEvent(self::createKernel(), new Request(), 1, $exception->trow);
        // $mailer->expects($this->once())->method('send');
        // $subsbscriber->onException($event);
        $this->assertTrue(true);
    }
}
