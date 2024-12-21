<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeveloperRepository::class)
 * @ORM\Table(name="tasks")
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private int $id;

    /** @ORM\Column(type="integer") */
    private int $value;

    /** @ORM\Column(type="integer") */
    private int $estimatedDuration;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    public function getEstimatedDuration(): int
    {
        return $this->estimatedDuration;
    }

    public function setEstimatedDuration(int $estimatedDuration): void
    {
        $this->estimatedDuration = $estimatedDuration;
    }
}
