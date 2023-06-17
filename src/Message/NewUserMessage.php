<?php

namespace App\Message;

final class NewUserMessage
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */
    
    public function __construct(
        private string $userId,
    ) {
    }

    public function getUserId():?int {
        return $this->userId;
    }
}
