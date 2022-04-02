<?php

namespace App\Entity;


use DateTimeImmutable;

class Activity
{
    public const ACTIVITY_LAST_VISIT_FORMAT = 'd-m-Y H:i:s.u';
    private $id;

    private string $url;

    private int $numberOfVisits;

    private DateTimeImmutable $lastVisit;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getNumberOfVisits(): ?int
    {
        return $this->numberOfVisits;
    }

    public function setNumberOfVisits(int $numberOfVisits): self
    {
        $this->numberOfVisits = $numberOfVisits;

        return $this;
    }

    public function getLastVisit(): ?DateTimeImmutable
    {
        return $this->lastVisit;
    }

    public function setLastVisit(DateTimeImmutable $lastVisit): self
    {
        $this->lastVisit = $lastVisit;

        return $this;
    }

    public function getLastVisitFormat(): string
    {
        return $this->lastVisit->format(self::ACTIVITY_LAST_VISIT_FORMAT);
    }
}
