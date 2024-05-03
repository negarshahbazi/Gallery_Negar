<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240502125627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF29017B5FF');
        $this->addSql('DROP INDEX IDX_24CC0DF29017B5FF ON panier');
        $this->addSql('ALTER TABLE panier ADD paint VARCHAR(255) NOT NULL, DROP paint_id, DROP panier_total');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier ADD paint_id INT DEFAULT NULL, ADD panier_total INT NOT NULL, DROP paint');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF29017B5FF FOREIGN KEY (paint_id) REFERENCES paint (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_24CC0DF29017B5FF ON panier (paint_id)');
    }
}
