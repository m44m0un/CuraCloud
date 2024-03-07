<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229193006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE meds (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, dose VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prescription (id INT AUTO_INCREMENT NOT NULL, duration VARCHAR(255) DEFAULT NULL, status TINYINT(1) DEFAULT NULL, creation_date DATE NOT NULL, validation_date DATE DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prescription_meds (prescription_id INT NOT NULL, meds_id INT NOT NULL, INDEX IDX_6CD7CBD993DB413D (prescription_id), INDEX IDX_6CD7CBD9A30CAE6F (meds_id), PRIMARY KEY(prescription_id, meds_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prescription_meds ADD CONSTRAINT FK_6CD7CBD993DB413D FOREIGN KEY (prescription_id) REFERENCES prescription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prescription_meds ADD CONSTRAINT FK_6CD7CBD9A30CAE6F FOREIGN KEY (meds_id) REFERENCES meds (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prescription_meds DROP FOREIGN KEY FK_6CD7CBD993DB413D');
        $this->addSql('ALTER TABLE prescription_meds DROP FOREIGN KEY FK_6CD7CBD9A30CAE6F');
        $this->addSql('DROP TABLE meds');
        $this->addSql('DROP TABLE prescription');
        $this->addSql('DROP TABLE prescription_meds');
    }
}
