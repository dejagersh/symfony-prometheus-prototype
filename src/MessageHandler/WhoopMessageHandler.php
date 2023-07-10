<?php

namespace App\MessageHandler;

use App\Message\WhoopMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class WhoopMessageHandler implements MessageHandlerInterface
{
    public function __invoke(WhoopMessage $message)
    {
        // Wait between 100 and 200 ms
        usleep(random_int(100_000, 200_000));
    }
}
