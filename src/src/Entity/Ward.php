<?php

namespace App\Entity;

use App\Repository\WardRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WardRepository::class)]
#[ORM\UniqueConstraint(columns: ['ward_number'])]
class Ward
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $ward_number;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWardNumber(): int
    {
        return $this->ward_number;
    }

    public function setWardNumber(int $ward_number): static
    {
        $this->ward_number = $ward_number;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
