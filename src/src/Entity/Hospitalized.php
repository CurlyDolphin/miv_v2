<?php

namespace App\Entity;

use App\Repository\HospitalizedRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: HospitalizedRepository::class)]
class Hospitalized
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Patient::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Patient $patient;

    #[ORM\ManyToOne(targetEntity: Ward::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Ward $ward;

    public function getId(): ?int
    {
        return $this->id;
    }

}
