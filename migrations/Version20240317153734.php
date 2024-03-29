<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240317153734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gender (id INT AUTO_INCREMENT NOT NULL, gender VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, paint_id INT DEFAULT NULL, messages VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_DB021E96CCFA12B8 (profile_id), INDEX IDX_DB021E969017B5FF (paint_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paint (id INT AUTO_INCREMENT NOT NULL, photo_id INT DEFAULT NULL, category_id INT DEFAULT NULL, status_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, size_w INT NOT NULL, size_h INT NOT NULL, size_d INT NOT NULL, price INT NOT NULL, type_of_work VARCHAR(255) DEFAULT NULL, grade_count INT NOT NULL, grade_total INT NOT NULL, UNIQUE INDEX UNIQ_577A84177E9E4C8C (photo_id), INDEX IDX_577A841712469DE2 (category_id), INDEX IDX_577A84176BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, paint_id INT DEFAULT NULL, panier_count INT NOT NULL, panier_total INT NOT NULL, INDEX IDX_24CC0DF2CCFA12B8 (profile_id), INDEX IDX_24CC0DF29017B5FF (paint_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, paint_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6D28840DCCFA12B8 (profile_id), UNIQUE INDEX UNIQ_6D28840D9017B5FF (paint_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, gender_id INT DEFAULT NULL, user_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, tel INT NOT NULL, INDEX IDX_8157AA0F708A0E0 (gender_id), UNIQUE INDEX UNIQ_8157AA0FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, is_available TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E969017B5FF FOREIGN KEY (paint_id) REFERENCES paint (id)');
        $this->addSql('ALTER TABLE paint ADD CONSTRAINT FK_577A84177E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE paint ADD CONSTRAINT FK_577A841712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE paint ADD CONSTRAINT FK_577A84176BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF29017B5FF FOREIGN KEY (paint_id) REFERENCES paint (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DCCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D9017B5FF FOREIGN KEY (paint_id) REFERENCES paint (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96CCFA12B8');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E969017B5FF');
        $this->addSql('ALTER TABLE paint DROP FOREIGN KEY FK_577A84177E9E4C8C');
        $this->addSql('ALTER TABLE paint DROP FOREIGN KEY FK_577A841712469DE2');
        $this->addSql('ALTER TABLE paint DROP FOREIGN KEY FK_577A84176BF700BD');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2CCFA12B8');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF29017B5FF');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DCCFA12B8');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D9017B5FF');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F708A0E0');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FA76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE gender');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE paint');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE user');
    }
}
