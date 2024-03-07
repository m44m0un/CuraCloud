<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307110855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message_stream (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, stream_id INT NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_C7CE2313A76ED395 (user_id), INDEX IDX_C7CE2313D0ED463E (stream_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_stream ADD CONSTRAINT FK_C7CE2313A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message_stream ADD CONSTRAINT FK_C7CE2313D0ED463E FOREIGN KEY (stream_id) REFERENCES stream (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message_stream DROP FOREIGN KEY FK_C7CE2313A76ED395');
        $this->addSql('ALTER TABLE message_stream DROP FOREIGN KEY FK_C7CE2313D0ED463E');
        $this->addSql('DROP TABLE message_stream');
    }
}
