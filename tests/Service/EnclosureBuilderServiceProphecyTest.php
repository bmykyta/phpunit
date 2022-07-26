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
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class EnclosureBuilderServiceProphecyTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @throws DinosaursAreRunningRampantException
     * @throws NotABuffetException
     * @throws \Exception
     */
    public function testItBuildsAndPersistEnclosure(): void
    {
        $em = $this->prophesize(EntityManagerInterface::class);

        $em->persist(Argument::type(Enclosure::class))->shouldBeCalledOnce(1);
        $em->flush()->shouldBeCalled();

        $dinosaurFactory = $this->prophesize(DinosaurFactory::class);
        $dinosaurFactory->growFromSpecification(Argument::type('string'))->shouldBeCalledTimes(2)->willReturn(
            new Dinosaur()
        );

        $builder   = new EnclosureBuilderService($em->reveal(), $dinosaurFactory->reveal());
        $enclosure = $builder->buildEnclosure(1, 2);

        $this->assertCount(1, $enclosure->getSecurities());
        $this->assertCount(2, $enclosure->getDinosaurs());
    }
}
