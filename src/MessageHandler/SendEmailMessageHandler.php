<?php

namespace App\MessageHandler;

use App\Message\SendEmailMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SendEmailMessageHandler implements MessageHandlerInterface
{
    public function __invoke(SendEmailMessage $message)
    {
        // Wait between 100 and 200 ms
        usleep(random_int(300_000, 500_000));
    }
}
