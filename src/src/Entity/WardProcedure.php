<?php

namespace App\Entity;

use App\Repository\WardProcedureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WardProcedureRepository::class)]
#[ORM\Table(name: 'wards_procedures')]
#[ORM\UniqueConstraint(name: 'unique_ward_procedure', columns: ['ward_id', 'procedure_id'])]
class WardProcedure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Ward::class, inversedBy: 'wardProcedures')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Ward $ward;

    #[ORM\ManyToOne(targetEntity: Procedure::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Procedure $procedure;

    #[ORM\Column(type: 'integer')]
    private int $sequence;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSequence(): ?int
    {
        return $this->sequence;
    }

    public function setSequence(int $sequence): static
    {
        $this->sequence = $sequence;

        return $this;
    }
}

