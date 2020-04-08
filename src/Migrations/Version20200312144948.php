<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200312144948 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE post_meta ALTER views TYPE INT USING (views::integer)');
        $this->addSql('ALTER TABLE post_meta ALTER views DROP DEFAULT');
        $this->addSql('ALTER TABLE post_meta ALTER comments TYPE INT USING (comments::integer)');
        $this->addSql('ALTER TABLE post_meta ALTER comments DROP DEFAULT');
        $this->addSql('ALTER TABLE post_meta ALTER likes TYPE INT USING (likes::integer)');
        $this->addSql('ALTER TABLE post_meta ALTER likes DROP DEFAULT');
        $this->addSql('ALTER TABLE post_meta ALTER status TYPE INT USING (status::integer)');
        $this->addSql('ALTER TABLE post_meta ALTER status DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE post_meta ALTER views TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE post_meta ALTER views DROP DEFAULT');
        $this->addSql('ALTER TABLE post_meta ALTER comments TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE post_meta ALTER comments DROP DEFAULT');
        $this->addSql('ALTER TABLE post_meta ALTER likes TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE post_meta ALTER likes DROP DEFAULT');
        $this->addSql('ALTER TABLE post_meta ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE post_meta ALTER status DROP DEFAULT');
    }
}
