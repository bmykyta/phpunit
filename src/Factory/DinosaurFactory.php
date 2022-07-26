<?php

namespace App\Factory;

use App\Entity\Dinosaur;
use App\Service\DinosaurLengthDeterminator;
use Exception;

class DinosaurFactory
{
    public function __construct(private readonly DinosaurLengthDeterminator $lengthDeterminator)
    {
    }

    public function growVelociraptor(int $length): Dinosaur
    {
        return $this->createDinosaur('Velociraptor', true, $length);
    }

    /**
     * @throws Exception
     */
    public function growFromSpecification(string $specification): Dinosaur
    {
        // defaults
        $codeName      = 'InG-' . random_int(1, 99999);
        $length        = $this->lengthDeterminator->getLengthFromSpecification($specification);
        $isCarnivorous = false;

        if (str_contains($specification, 'carnivorous')) {
            $isCarnivorous = true;
        }

        return $this->createDinosaur($codeName, $isCarnivorous, $length);
    }

    private function createDinosaur($genus, $isCarnivorous, $length): Dinosaur
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);
        $dinosaur->setLength($length);

        return $dinosaur;
    }
}