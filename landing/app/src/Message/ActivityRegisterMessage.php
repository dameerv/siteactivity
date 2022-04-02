<?php

namespace App\Message;

use DateTime;

class ActivityRegisterMessage
{
    public function __construct(private string $url, private DateTime $visitedAt)
    {
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return DateTime
     */
    public function getVisitedAt(): DateTime
    {
        return $this->visitedAt;
    }


}