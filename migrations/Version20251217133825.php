<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251217133825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chirurgie (id INT AUTO_INCREMENT NOT NULL, id_chirurgie INT NOT NULL, intitule VARCHAR(255) NOT NULL, fiche_technique LONGTEXT NOT NULL, date DATETIME NOT NULL, salle VARCHAR(50) NOT NULL, valide TINYINT NOT NULL, utilisateur_id INT DEFAULT NULL, operer_id INT DEFAULT NULL, outiller_id INT DEFAULT NULL, INDEX IDX_EC562809FB88E14F (utilisateur_id), INDEX IDX_EC5628095F0388CB (operer_id), INDEX IDX_EC562809E0E4D13F (outiller_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE chirurgien (id INT AUTO_INCREMENT NOT NULL, id_chirurgien INT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, specialiser_id INT DEFAULT NULL, INDEX IDX_1384D5EFF548D04 (specialiser_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE liste_materiel (id INT AUTO_INCREMENT NOT NULL, id_liste_materiel INT NOT NULL, intitule VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, id_materiel INT NOT NULL, intitule VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, adresse VARCHAR(255) NOT NULL, classer_id INT DEFAULT NULL, INDEX IDX_18D2B091269E3C41 (classer_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE materiel_liste_materiel (materiel_id INT NOT NULL, liste_materiel_id INT NOT NULL, INDEX IDX_8065958116880AAF (materiel_id), INDEX IDX_80659581FF6D643 (liste_materiel_id), PRIMARY KEY (materiel_id, liste_materiel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, id_specialite INT NOT NULL, intitule VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE chirurgie ADD CONSTRAINT FK_EC562809FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE chirurgie ADD CONSTRAINT FK_EC5628095F0388CB FOREIGN KEY (operer_id) REFERENCES chirurgien (id)');
        $this->addSql('ALTER TABLE chirurgie ADD CONSTRAINT FK_EC562809E0E4D13F FOREIGN KEY (outiller_id) REFERENCES liste_materiel (id)');
        $this->addSql('ALTER TABLE chirurgien ADD CONSTRAINT FK_1384D5EFF548D04 FOREIGN KEY (specialiser_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT FK_18D2B091269E3C41 FOREIGN KEY (classer_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE materiel_liste_materiel ADD CONSTRAINT FK_8065958116880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE materiel_liste_materiel ADD CONSTRAINT FK_80659581FF6D643 FOREIGN KEY (liste_materiel_id) REFERENCES liste_materiel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chirurgie DROP FOREIGN KEY FK_EC562809FB88E14F');
        $this->addSql('ALTER TABLE chirurgie DROP FOREIGN KEY FK_EC5628095F0388CB');
        $this->addSql('ALTER TABLE chirurgie DROP FOREIGN KEY FK_EC562809E0E4D13F');
        $this->addSql('ALTER TABLE chirurgien DROP FOREIGN KEY FK_1384D5EFF548D04');
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY FK_18D2B091269E3C41');
        $this->addSql('ALTER TABLE materiel_liste_materiel DROP FOREIGN KEY FK_8065958116880AAF');
        $this->addSql('ALTER TABLE materiel_liste_materiel DROP FOREIGN KEY FK_80659581FF6D643');
        $this->addSql('DROP TABLE chirurgie');
        $this->addSql('DROP TABLE chirurgien');
        $this->addSql('DROP TABLE liste_materiel');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('DROP TABLE materiel_liste_materiel');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
