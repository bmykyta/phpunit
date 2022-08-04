<?php

namespace App\Entity;

use App\Exception\DinosaursAreRunningRampantException;
use App\Exception\NotABuffetException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Enclosure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'enclosure', targetEntity: Dinosaur::class, cascade: ['persist'])]
    private Collection $dinosaurs;

    #[ORM\OneToMany(mappedBy: 'enclosure', targetEntity: Security::class, cascade: ['persist'])]
    private Collection $securities;

    public function __construct(bool $withBasicSecurity = false)
    {
        $this->dinosaurs  = new ArrayCollection();
        $this->securities = new ArrayCollection();

        if ($withBasicSecurity) {
            $this->addSecurities(new Security('Fence', true, $this));
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Enclosure
    {
        $this->id = $id;

        return $this;
    }

    public function getDinosaurs(): Collection
    {
        return $this->dinosaurs;
    }

    public function getDinosaurCount(): int
    {
        return $this->dinosaurs->count();
    }

    /**
     * @throws NotABuffetException|DinosaursAreRunningRampantException
     */
    public function addDinosaur(Dinosaur $dinosaur): Enclosure
    {
        if (!$this->canAddDinosaur($dinosaur)) {
            throw new NotABuffetException();
        }
        if (!$this->isSecurityActive()) {
            throw new DinosaursAreRunningRampantException('Are you craaazy?!?');
        }
        $this->dinosaurs[] = $dinosaur;

        return $this;
    }

    /**
     * @return Collection<int, Security>
     */
    public function getSecurities(): Collection
    {
        return $this->securities;
    }

    public function addSecurities(Security $security): self
    {
        if (!$this->securities->contains($security)) {
            $this->securities[] = $security;
            $security->setEnclosure($this);
        }

        return $this;
    }

    public function removeSecurities(Security $security): self
    {
        if ($this->securities->removeElement($security)) {
            // set the owning side to null (unless already changed)
            if ($security->getEnclosure() === $this) {
                $security->setEnclosure(null);
            }
        }

        return $this;
    }

    public function isSecurityActive(): bool
    {
        foreach ($this->securities as $security) {
            if ($security->isActive()) {
                return true;
            }
        }

        return false;
    }

    private function canAddDinosaur(Dinosaur $dinosaur): bool
    {
        return count($this->dinosaurs) === 0 || $this->dinosaurs->first()->isCarnivorous() === $dinosaur->isCarnivorous(
            );
    }
}