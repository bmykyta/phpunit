<?php

namespace App\Service;

use App\Entity\Enclosure;
use App\Entity\Security;
use App\Exception\DinosaursAreRunningRampantException;
use App\Exception\NotABuffetException;
use App\Factory\DinosaurFactory;
use Doctrine\ORM\EntityManagerInterface;

class EnclosureBuilderService
{
    public function __construct(private EntityManagerInterface $entityManager, private DinosaurFactory $dinosaurFactory)
    {
    }

    /**
     * @throws DinosaursAreRunningRampantException
     * @throws NotABuffetException
     */
    public function buildEnclosure(
        int $numberOfSecuritySystems = 1,
        int $numberOfDinosaurs = 3,
    ): Enclosure {
        $enclosure = new Enclosure();

        $this->addSecuritySystems($numberOfSecuritySystems, $enclosure);

        $this->addDinosaurs($numberOfDinosaurs, $enclosure);

        $this->entityManager->persist($enclosure);
        $this->entityManager->flush();

        return $enclosure;
    }

    private function addSecuritySystems(int $numberOfSecuritySystems, Enclosure $enclosure): void
    {
        $securityNames = ['Fence', 'Electric fence', 'Guard tower'];

        for ($i = 0; $i < $numberOfSecuritySystems; $i++) {
            $securityName = $securityNames[array_rand($securityNames)];
            $security     = new Security($securityName, true, $enclosure);

            $enclosure->addSecurities($security);
        }
    }

    /**
     * @throws DinosaursAreRunningRampantException
     * @throws NotABuffetException
     */
    private function addDinosaurs(int $numberOfDinosaurs, Enclosure $enclosure): void
    {
        for ($i = 0; $i < $numberOfDinosaurs; $i++) {
            $length = array_rand(['small', 'large', 'huge']);
            $diet   = array_rand(['herbivore', 'carnivorous']);
            $specification = "{$length} {$diet} dinosaur";
            $dinosaur      = $this->dinosaurFactory->growFromSpecification($specification);

            $enclosure->addDinosaur($dinosaur);
        }
    }
}
