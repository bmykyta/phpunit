<?php

namespace App\Entity;

use App\Repository\DinosaurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DinosaurRepository::class)]
class Dinosaur
{
    const LARGE = 10;

    const HUGE  = 30;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    private int $length = 0;

    #[ORM\Column]
    private string $genus = 'Unknown';

    #[ORM\Column]
    private bool $isCarnivorous = false;

    #[ORM\ManyToOne(targetEntity: Enclosure::class, inversedBy: 'dinosaurs')]
    private Enclosure $enclosure;

    public function __construct(string $genus = 'Unknown', bool $isCarnivorous = false)
    {
        $this->genus         = $genus;
        $this->isCarnivorous = $isCarnivorous;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getSpecification(): string
    {
        return sprintf(
            "The %s %scarnivorous dinosaur is %d meter long",
            $this->genus,
            $this->isCarnivorous ? '' : 'non-',
            $this->length
        );
    }

    public function getGenus(): string
    {
        return $this->genus;
    }

    public function setGenus(string $genus): Dinosaur
    {
        $this->genus = $genus;

        return $this;
    }

    public function isCarnivorous(): bool
    {
        return $this->isCarnivorous;
    }

    public function setIsCarnivorous(bool $isCarnivorous): Dinosaur
    {
        $this->isCarnivorous = $isCarnivorous;

        return $this;
    }

    public function getEnclosure(): Enclosure
    {
        return $this->enclosure;
    }

    public function setEnclosure(Enclosure $enclosure): Dinosaur
    {
        $this->enclosure = $enclosure;

        return $this;
    }
}
