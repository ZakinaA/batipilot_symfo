<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251217211232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chantier ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chantier ADD CONSTRAINT FK_636F27F619EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_636F27F619EB6921 ON chantier (client_id)');
        $this->addSql('ALTER TABLE chantier_etape DROP FOREIGN KEY `FK_3B99027DA0905086`');
        $this->addSql('DROP INDEX IDX_3B99027DA0905086 ON chantier_etape');
        $this->addSql('ALTER TABLE chantier_etape CHANGE poste_id chantier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chantier_etape ADD CONSTRAINT FK_3B99027DD0C0049D FOREIGN KEY (chantier_id) REFERENCES chantier (id)');
        $this->addSql('CREATE INDEX IDX_3B99027DD0C0049D ON chantier_etape (chantier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chantier DROP FOREIGN KEY FK_636F27F619EB6921');
        $this->addSql('DROP INDEX IDX_636F27F619EB6921 ON chantier');
        $this->addSql('ALTER TABLE chantier DROP client_id');
        $this->addSql('ALTER TABLE chantier_etape DROP FOREIGN KEY FK_3B99027DD0C0049D');
        $this->addSql('DROP INDEX IDX_3B99027DD0C0049D ON chantier_etape');
        $this->addSql('ALTER TABLE chantier_etape CHANGE chantier_id poste_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chantier_etape ADD CONSTRAINT `FK_3B99027DA0905086` FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('CREATE INDEX IDX_3B99027DA0905086 ON chantier_etape (poste_id)');
    }
}
