<?php

namespace App\Controller;

use App\Message\SendEmailMessage;
use App\Message\WhoopMessage;
use Prometheus\CollectorRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/')]
    public function index(CollectorRegistry $collectionRegistry)
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
        for ($i = 0; $i < 10_000; $i++) {
            $messageBus->dispatch(new SendEmailMessage());
        }

        return new JsonResponse([
            'message' => 'Dispatched!',
        ]);
    }

    #[Route('/dispatch2')]
    public function dispatchTwo(MessageBusInterface $messageBus)
    {
        $messageBus->dispatch(new WhoopMessage());

        return new JsonResponse([
            'message' => 'Dispatched!',
        ]);
    }
}
