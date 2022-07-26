<?php

namespace App\Tests\Factory;

use App\Entity\Dinosaur;
use App\Factory\DinosaurFactory;
use App\Service\DinosaurLengthDeterminator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DinosaurFactoryTest extends TestCase
{
    private DinosaurFactory $factory;

    private MockObject $lengthDeterminator;

    protected function setUp(): void
    {
        $this->lengthDeterminator = $this->createMock(DinosaurLengthDeterminator::class);
        $this->factory            = new DinosaurFactory($this->lengthDeterminator);
    }

    public function testItGrowsAVelociraptor(): void
    {
        $dinosaur = $this->factory->growVelociraptor(5);
        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        $this->assertIsString($dinosaur->getGenus());
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertSame(5, $dinosaur->getLength());
    }

    public function testItGrowsATriceratops()
    {
        $this->markTestIncomplete('Waiting for confirmation from GenLab');
    }

    public function testItGrowsABabyVelociraptor()
    {
        if (!class_exists('Nanny')) {
            $this->markTestSkipped('There is nobody to watch the baby');
        }
        $dinosaur = $this->factory->growVelociraptor(1);
        $this->assertSame(1, $dinosaur->getLength());
    }

    /**
     * @dataProvider getSpecificationTests
     */
    public function testItGrowsADinosaurFromASpecification(string $spec, bool $expectedIsCarnivorous)
    {
        $this->lengthDeterminator->expects($this->once())
            ->method('getLengthFromSpecification')
            ->with($spec)
            ->willReturn(20);
        $dinosaur = $this->factory->growFromSpecification($spec);

        $this->assertSame($expectedIsCarnivorous, $dinosaur->isCarnivorous(), 'Diets do not match');
        $this->assertSame(20, $dinosaur->getLength());
    }

    public function getSpecificationTests()
    {
        return [
            // specification is large, i carnivorous
            ['large carnivorous dinosaur', true],
            'default response' => ['give me all the cookies!!!', false],
            ['large herbivore', false],
        ];
    }
}
