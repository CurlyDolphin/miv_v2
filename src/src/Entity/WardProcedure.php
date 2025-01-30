<?php

namespace App\Entity;

use App\Repository\WardProcedureRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: WardProcedureRepository::class)]
#[ORM\Table(name: 'wards_procedures')]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false)]
#[ORM\UniqueConstraint(name: 'unique_ward_procedure', columns: ['ward_id', 'procedure_id'])]
#[ORM\UniqueConstraint(name: 'unique_sequence_in_ward', columns: ['ward_id', 'sequence'])]
class WardProcedure
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

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

