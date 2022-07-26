<?php

namespace App\Tests\Service;

use App\Entity\Dinosaur;
use App\Entity\Enclosure;
use App\Exception\DinosaursAreRunningRampantException;
use App\Exception\NotABuffetException;
use App\Factory\DinosaurFactory;
use App\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class EnclosureBuilderServiceTest extends TestCase
{
    /**
     * @throws DinosaursAreRunningRampantException
     * @throws NotABuffetException
     */
    public function testItBuildsAndPersistEnclosure(): void
    {
        $em              = $this->createMock(EntityManagerInterface::class);
        $dinosaurFactory = $this->createMock(DinosaurFactory::class);

        $em->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Enclosure::class));

        $em->expects($this->once())
            ->method('flush');

        $dinosaurFactory->expects($this->exactly(2))
            ->method('growFromSpecification')
            ->with($this->isType('string'))
            ->willReturn(new Dinosaur());

        $builder   = new EnclosureBuilderService($em, $dinosaurFactory);
        $enclosure = $builder->buildEnclosure(1, 2);

        $this->assertCount(1, $enclosure->getSecurities());
        $this->assertCount(2, $enclosure->getDinosaurs());
    }
}
