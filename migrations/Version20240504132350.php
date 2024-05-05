<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240504132350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE method (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DCCFA12B8');
        $this->addSql('DROP INDEX IDX_6D28840DCCFA12B8 ON payment');
        $this->addSql('ALTER TABLE payment ADD method_id INT DEFAULT NULL, CHANGE profile_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D19883967 FOREIGN KEY (method_id) REFERENCES method (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6D28840DA76ED395 ON payment (user_id)');
        $this->addSql('CREATE INDEX IDX_6D28840D19883967 ON payment (method_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D19883967');
        $this->addSql('DROP TABLE method');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DA76ED395');
        $this->addSql('DROP INDEX UNIQ_6D28840DA76ED395 ON payment');
        $this->addSql('DROP INDEX IDX_6D28840D19883967 ON payment');
        $this->addSql('ALTER TABLE payment ADD profile_id INT DEFAULT NULL, DROP user_id, DROP method_id');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DCCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6D28840DCCFA12B8 ON payment (profile_id)');
    }
}
