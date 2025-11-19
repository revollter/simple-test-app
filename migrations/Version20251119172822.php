<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251119172822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data DROP CONSTRAINT fk_adf3f3639b6b5fba');
        $this->addSql('DROP INDEX idx_adf3f3639b6b5fba');
        $this->addSql('ALTER TABLE data RENAME COLUMN account_id TO user_id');
        $this->addSql('ALTER TABLE data ADD CONSTRAINT FK_ADF3F363A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_ADF3F363A76ED395 ON data (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data DROP CONSTRAINT FK_ADF3F363A76ED395');
        $this->addSql('DROP INDEX IDX_ADF3F363A76ED395');
        $this->addSql('ALTER TABLE data RENAME COLUMN user_id TO account_id');
        $this->addSql('ALTER TABLE data ADD CONSTRAINT fk_adf3f3639b6b5fba FOREIGN KEY (account_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_adf3f3639b6b5fba ON data (account_id)');
    }
}
