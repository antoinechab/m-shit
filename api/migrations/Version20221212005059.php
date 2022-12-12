<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221212005059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE avatar_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE avatar (id INT NOT NULL, content_url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE contact ADD avatar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E63886383B10 FOREIGN KEY (avatar_id) REFERENCES avatar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C62E63886383B10 ON contact (avatar_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP CONSTRAINT FK_4C62E63886383B10');
        $this->addSql('DROP SEQUENCE avatar_id_seq CASCADE');
        $this->addSql('DROP TABLE avatar');
        $this->addSql('DROP INDEX UNIQ_4C62E63886383B10');
        $this->addSql('ALTER TABLE contact DROP avatar_id');
    }
}
