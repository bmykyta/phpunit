<?php

namespace App\Tests\Service;

use App\Entity\Dinosaur;
use App\Entity\Security;
use App\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EnclosureBuilderServiceIntegrationTest extends KernelTestCase
{
    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testItBuildsEnclosureWithDefaultSpecification()
    {
        $enclosureBuilder = $this->getEnclosureBuilderService();

        $enclosureBuilder->buildEnclosure();

        $count = $this->em->getRepository(Security::class)
            ->createQueryBuilder('s')
            ->select(('COUNT(s.id)'))
            ->getQuery()
            ->getSingleScalarResult();

        $this->assertSame(1, $count, 'Amount of security systems is not the same.');

        $count = $this->em->getRepository(Dinosaur::class)
            ->createQueryBuilder('d')
            ->select(('COUNT(d.id)'))
            ->getQuery()
            ->getSingleScalarResult();

        $this->assertSame(3, $count, 'Amount of dinosaurs is not the same.');
    }

    private function getEnclosureBuilderService(): EnclosureBuilderService
    {
        return self::$kernel->getContainer()->get('test.' . EnclosureBuilderService::class);
    }
}