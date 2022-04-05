<?php

namespace App\EventSubscriber;

use DateTime;
use JetBrains\PhpStorm\ArrayShape;
use App\Message\ActivityRegisterMessage;
use Symfony\Component\HttpFoundation\ServerBag;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserActivitySubscriber implements EventSubscriberInterface
{
    public function __construct(private MessageBusInterface $messageBus, private array $notRegisteredUrls)
    {
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();

        try {
            if ($response->getStatusCode() === 200 && $this->isUrlNotExcluded($event->getRequest()->server)) {
                $serviceBag = $event->getRequest()->server;
                $date = new DateTime('now');
                $message = new ActivityRegisterMessage($this->retrieveUrl($serviceBag), $date);
                $this->messageBus->dispatch($message);
            }
        } catch (\Throwable $exception) {
            //todo: обработка исключения и отправка ответа.
        }
    }

    #[ArrayShape(['kernel.response' => "string"])]
    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.response' => 'onKernelResponse',
        ];
    }

    /**
     * @param ServerBag $server
     * @return bool|void
     */
    private function isUrlNotExcluded(ServerBag $server)
    {
        foreach ($this->notRegisteredUrls as $url) {
            if (preg_match("|^{$url}|", $server->get('REQUEST_URI'))) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param ServerBag $server
     * @return string
     */
    private function retrieveUrl(ServerBag $server): string
    {
        $protocol = ($server->get('HTTPS') === 'on') ? 'https' : 'http';
        return $protocol . '://' . $server->get('HTTP_HOST') . $server->get('REQUEST_URI');
    }
}
