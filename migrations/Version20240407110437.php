<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240407110437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96CCFA12B8');
        $this->addSql('DROP INDEX IDX_DB021E96CCFA12B8 ON messages');
        $this->addSql('ALTER TABLE messages ADD name VARCHAR(255) NOT NULL, CHANGE profile_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DB021E96A76ED395 ON messages (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96A76ED395');
        $this->addSql('DROP INDEX IDX_DB021E96A76ED395 ON messages');
        $this->addSql('ALTER TABLE messages DROP name, CHANGE user_id profile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_DB021E96CCFA12B8 ON messages (profile_id)');
    }
}
