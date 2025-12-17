<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251217191129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chantier (id INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(150) DEFAULT NULL, copos VARCHAR(5) DEFAULT NULL, ville VARCHAR(80) NOT NULL, date_prevue DATE DEFAULT NULL, date_demarrage DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, date_reception DATE DEFAULT NULL, distance_depot INT DEFAULT NULL, temps_trajet INT DEFAULT NULL, surface_maison DOUBLE PRECISION DEFAULT NULL, surface_combles DOUBLE PRECISION DEFAULT NULL, archive INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE chantier_etape (id INT AUTO_INCREMENT NOT NULL, val_text VARCHAR(50) DEFAULT NULL, val_date DATE DEFAULT NULL, val_date_heure DATETIME DEFAULT NULL, val_boolean TINYINT DEFAULT NULL, date_decimal DOUBLE PRECISION DEFAULT NULL, poste_id INT DEFAULT NULL, etape_id INT DEFAULT NULL, INDEX IDX_3B99027DA0905086 (poste_id), INDEX IDX_3B99027D4A8CA2AD (etape_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(80) NOT NULL, prenom VARCHAR(80) DEFAULT NULL, telephone VARCHAR(14) DEFAULT NULL, mail VARCHAR(120) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE etape (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, display_field INT NOT NULL, archive INT NOT NULL, etape_format_id INT NOT NULL, poste_id INT NOT NULL, INDEX IDX_285F75DDFB3A43EA (etape_format_id), INDEX IDX_285F75DDA0905086 (poste_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE etape_format (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE poste (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(80) NOT NULL, ordre INT NOT NULL, tva DOUBLE PRECISION DEFAULT NULL, archive INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE chantier_etape ADD CONSTRAINT FK_3B99027DA0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('ALTER TABLE chantier_etape ADD CONSTRAINT FK_3B99027D4A8CA2AD FOREIGN KEY (etape_id) REFERENCES etape (id)');
        $this->addSql('ALTER TABLE etape ADD CONSTRAINT FK_285F75DDFB3A43EA FOREIGN KEY (etape_format_id) REFERENCES etape_format (id)');
        $this->addSql('ALTER TABLE etape ADD CONSTRAINT FK_285F75DDA0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chantier_etape DROP FOREIGN KEY FK_3B99027DA0905086');
        $this->addSql('ALTER TABLE chantier_etape DROP FOREIGN KEY FK_3B99027D4A8CA2AD');
        $this->addSql('ALTER TABLE etape DROP FOREIGN KEY FK_285F75DDFB3A43EA');
        $this->addSql('ALTER TABLE etape DROP FOREIGN KEY FK_285F75DDA0905086');
        $this->addSql('DROP TABLE chantier');
        $this->addSql('DROP TABLE chantier_etape');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE etape');
        $this->addSql('DROP TABLE etape_format');
        $this->addSql('DROP TABLE poste');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
