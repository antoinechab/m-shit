<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221211233532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE additionnal_field_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "group_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE additionnal_field (id INT NOT NULL, contact_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, field VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5D583E4AE7A1254A ON additionnal_field (contact_id)');
        $this->addSql('CREATE TABLE contact (id INT NOT NULL, groups_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4C62E638F373DCF ON contact (groups_id)');
        $this->addSql('CREATE TABLE "group" (id INT NOT NULL, color VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE additionnal_field ADD CONSTRAINT FK_5D583E4AE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638F373DCF FOREIGN KEY (groups_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE additionnal_field_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contact_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "group_id_seq" CASCADE');
        $this->addSql('ALTER TABLE additionnal_field DROP CONSTRAINT FK_5D583E4AE7A1254A');
        $this->addSql('ALTER TABLE contact DROP CONSTRAINT FK_4C62E638F373DCF');
        $this->addSql('DROP TABLE additionnal_field');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE "group"');
    }
}
