<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251212134055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE materiel_chirurgie (materiel_id INT NOT NULL, chirurgie_id INT NOT NULL, INDEX IDX_D7CE099616880AAF (materiel_id), INDEX IDX_D7CE0996B6C5A438 (chirurgie_id), PRIMARY KEY (materiel_id, chirurgie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE materiel_chirurgie ADD CONSTRAINT FK_D7CE099616880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE materiel_chirurgie ADD CONSTRAINT FK_D7CE0996B6C5A438 FOREIGN KEY (chirurgie_id) REFERENCES chirurgie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_materiel DROP FOREIGN KEY `FK_40FEB6B6DB64F5D`');
        $this->addSql('ALTER TABLE liste_materiel DROP FOREIGN KEY `FK_40FEB6BB6C5A438`');
        $this->addSql('ALTER TABLE liste_materiel_materiel DROP FOREIGN KEY `FK_5B47E14016880AAF`');
        $this->addSql('ALTER TABLE liste_materiel_materiel DROP FOREIGN KEY `FK_5B47E140FF6D643`');
        $this->addSql('DROP TABLE liste_materiel');
        $this->addSql('DROP TABLE liste_materiel_materiel');
        $this->addSql('ALTER TABLE chirurgie CHANGE chirurgien_id chirurgien_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE liste_materiel (id INT AUTO_INCREMENT NOT NULL, chirurgien_id INT NOT NULL, chirurgie_id INT NOT NULL, INDEX IDX_40FEB6B6DB64F5D (chirurgien_id), INDEX IDX_40FEB6BB6C5A438 (chirurgie_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE liste_materiel_materiel (liste_materiel_id INT NOT NULL, materiel_id INT NOT NULL, INDEX IDX_5B47E14016880AAF (materiel_id), INDEX IDX_5B47E140FF6D643 (liste_materiel_id), PRIMARY KEY (liste_materiel_id, materiel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE liste_materiel ADD CONSTRAINT `FK_40FEB6B6DB64F5D` FOREIGN KEY (chirurgien_id) REFERENCES chirurgien (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE liste_materiel ADD CONSTRAINT `FK_40FEB6BB6C5A438` FOREIGN KEY (chirurgie_id) REFERENCES chirurgie (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE liste_materiel_materiel ADD CONSTRAINT `FK_5B47E14016880AAF` FOREIGN KEY (materiel_id) REFERENCES materiel (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_materiel_materiel ADD CONSTRAINT `FK_5B47E140FF6D643` FOREIGN KEY (liste_materiel_id) REFERENCES liste_materiel (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE materiel_chirurgie DROP FOREIGN KEY FK_D7CE099616880AAF');
        $this->addSql('ALTER TABLE materiel_chirurgie DROP FOREIGN KEY FK_D7CE0996B6C5A438');
        $this->addSql('DROP TABLE materiel_chirurgie');
        $this->addSql('ALTER TABLE chirurgie CHANGE chirurgien_id chirurgien_id INT DEFAULT NULL');
    }
}
