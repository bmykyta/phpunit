<?php

namespace App\Tests\Factory;

use App\Entity\Dinosaur;
use App\Factory\DinosaurFactory;
use PHPUnit\Framework\TestCase;

class DinosaurFactoryTest extends TestCase
{
    public function testItGrowsAVelociraptor(): void
    {
        $factory = new DinosaurFactory();
        $dinosaur = $factory->growVelociraptor(5);

        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        $this->assertIsString($dinosaur->getGenus());
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertSame(5, $dinosaur->getLength());
    }
}
