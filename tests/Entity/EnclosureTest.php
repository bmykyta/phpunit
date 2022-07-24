<?php

namespace App\Tests\Entity;

use App\Entity\Dinosaur;
use App\Entity\Enclosure;
use App\Exception\NotABuffetException;
use PHPUnit\Framework\TestCase;

class EnclosureTest extends TestCase
{
    public function testItHasNoDinosaursByDefault(): void
    {
        $enclosure = new Enclosure();
        $this->assertEmpty($enclosure->getDinosaurs());
    }

    /**
     * @throws NotABuffetException
     */
    public function testItAddsDinosaurs()
    {
        $enclosure = new Enclosure();
        $enclosure->addDinosaur(new Dinosaur());
        $enclosure->addDinosaur(new Dinosaur());
        $this->assertCount(2, $enclosure->getDinosaurs());
    }

    /**
     * @throws NotABuffetException
     */
    public function testItDoesNotAllowCarnivorousDinosaursToMixWithHerbivores()
    {
        $enclosure = new Enclosure();
        $enclosure->addDinosaur(new Dinosaur());
        $this->expectException(NotABuffetException::class);
        $enclosure->addDinosaur(new Dinosaur('Velociraptor', true));
    }

    /**
     * @throws NotABuffetException
     */
    public function testItDoesNotAllowToAddNonCarnivorousDinosaursToCarnivorousEnclosure()
    {
        $enclosure = new Enclosure();
        $enclosure->addDinosaur(new Dinosaur('Velociraptor', true));
        $this->expectException(NotABuffetException::class);
        $enclosure->addDinosaur(new Dinosaur());
    }
}
