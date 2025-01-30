<?php

namespace App\Entity;

use App\Repository\WardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: WardRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false)]
#[ORM\UniqueConstraint(columns: ['ward_number'])]
class Ward
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $ward_number;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[ORM\OneToMany(targetEntity: WardProcedure::class, mappedBy: 'ward', cascade: ['persist', 'remove'])]
    private Collection $hospitalized;

    #[ORM\OneToMany(targetEntity: WardProcedure::class, mappedBy: 'ward', cascade: ['persist', 'remove'])]
    private Collection $wardProcedures;

    public function __construct()
    {
        $this->hospitalized = new ArrayCollection();
        $this->wardProcedures = new ArrayCollection();
    }

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

    public function gethospitalized(): Collection
    {
        return $this->hospitalized;
    }

    public function getWardProcedures(): Collection
    {
        return $this->wardProcedures;
    }
}
