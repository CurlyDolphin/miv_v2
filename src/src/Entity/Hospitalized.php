<?php

namespace App\Entity;

use App\Repository\HospitalizedRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: HospitalizedRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false)]
class Hospitalized
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'hospitalized')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Patient $patient;

    #[ORM\ManyToOne(targetEntity: Ward::class, inversedBy: 'hospitalized')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Ward $ward;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): Patient
    {
        return $this->patient;
    }

    public function setPatient(Patient $patient): static
    {
        $this->patient = $patient;
        return $this;
    }

    public function getWard(): Ward
    {
        return $this->ward;
    }

    public function setWard(Ward $ward): static
    {
        $this->ward = $ward;
        return $this;
    }
}
