<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220504072958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annoucement (id INT AUTO_INCREMENT NOT NULL, concerne_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, picture LONGTEXT DEFAULT NULL, INDEX IDX_E23D8BAA6406FEF1 (concerne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, model VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, release_year DATE NOT NULL, km INT NOT NULL, fuel VARCHAR(255) NOT NULL, driver_license TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, annoucement_id INT NOT NULL, belong_id INT NOT NULL, INDEX IDX_68C58ED932B110F5 (annoucement_id), INDEX IDX_68C58ED9A0D092F9 (belong_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annoucement ADD CONSTRAINT FK_E23D8BAA6406FEF1 FOREIGN KEY (concerne_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED932B110F5 FOREIGN KEY (annoucement_id) REFERENCES annoucement (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9A0D092F9 FOREIGN KEY (belong_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED932B110F5');
        $this->addSql('ALTER TABLE annoucement DROP FOREIGN KEY FK_E23D8BAA6406FEF1');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9A0D092F9');
        $this->addSql('DROP TABLE annoucement');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
