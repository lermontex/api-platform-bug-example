<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220424011401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE domains (id UUID NOT NULL, user_id UUID NOT NULL, api_token VARCHAR(255) DEFAULT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8C7BBF9DA76ED395 ON domains (user_id)');
        $this->addSql('COMMENT ON COLUMN domains.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN domains.user_id IS \'(DC2Type:ulid)\'');
        $this->addSql('CREATE TABLE reset_token_requests (id UUID NOT NULL, domain_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F45DF933115F0EE5 ON reset_token_requests (domain_id)');
        $this->addSql('COMMENT ON COLUMN reset_token_requests.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN reset_token_requests.domain_id IS \'(DC2Type:ulid)\'');
        $this->addSql('CREATE TABLE users (id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN users.id IS \'(DC2Type:ulid)\'');
        $this->addSql('ALTER TABLE domains ADD CONSTRAINT FK_8C7BBF9DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_token_requests ADD CONSTRAINT FK_F45DF933115F0EE5 FOREIGN KEY (domain_id) REFERENCES domains (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE reset_token_requests DROP CONSTRAINT FK_F45DF933115F0EE5');
        $this->addSql('ALTER TABLE domains DROP CONSTRAINT FK_8C7BBF9DA76ED395');
        $this->addSql('DROP TABLE domains');
        $this->addSql('DROP TABLE reset_token_requests');
        $this->addSql('DROP TABLE users');
    }
}
