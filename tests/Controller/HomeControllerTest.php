<?php

namespace App\Tests\Controller;

use App\DataFixtures\LoadBasicParkDataFixtures;
use App\DataFixtures\LoadSecurityDataFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Throwable;

class HomeControllerTest extends WebTestCase
{
    private AbstractDatabaseTool $databaseTool;

    private EntityManagerInterface $entityManager;

    private KernelBrowser $client;

    private $responseContent;

    public function setUp(): void
    {
        $this->client        = static::createClient();
        $this->databaseTool  = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
    }

    public function testEnclosuresAreShownOnTheHomepage()
    {
        $this->databaseTool->loadFixtures([LoadBasicParkDataFixtures::class, LoadSecurityDataFixtures::class]);

        $crawler = $this->client->request('GET', '/');

        $this->assertResponseIsSuccessful();

        $table = $crawler->filter('.table-enclosures');

        $this->assertCount(3, $table->filter('tbody tr'));
    }

    public function testThatThereIsAnAlarmButtonWithoutSecurity()
    {
        $fixtures = $this->databaseTool->loadFixtures(
                [LoadBasicParkDataFixtures::class, LoadSecurityDataFixtures::class]
            )->getReferenceRepository();

        $crawler = $this->client->request('GET', '/');
        $this->responseContent = $this->client->getResponse()->getContent();

        $enclosure = $fixtures->getReference('carnivorous-enclosure');
        $selector  = sprintf('#enclosure-%s .button-alarm', $enclosure->getId());

        $this->assertGreaterThan(0, $crawler->filter($selector)->count());
    }

    /**
     * Dump html content in case of test failure
     * @throws Throwable
     */
    protected function onNotSuccessfulTest(Throwable $t): void
    {
//        dump($this->responseContent);
        throw $t;
    }
}