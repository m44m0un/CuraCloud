<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306090232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diagnostic_request ADD id_patient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE diagnostic_request ADD CONSTRAINT FK_C636D1C0CE0312AE FOREIGN KEY (id_patient_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C636D1C0CE0312AE ON diagnostic_request (id_patient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diagnostic_request DROP FOREIGN KEY FK_C636D1C0CE0312AE');
        $this->addSql('DROP INDEX IDX_C636D1C0CE0312AE ON diagnostic_request');
        $this->addSql('ALTER TABLE diagnostic_request DROP id_patient_id');
    }
}
