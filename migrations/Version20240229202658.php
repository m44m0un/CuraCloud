<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229202658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, id_doctor_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, INDEX IDX_FE38F84479F37AE5 (id_user_id), INDEX IDX_FE38F8447C14730 (id_doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_record (id INT AUTO_INCREMENT NOT NULL, id_patient_id INT DEFAULT NULL, medical_history VARCHAR(255) NOT NULL, surgical_history VARCHAR(255) NOT NULL, family_history VARCHAR(255) NOT NULL, allergies VARCHAR(255) NOT NULL, height DOUBLE PRECISION NOT NULL, weight DOUBLE PRECISION NOT NULL, blood_type VARCHAR(255) NOT NULL, diseases VARCHAR(255) NOT NULL, medications VARCHAR(255) NOT NULL, vaccines VARCHAR(255) NOT NULL, patient_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F06A283ECE0312AE (id_patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F84479F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8447C14730 FOREIGN KEY (id_doctor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE medical_record ADD CONSTRAINT FK_F06A283ECE0312AE FOREIGN KEY (id_patient_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F84479F37AE5');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8447C14730');
        $this->addSql('ALTER TABLE medical_record DROP FOREIGN KEY FK_F06A283ECE0312AE');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE medical_record');
    }
}
