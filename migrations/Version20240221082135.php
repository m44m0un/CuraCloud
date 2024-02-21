<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240221082135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog ADD creator_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143F05788E9 FOREIGN KEY (creator_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C0155143F05788E9 ON blog (creator_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143F05788E9');
        $this->addSql('DROP INDEX IDX_C0155143F05788E9 ON blog');
        $this->addSql('ALTER TABLE blog DROP creator_id_id');
    }
}
