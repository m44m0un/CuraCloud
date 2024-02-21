<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240221080210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE test');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143AAB644F0');
        $this->addSql('DROP INDEX IDX_C0155143AAB644F0 ON blog');
        $this->addSql('ALTER TABLE blog DROP writer_id_id');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL COMMENT \'(DC2Type:json)\', ADD first_name VARCHAR(255) DEFAULT NULL, ADD phone_number VARCHAR(255) DEFAULT NULL, ADD gender TINYINT(1) DEFAULT NULL, ADD certification VARCHAR(255) DEFAULT NULL, ADD public_or_private TINYINT(1) DEFAULT NULL, ADD pharmacytype TINYINT(1) DEFAULT NULL, DROP name, DROP tel_number, DROP sexe, DROP age, DROP role, DROP is_verified, DROP certif, DROP appartenance, DROP type_phar, DROP assurance_name, CHANGE last_name last_name VARCHAR(255) DEFAULT NULL, CHANGE birth_date birth_date VARCHAR(255) DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE inscription_date inscription_date DATETIME DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE blog ADD writer_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143AAB644F0 FOREIGN KEY (writer_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C0155143AAB644F0 ON blog (writer_id_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) NOT NULL, ADD tel_number INT NOT NULL, ADD sexe VARCHAR(255) NOT NULL, ADD age INT NOT NULL, ADD role INT NOT NULL, ADD is_verified TINYINT(1) DEFAULT NULL, ADD certif VARCHAR(255) DEFAULT NULL, ADD appartenance TINYINT(1) DEFAULT NULL, ADD type_phar TINYINT(1) DEFAULT NULL, ADD assurance_name VARCHAR(255) DEFAULT NULL, DROP roles, DROP first_name, DROP phone_number, DROP gender, DROP certification, DROP public_or_private, DROP pharmacytype, CHANGE email email VARCHAR(255) NOT NULL, CHANGE last_name last_name VARCHAR(255) NOT NULL, CHANGE birth_date birth_date DATE NOT NULL, CHANGE address address VARCHAR(255) NOT NULL, CHANGE inscription_date inscription_date DATE NOT NULL');
    }
}
