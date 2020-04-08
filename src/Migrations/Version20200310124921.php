<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200310124921 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE post_meta_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE post_meta (id INT NOT NULL, views VARCHAR(255) NOT NULL, comments VARCHAR(255) NOT NULL, likes VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE post ADD meta_id INT NOT NULL');
        $this->addSql('ALTER TABLE post DROP meta');
        $this->addSql('ALTER TABLE post ALTER author_id SET NOT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D39FCA6F9 FOREIGN KEY (meta_id) REFERENCES post_meta (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A8A6C8D39FCA6F9 ON post (meta_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D39FCA6F9');
        $this->addSql('DROP SEQUENCE post_meta_id_seq CASCADE');
        $this->addSql('DROP TABLE post_meta');
        $this->addSql('DROP INDEX UNIQ_5A8A6C8D39FCA6F9');
        $this->addSql('ALTER TABLE post ADD meta JSON NOT NULL');
        $this->addSql('ALTER TABLE post DROP meta_id');
        $this->addSql('ALTER TABLE post ALTER author_id DROP NOT NULL');
    }
}
