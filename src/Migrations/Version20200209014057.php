<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200209014057 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE end_user ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE end_user ADD CONSTRAINT FK_A3515A0D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_A3515A0D19EB6921 ON end_user (client_id)');
        $this->addSql('ALTER TABLE phone ADD supplier_id INT DEFAULT NULL, ADD specification_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE phone ADD CONSTRAINT FK_444F97DD2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE phone ADD CONSTRAINT FK_444F97DD908E2FFE FOREIGN KEY (specification_id) REFERENCES specification (id)');
        $this->addSql('CREATE INDEX IDX_444F97DD2ADD6D8C ON phone (supplier_id)');
        $this->addSql('CREATE INDEX IDX_444F97DD908E2FFE ON phone (specification_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE end_user DROP FOREIGN KEY FK_A3515A0D19EB6921');
        $this->addSql('DROP INDEX IDX_A3515A0D19EB6921 ON end_user');
        $this->addSql('ALTER TABLE end_user DROP client_id');
        $this->addSql('ALTER TABLE phone DROP FOREIGN KEY FK_444F97DD2ADD6D8C');
        $this->addSql('ALTER TABLE phone DROP FOREIGN KEY FK_444F97DD908E2FFE');
        $this->addSql('DROP INDEX IDX_444F97DD2ADD6D8C ON phone');
        $this->addSql('DROP INDEX IDX_444F97DD908E2FFE ON phone');
        $this->addSql('ALTER TABLE phone DROP supplier_id, DROP specification_id');
    }
}
