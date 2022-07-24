<?php

namespace App\Entity;

use App\Exception\NotABuffetException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Enclosure
{
    #[ORM\OneToMany('enclosure', Dinosaur::class, cascade: ['persist'])]
    private Collection $dinosaurs;

    private Collection $securities;

    public function __construct()
    {
        $this->dinosaurs = new ArrayCollection();
    }

    public function getDinosaurs(): Collection
    {
        return $this->dinosaurs;
    }

    /**
     * @throws NotABuffetException
     */
    public function addDinosaur(Dinosaur $dinosaur): Enclosure
    {
        if (!$this->canAddDinosaur($dinosaur)) {
            throw new NotABuffetException();
        }
        $this->dinosaurs[] = $dinosaur;

        return $this;
    }

    private function canAddDinosaur(Dinosaur $dinosaur): bool
    {
        return count($this->dinosaurs) === 0 || $this->dinosaurs->first()->isCarnivorous() === $dinosaur->isCarnivorous(
            );
    }
}