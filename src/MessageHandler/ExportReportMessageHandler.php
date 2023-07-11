<?php

namespace App\MessageHandler;

use App\Message\ExportReportMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ExportReportMessageHandler implements MessageHandlerInterface
{
    public function __invoke(ExportReportMessage $message)
    {
        usleep(random_int(100_000, 200_000));
    }
}
