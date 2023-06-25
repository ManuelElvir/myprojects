<?php

namespace App\MessageHandler;

use App\Message\NewUserMessage;
use App\Service\NewUserService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class NewUserMessageHandler
{
    public function __construct(
        private NewUserService $userService
        ) {

    }

    public function __invoke(NewUserMessage $message)
    {
        $userId = $message->getUserId();
        
        $this->userService->generateAvatar($userId);

        $this->userService->sendWelcomeEmail($userId);
    }
}
