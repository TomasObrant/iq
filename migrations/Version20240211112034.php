<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240211112034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE application_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE application (id INT NOT NULL, creator_id INT DEFAULT NULL, status_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, topic VARCHAR(255) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A45BDDC161220EA6 ON application (creator_id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC16BF700BD ON application (status_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A45BDDC1F8697D13 ON application (comment_id)');
        $this->addSql('COMMENT ON COLUMN application.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN application.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN application.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC161220EA6 FOREIGN KEY (creator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC16BF700BD FOREIGN KEY (status_id) REFERENCES application_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE application_id_seq CASCADE');
        $this->addSql('ALTER TABLE application DROP CONSTRAINT FK_A45BDDC161220EA6');
        $this->addSql('ALTER TABLE application DROP CONSTRAINT FK_A45BDDC16BF700BD');
        $this->addSql('ALTER TABLE application DROP CONSTRAINT FK_A45BDDC1F8697D13');
        $this->addSql('DROP TABLE application');
    }
}
