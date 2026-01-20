<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260120152734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chantier_presta (id INT AUTO_INCREMENT NOT NULL, montant_presta DOUBLE PRECISION DEFAULT NULL, nom_presta VARCHAR(150) NOT NULL, chantier_id INT NOT NULL, poste_id INT NOT NULL, equipe_id INT DEFAULT NULL, INDEX IDX_C49E4656D0C0049D (chantier_id), INDEX IDX_C49E4656A0905086 (poste_id), INDEX IDX_C49E46566D861B89 (equipe_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, montant_mo DOUBLE PRECISION DEFAULT NULL, indice INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE chantier_presta ADD CONSTRAINT FK_C49E4656D0C0049D FOREIGN KEY (chantier_id) REFERENCES chantier (id)');
        $this->addSql('ALTER TABLE chantier_presta ADD CONSTRAINT FK_C49E4656A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('ALTER TABLE chantier_presta ADD CONSTRAINT FK_C49E46566D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE chantier_poste ADD nb_jours_mo DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE poste ADD equipe VARCHAR(100) DEFAULT NULL, ADD presta VARCHAR(150) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chantier_presta DROP FOREIGN KEY FK_C49E4656D0C0049D');
        $this->addSql('ALTER TABLE chantier_presta DROP FOREIGN KEY FK_C49E4656A0905086');
        $this->addSql('ALTER TABLE chantier_presta DROP FOREIGN KEY FK_C49E46566D861B89');
        $this->addSql('DROP TABLE chantier_presta');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('ALTER TABLE chantier_poste DROP nb_jours_mo');
        $this->addSql('ALTER TABLE poste DROP equipe, DROP presta');
    }
}
