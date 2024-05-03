<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240502141809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier ADD paint_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF29017B5FF FOREIGN KEY (paint_id) REFERENCES paint (id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF29017B5FF ON panier (paint_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF29017B5FF');
        $this->addSql('DROP INDEX IDX_24CC0DF29017B5FF ON panier');
        $this->addSql('ALTER TABLE panier DROP paint_id');
    }
}
