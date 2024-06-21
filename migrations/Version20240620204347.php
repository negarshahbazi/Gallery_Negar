<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620204347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stars (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, paint_id INT DEFAULT NULL, grade_count INT NOT NULL, grade_total INT NOT NULL, INDEX IDX_11DC02CA76ED395 (user_id), INDEX IDX_11DC02C9017B5FF (paint_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stars ADD CONSTRAINT FK_11DC02CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE stars ADD CONSTRAINT FK_11DC02C9017B5FF FOREIGN KEY (paint_id) REFERENCES paint (id)');
        $this->addSql('ALTER TABLE etoile DROP FOREIGN KEY FK_357ADFC39017B5FF');
        $this->addSql('ALTER TABLE etoile DROP FOREIGN KEY FK_357ADFC3A76ED395');
        $this->addSql('DROP TABLE etoile');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etoile (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, paint_id INT DEFAULT NULL, grade_count VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, grade_total VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_357ADFC39017B5FF (paint_id), UNIQUE INDEX UNIQ_357ADFC3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE etoile ADD CONSTRAINT FK_357ADFC39017B5FF FOREIGN KEY (paint_id) REFERENCES paint (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE etoile ADD CONSTRAINT FK_357ADFC3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE stars DROP FOREIGN KEY FK_11DC02CA76ED395');
        $this->addSql('ALTER TABLE stars DROP FOREIGN KEY FK_11DC02C9017B5FF');
        $this->addSql('DROP TABLE stars');
    }
}
