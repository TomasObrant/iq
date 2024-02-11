<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240211210826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP CONSTRAINT fk_a45bddc1f8697d13');
        $this->addSql('DROP SEQUENCE comment_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE application_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT fk_9474526c783e3463');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP INDEX uniq_a45bddc1f8697d13');
        $this->addSql('ALTER TABLE application ADD comment VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE application DROP comment_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE application_status_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, manager_id INT DEFAULT NULL, text TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_9474526c783e3463 ON comment (manager_id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_9474526c783e3463 FOREIGN KEY (manager_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE application ADD comment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE application DROP comment');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT fk_a45bddc1f8697d13 FOREIGN KEY (comment_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_a45bddc1f8697d13 ON application (comment_id)');
    }
}
