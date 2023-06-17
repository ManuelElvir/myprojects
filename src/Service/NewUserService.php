<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

/**
 * This class implements methods to configure user account and send him a welcome email.
 * 
 * */
final class NewUserService {
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MailerInterface $mailer
        ) {
    }

    /**
     * Return the url of the user avatar.
     * 
     * @var int $user
     * @return string
     */
    public function generateAvatar (int $userId ) {
        
        /**
         * @var User $user
         */
        $user = $this->entityManager->getRepository(User::class)->find($userId);
        $avatarUrl = 'https://www.gravatar.com/avatar/'.md5($user->getEmail());
        $user->setAvatarUrl($avatarUrl);
        $this->entityManager->flush();
    }
    
    /**
     * Send a welcome email to the user.
     * 
     * @var int $user
     * @return void
     */
    public function sendWelcomeEmail (int $userId ) {
        
        /**
         * @var User $user
         */
        $user = $this->entityManager->getRepository(User::class)->find($userId);

        $email = (new TemplatedEmail())
            ->from('huhevk6f@mailosaur.net')
            ->to($user->getEmail())
            ->cc('manuel.njiakim@gmail.com')
            ->bcc('njiakimmanue@gmail.com')
            ->subject('Welcome to MyProject, '. $user->getFirstName() .'!')
            ->htmlTemplate('mail/welcome_email.html.twig')
            ->context([
                'user' => $user,
            ]);;
        
        $this->mailer->send($email);
    }
}