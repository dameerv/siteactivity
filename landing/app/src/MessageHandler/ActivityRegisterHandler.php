<?php

namespace App\MessageHandler;

use App\Entity\Activity;
use App\Message\ActivityRegisterMessage;
use App\Service\ActivityHttpClient;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ActivityRegisterHandler implements MessageHandlerInterface
{

    public function __construct(private ActivityHttpClient $client)
    {
    }

    /**
     * @param ActivityRegisterMessage $message
     * @return void
     */
    public function __invoke(ActivityRegisterMessage $message)
    {
        $response = $this->client->send('register-activity', [
            'url' => $message->getUrl(),
            'visitedAt' => $message->getVisitedAt()->format(Activity::ACTIVITY_LAST_VISIT_FORMAT)
        ]);
    }
}
