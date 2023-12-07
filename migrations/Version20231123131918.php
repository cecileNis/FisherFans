<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231123131918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, number_of_street VARCHAR(255) NOT NULL, zip VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE boat (id INT AUTO_INCREMENT NOT NULL, port_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, date_of_fabrication DATETIME NOT NULL, licence VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, equipment VARCHAR(255) NOT NULL, caution INT NOT NULL, capacity INT NOT NULL, number_of_beds INT NOT NULL, details VARCHAR(255) NOT NULL, motorization VARCHAR(255) NOT NULL, power VARCHAR(255) NOT NULL, INDEX IDX_D86E834A76E92A9C (port_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, siret VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, type_of_activity VARCHAR(255) NOT NULL, rc VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fish (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, size INT NOT NULL, weight INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fishing_log (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, fish_id INT DEFAULT NULL, comment VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, date_of_fishing DATETIME NOT NULL, released TINYINT(1) NOT NULL, INDEX IDX_D0E6E4517E3C61F9 (owner_id), UNIQUE INDEX UNIQ_D0E6E4518311A1E2 (fish_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outing (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, type_of_rate VARCHAR(255) NOT NULL, date_of_start DATETIME NOT NULL, date_of_end DATETIME NOT NULL, passager_seat INT NOT NULL, rate INT NOT NULL, INDEX IDX_F2A106257E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE port (id INT AUTO_INCREMENT NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, outing_id INT DEFAULT NULL, date DATETIME NOT NULL, passager_seat INT NOT NULL, price INT NOT NULL, INDEX IDX_42C849557E3C61F9 (owner_id), INDEX IDX_42C84955AF4C7531 (outing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, address_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, date_of_birth DATETIME NOT NULL, phone_number VARCHAR(255) NOT NULL, language VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, licence VARCHAR(255) NOT NULL, insurance VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649979B1AD6 (company_id), INDEX IDX_8D93D649F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boat ADD CONSTRAINT FK_D86E834A76E92A9C FOREIGN KEY (port_id) REFERENCES port (id)');
        $this->addSql('ALTER TABLE fishing_log ADD CONSTRAINT FK_D0E6E4517E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE fishing_log ADD CONSTRAINT FK_D0E6E4518311A1E2 FOREIGN KEY (fish_id) REFERENCES fish (id)');
        $this->addSql('ALTER TABLE outing ADD CONSTRAINT FK_F2A106257E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849557E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955AF4C7531 FOREIGN KEY (outing_id) REFERENCES outing (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boat DROP FOREIGN KEY FK_D86E834A76E92A9C');
        $this->addSql('ALTER TABLE fishing_log DROP FOREIGN KEY FK_D0E6E4517E3C61F9');
        $this->addSql('ALTER TABLE fishing_log DROP FOREIGN KEY FK_D0E6E4518311A1E2');
        $this->addSql('ALTER TABLE outing DROP FOREIGN KEY FK_F2A106257E3C61F9');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849557E3C61F9');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955AF4C7531');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649979B1AD6');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F5B7AF75');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE boat');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE fish');
        $this->addSql('DROP TABLE fishing_log');
        $this->addSql('DROP TABLE outing');
        $this->addSql('DROP TABLE port');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE user');
    }
}
