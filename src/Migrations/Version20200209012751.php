<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200209012751 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE specification (id INT AUTO_INCREMENT NOT NULL, screen_diagonal INT DEFAULT NULL, screen_resolution INT DEFAULT NULL, type_of_screen VARCHAR(255) DEFAULT NULL, processor VARCHAR(255) DEFAULT NULL, ram INT DEFAULT NULL, internal_memory INT DEFAULT NULL, memory_card TINYINT(1) DEFAULT NULL, photo_sensor INT DEFAULT NULL, front_photo_sensor INT DEFAULT NULL, battery_capacity INT DEFAULT NULL, operating_system VARCHAR(255) DEFAULT NULL, nfc TINYINT(1) DEFAULT NULL, dual_sim TINYINT(1) DEFAULT NULL, network VARCHAR(10) DEFAULT NULL, other JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE specification');
    }
}
