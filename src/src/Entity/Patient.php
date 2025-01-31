<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Enum\GenderEnum;
use App\Repository\PatientRepository;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false)]
class Patient
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 80)]
    #[Assert\Length(min: 1, max: 80)]
    private string $name;

    #[ORM\Column(type: "string", length: 80)]
    #[Assert\Length(min: 1, max: 80)]
    private string $lastName;

    #[ORM\Column(type: "string", length: 6, enumType: GenderEnum::class)]
    private GenderEnum $gender;

    #[ORM\Column(type: "boolean")]
    private bool $isIdentified;

    #[ORM\Column(type: "integer", unique: true)]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\SequenceGenerator(sequenceName: "card_number_seq", allocationSize: 1)]
    private ?int $cardNumber = null;

    #[ORM\OneToMany(targetEntity: Hospitalized::class, mappedBy: 'patient', cascade: ['persist', 'remove'])]
    #[Groups(['patient:read'])]
    private Collection $hospitalized;

    public function __construct()
    {
        $this->hospitalized = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getGender(): GenderEnum
    {
        return $this->gender;
    }

    public function setGender(GenderEnum $gender): void
    {
        $this->gender = $gender;
    }

    public function isIdentified(): bool
    {
        return $this->isIdentified;
    }

    public function setIdentified(bool $isIdentified): void
    {
        $this->isIdentified = $isIdentified;
    }

    public function getCardNumber(): int
    {
        return $this->cardNumber;
    }

    public function setCardNumber(int $cardNumber): void
    {
        $this->cardNumber = $cardNumber;
    }

    public function gethospitalized(): Collection
    {
        return $this->hospitalized;
    }
}
