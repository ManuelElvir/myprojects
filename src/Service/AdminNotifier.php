<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

/**
 * This class implements methods to configure notify the admin system.
 * 
 * */
final class AdminNotifier {
    public function __construct(
        private MailerInterface $mailer
        ) {
    }
    
    /**
     * Send a notification email to the admin system.
     * 
     * @var int $user
     * @return void
     */
    public function notifyEmail (string $object, string $message, ) {
        

        $email = (new TemplatedEmail())
            ->from('noreply@png2webp.com')
            ->to('manuel.njiakim@gmail.com')
            ->subject($object)
            ->htmlTemplate('mail/admin_notify_email.html.twig')
            ->context([
                'title' => $object,
                'message' => $message
            ]);
        
        $this->mailer->send($email);
    }
}