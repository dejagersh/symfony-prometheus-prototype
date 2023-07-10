<?php

namespace App\EventSubscriber;

use Prometheus\CollectorRegistry;
use ReflectionClass;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;

class MetricsSubscriber implements EventSubscriberInterface
{
    public function __construct(private CollectorRegistry $collectorRegistry)
    {
    }

    public function onMessageSentToTransportEvent(SendMessageToTransportsEvent $event): void
    {
        $this->collectorRegistry->getOrRegisterCounter(
            'app',
            'messages_sent_to_transport',
            'Messages sent to transport',
            ['message']
        )->inc([
            'all',
            (new ReflectionClass($event->getEnvelope()->getMessage()))->getShortName()
        ]);
    }

    public function onMessageHandledEvent(WorkerMessageHandledEvent $event): void
    {
        $this->collectorRegistry->getOrRegisterCounter(
            'app',
            'messages_handled',
            'Messages handled by worker',
            ['message']
        )->inc([
            'all',
            (new ReflectionClass($event->getEnvelope()->getMessage()))->getShortName()
        ]);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SendMessageToTransportsEvent::class => 'onMessageSentToTransportEvent',
            WorkerMessageHandledEvent::class => 'onMessageHandledEvent',
        ];
    }
}
