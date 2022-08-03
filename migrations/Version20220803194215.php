<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220803194215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial migration. Creates tables: dinosaur, enclosure and security.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE dinosaur (id INT AUTO_INCREMENT NOT NULL, enclosure_id INT DEFAULT NULL, length INT NOT NULL, genus VARCHAR(255) NOT NULL, is_carnivorous TINYINT(1) NOT NULL, INDEX IDX_DAEDC56ED04FE1E5 (enclosure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enclosure (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE security (id INT AUTO_INCREMENT NOT NULL, enclosure_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_C59BD5C1D04FE1E5 (enclosure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dinosaur ADD CONSTRAINT FK_DAEDC56ED04FE1E5 FOREIGN KEY (enclosure_id) REFERENCES enclosure (id)');
        $this->addSql('ALTER TABLE security ADD CONSTRAINT FK_C59BD5C1D04FE1E5 FOREIGN KEY (enclosure_id) REFERENCES enclosure (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE dinosaur DROP FOREIGN KEY FK_DAEDC56ED04FE1E5');
        $this->addSql('ALTER TABLE security DROP FOREIGN KEY FK_C59BD5C1D04FE1E5');
        $this->addSql('DROP TABLE dinosaur');
        $this->addSql('DROP TABLE enclosure');
        $this->addSql('DROP TABLE security');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
