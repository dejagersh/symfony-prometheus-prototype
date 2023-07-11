<?php

namespace App\Controller;

use App\Message\ExportReportMessage;
use App\Message\SendEmailMessage;
use App\Message\DeleteAccountMessage;
use Prometheus\CollectorRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/')]
    public function index(CollectorRegistry $collectionRegistry, Request $request)
    {
        $collectionRegistry->getOrRegisterCounter(
            'app',
            'hello_world',
            'Hello world counter',
            ['action']
        )->inc(['all']);

        return new JsonResponse([
            'message' => 'Hello world!',
        ]);
    }

    #[Route('/dispatch')]
    public function dispatch(MessageBusInterface $messageBus)
    {
        for ($i = 0; $i < 1_000; $i++) {
            $k = random_int(0, 2);

            switch ($k) {
                case 0:
                    $messageBus->dispatch(new SendEmailMessage());
                    break;
                case 1:
                    $messageBus->dispatch(new DeleteAccountMessage());
                    break;
                case 2:
                    $messageBus->dispatch(new ExportReportMessage());
                    break;
            }
        }

        return new JsonResponse([
            'message' => 'Dispatched!',
        ]);
    }

    #[Route('/dispatch2')]
    public function dispatchTwo(MessageBusInterface $messageBus)
    {
        $messageBus->dispatch(new DeleteAccountMessage());

        return new JsonResponse([
            'message' => 'Dispatched!',
        ]);
    }
}
