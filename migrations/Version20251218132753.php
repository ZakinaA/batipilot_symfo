<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251218132753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chantier_poste (id INT AUTO_INCREMENT NOT NULL, montant_ht DOUBLE PRECISION DEFAULT NULL, montant_ttc DOUBLE PRECISION DEFAULT NULL, chantier_id INT DEFAULT NULL, poste_id INT DEFAULT NULL, INDEX IDX_6F4F780BD0C0049D (chantier_id), INDEX IDX_6F4F780BA0905086 (poste_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE chantier_poste ADD CONSTRAINT FK_6F4F780BD0C0049D FOREIGN KEY (chantier_id) REFERENCES chantier (id)');
        $this->addSql('ALTER TABLE chantier_poste ADD CONSTRAINT FK_6F4F780BA0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chantier_poste DROP FOREIGN KEY FK_6F4F780BD0C0049D');
        $this->addSql('ALTER TABLE chantier_poste DROP FOREIGN KEY FK_6F4F780BA0905086');
        $this->addSql('DROP TABLE chantier_poste');
    }
}
