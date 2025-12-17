<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251212144724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chirurgien DROP FOREIGN KEY `FK_1384D5E5F0388CB`');
        $this->addSql('DROP INDEX IDX_1384D5E5F0388CB ON chirurgien');
        $this->addSql('ALTER TABLE chirurgien DROP operer_id');
        $this->addSql('ALTER TABLE chirurgien_chirurgie_materiel DROP FOREIGN KEY `FK_C3FC71441E5516F8`');
        $this->addSql('ALTER TABLE chirurgien_chirurgie_materiel DROP FOREIGN KEY `FK_C3FC7144E85441D8`');
        $this->addSql('DROP INDEX IDX_C3FC71441E5516F8 ON chirurgien_chirurgie_materiel');
        $this->addSql('DROP INDEX IDX_C3FC7144E85441D8 ON chirurgien_chirurgie_materiel');
        $this->addSql('ALTER TABLE chirurgien_chirurgie_materiel DROP liste_id, DROP materiel_liste_id, CHANGE chirurgien_id chirurgien_id INT NOT NULL, CHANGE chirurgie_id chirurgie_id INT NOT NULL, CHANGE materiel_id materiel_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chirurgien ADD operer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chirurgien ADD CONSTRAINT `FK_1384D5E5F0388CB` FOREIGN KEY (operer_id) REFERENCES programme_operatoire (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1384D5E5F0388CB ON chirurgien (operer_id)');
        $this->addSql('ALTER TABLE chirurgien_chirurgie_materiel ADD liste_id INT DEFAULT NULL, ADD materiel_liste_id INT DEFAULT NULL, CHANGE chirurgien_id chirurgien_id INT DEFAULT NULL, CHANGE chirurgie_id chirurgie_id INT DEFAULT NULL, CHANGE materiel_id materiel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chirurgien_chirurgie_materiel ADD CONSTRAINT `FK_C3FC71441E5516F8` FOREIGN KEY (materiel_liste_id) REFERENCES materiel (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE chirurgien_chirurgie_materiel ADD CONSTRAINT `FK_C3FC7144E85441D8` FOREIGN KEY (liste_id) REFERENCES chirurgien (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C3FC71441E5516F8 ON chirurgien_chirurgie_materiel (materiel_liste_id)');
        $this->addSql('CREATE INDEX IDX_C3FC7144E85441D8 ON chirurgien_chirurgie_materiel (liste_id)');
    }
}
