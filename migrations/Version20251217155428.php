<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251217155428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chirurgie DROP id_chirurgie');
        $this->addSql('ALTER TABLE chirurgien DROP id_chirurgien');
        $this->addSql('ALTER TABLE liste_materiel DROP id_liste_materiel');
        $this->addSql('ALTER TABLE liste_materiel ADD CONSTRAINT FK_40FEB6B6DB64F5D FOREIGN KEY (chirurgien_id) REFERENCES chirurgien (id)');
        $this->addSql('CREATE INDEX IDX_40FEB6B6DB64F5D ON liste_materiel (chirurgien_id)');
        $this->addSql('ALTER TABLE materiel DROP id_materiel');
        $this->addSql('ALTER TABLE specialite DROP id_specialite');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chirurgie ADD id_chirurgie INT NOT NULL');
        $this->addSql('ALTER TABLE chirurgien ADD id_chirurgien INT NOT NULL');
        $this->addSql('ALTER TABLE liste_materiel DROP FOREIGN KEY FK_40FEB6B6DB64F5D');
        $this->addSql('DROP INDEX IDX_40FEB6B6DB64F5D ON liste_materiel');
        $this->addSql('ALTER TABLE liste_materiel ADD id_liste_materiel INT NOT NULL');
        $this->addSql('ALTER TABLE materiel ADD id_materiel INT NOT NULL');
        $this->addSql('ALTER TABLE specialite ADD id_specialite INT NOT NULL');
    }
}
