<?php

namespace App\MessageHandler;

use App\Message\DeleteAccountMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class DeleteAccountMessageHandler implements MessageHandlerInterface
{
    public function __invoke(DeleteAccountMessage $message)
    {
        // Wait between 100 and 200 ms
        usleep(random_int(50_000, 200_000));
    }
}
