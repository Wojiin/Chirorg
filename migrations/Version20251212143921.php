<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251212143921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chirurgien_chirurgie_materiel (id INT AUTO_INCREMENT NOT NULL, chirurgien_id INT DEFAULT NULL, chirurgie_id INT DEFAULT NULL, materiel_id INT DEFAULT NULL, liste_id INT DEFAULT NULL, materiel_liste_id INT DEFAULT NULL, INDEX IDX_C3FC71446DB64F5D (chirurgien_id), INDEX IDX_C3FC7144B6C5A438 (chirurgie_id), INDEX IDX_C3FC714416880AAF (materiel_id), INDEX IDX_C3FC7144E85441D8 (liste_id), INDEX IDX_C3FC71441E5516F8 (materiel_liste_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE chirurgien_chirurgie_materiel ADD CONSTRAINT FK_C3FC71446DB64F5D FOREIGN KEY (chirurgien_id) REFERENCES chirurgien (id)');
        $this->addSql('ALTER TABLE chirurgien_chirurgie_materiel ADD CONSTRAINT FK_C3FC7144B6C5A438 FOREIGN KEY (chirurgie_id) REFERENCES chirurgie (id)');
        $this->addSql('ALTER TABLE chirurgien_chirurgie_materiel ADD CONSTRAINT FK_C3FC714416880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id)');
        $this->addSql('ALTER TABLE chirurgien_chirurgie_materiel ADD CONSTRAINT FK_C3FC7144E85441D8 FOREIGN KEY (liste_id) REFERENCES chirurgien (id)');
        $this->addSql('ALTER TABLE chirurgien_chirurgie_materiel ADD CONSTRAINT FK_C3FC71441E5516F8 FOREIGN KEY (materiel_liste_id) REFERENCES materiel (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chirurgien_chirurgie_materiel DROP FOREIGN KEY FK_C3FC71446DB64F5D');
        $this->addSql('ALTER TABLE chirurgien_chirurgie_materiel DROP FOREIGN KEY FK_C3FC7144B6C5A438');
        $this->addSql('ALTER TABLE chirurgien_chirurgie_materiel DROP FOREIGN KEY FK_C3FC714416880AAF');
        $this->addSql('ALTER TABLE chirurgien_chirurgie_materiel DROP FOREIGN KEY FK_C3FC7144E85441D8');
        $this->addSql('ALTER TABLE chirurgien_chirurgie_materiel DROP FOREIGN KEY FK_C3FC71441E5516F8');
        $this->addSql('DROP TABLE chirurgien_chirurgie_materiel');
    }
}
