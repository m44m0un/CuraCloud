<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307204355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE likes (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, blog_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_49CA4E7DA76ED395 (user_id), INDEX IDX_49CA4E7DDAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_stream (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, stream_id INT NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_C7CE2313A76ED395 (user_id), INDEX IDX_C7CE2313D0ED463E (stream_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stream (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_F0E9BE1CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7DDAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('ALTER TABLE message_stream ADD CONSTRAINT FK_C7CE2313A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message_stream ADD CONSTRAINT FK_C7CE2313D0ED463E FOREIGN KEY (stream_id) REFERENCES stream (id)');
        $this->addSql('ALTER TABLE stream ADD CONSTRAINT FK_F0E9BE1CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE blog ADD author_id INT NOT NULL');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C0155143F675F31B ON blog (author_id)');
        $this->addSql('ALTER TABLE comments ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962AA76ED395 ON comments (user_id)');
        $this->addSql('ALTER TABLE dislike ADD user_id INT NOT NULL, ADD blog_id INT NOT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE dislike ADD CONSTRAINT FK_FE3BECAAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE dislike ADD CONSTRAINT FK_FE3BECAADAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('CREATE INDEX IDX_FE3BECAAA76ED395 ON dislike (user_id)');
        $this->addSql('CREATE INDEX IDX_FE3BECAADAE07E97 ON dislike (blog_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7DA76ED395');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7DDAE07E97');
        $this->addSql('ALTER TABLE message_stream DROP FOREIGN KEY FK_C7CE2313A76ED395');
        $this->addSql('ALTER TABLE message_stream DROP FOREIGN KEY FK_C7CE2313D0ED463E');
        $this->addSql('ALTER TABLE stream DROP FOREIGN KEY FK_F0E9BE1CA76ED395');
        $this->addSql('DROP TABLE likes');
        $this->addSql('DROP TABLE message_stream');
        $this->addSql('DROP TABLE stream');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143F675F31B');
        $this->addSql('DROP INDEX IDX_C0155143F675F31B ON blog');
        $this->addSql('ALTER TABLE blog DROP author_id');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395');
        $this->addSql('DROP INDEX IDX_5F9E962AA76ED395 ON comments');
        $this->addSql('ALTER TABLE comments DROP user_id');
        $this->addSql('ALTER TABLE dislike DROP FOREIGN KEY FK_FE3BECAAA76ED395');
        $this->addSql('ALTER TABLE dislike DROP FOREIGN KEY FK_FE3BECAADAE07E97');
        $this->addSql('DROP INDEX IDX_FE3BECAAA76ED395 ON dislike');
        $this->addSql('DROP INDEX IDX_FE3BECAADAE07E97 ON dislike');
        $this->addSql('ALTER TABLE dislike DROP user_id, DROP blog_id, DROP created_at');
    }
}
