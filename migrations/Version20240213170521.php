<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240213170521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, tel_number INT NOT NULL, sexe VARCHAR(255) NOT NULL, age INT NOT NULL, role INT NOT NULL, birth_date DATE NOT NULL, address VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, inscription_date DATE NOT NULL, is_verified TINYINT(1) DEFAULT NULL, speciality VARCHAR(255) DEFAULT NULL, certif VARCHAR(255) DEFAULT NULL, appartenance TINYINT(1) DEFAULT NULL, type_phar TINYINT(1) DEFAULT NULL, assurance_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
    }
}
