<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private ?string $url;

    #[ORM\Column(type: 'datetime_immutable_micro', nullable: false)]
    private DateTimeImmutable $visitedAt;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getVisitedAt(): DateTimeImmutable
    {
        return $this->visitedAt;
    }

    public function setVisitedAt(DateTimeImmutable $visitedAt): self
    {
        $this->visitedAt = $visitedAt;

        return $this;
    }
}
