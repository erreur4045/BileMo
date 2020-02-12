<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200212044539 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE specification ADD screendiagonal INT DEFAULT NULL, ADD screenresolution VARCHAR(255) DEFAULT NULL, ADD typeofscreen VARCHAR(255) DEFAULT NULL, ADD internalmemory INT DEFAULT NULL, ADD memorycard TINYINT(1) DEFAULT NULL, ADD photosensor INT DEFAULT NULL, ADD frontphotosensor INT DEFAULT NULL, ADD batterycapacity INT DEFAULT NULL, ADD operatingsystem VARCHAR(255) DEFAULT NULL, ADD dualsim TINYINT(1) DEFAULT NULL, DROP screen_diagonal, DROP screen_resolution, DROP type_of_screen, DROP internal_memory, DROP memory_card, DROP photo_sensor, DROP front_photo_sensor, DROP battery_capacity, DROP operating_system, DROP dual_sim');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE specification ADD screen_diagonal INT DEFAULT NULL, ADD screen_resolution VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD type_of_screen VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD internal_memory INT DEFAULT NULL, ADD memory_card TINYINT(1) DEFAULT NULL, ADD photo_sensor INT DEFAULT NULL, ADD front_photo_sensor INT DEFAULT NULL, ADD battery_capacity INT DEFAULT NULL, ADD operating_system VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD dual_sim TINYINT(1) DEFAULT NULL, DROP screendiagonal, DROP screenresolution, DROP typeofscreen, DROP internalmemory, DROP memorycard, DROP photosensor, DROP frontphotosensor, DROP batterycapacity, DROP operatingsystem, DROP dualsim');
    }
}
