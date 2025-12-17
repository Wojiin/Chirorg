<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251212085121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chirurgie (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, fiche_technique LONGTEXT NOT NULL, programme_operatoire_id INT NOT NULL, chirurgien_id INT DEFAULT NULL, INDEX IDX_EC562809FC7973B4 (programme_operatoire_id), INDEX IDX_EC5628096DB64F5D (chirurgien_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE chirurgien (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(150) NOT NULL, prenom VARCHAR(150) NOT NULL, specialiser_id INT NOT NULL, INDEX IDX_1384D5EFF548D04 (specialiser_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE liste_materiel (id INT AUTO_INCREMENT NOT NULL, chirurgien_id INT NOT NULL, chirurgie_id INT NOT NULL, INDEX IDX_40FEB6B6DB64F5D (chirurgien_id), INDEX IDX_40FEB6BB6C5A438 (chirurgie_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE liste_materiel_materiel (liste_materiel_id INT NOT NULL, materiel_id INT NOT NULL, INDEX IDX_5B47E140FF6D643 (liste_materiel_id), INDEX IDX_5B47E14016880AAF (materiel_id), PRIMARY KEY (liste_materiel_id, materiel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE programme_operatoire (id INT AUTO_INCREMENT NOT NULL, salle VARCHAR(3) NOT NULL, date DATETIME NOT NULL, organiser_id INT NOT NULL, assumer_id INT NOT NULL, INDEX IDX_FC39AF8AA0631C12 (organiser_id), INDEX IDX_FC39AF8A3580015B (assumer_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE chirurgie ADD CONSTRAINT FK_EC562809FC7973B4 FOREIGN KEY (programme_operatoire_id) REFERENCES programme_operatoire (id)');
        $this->addSql('ALTER TABLE chirurgie ADD CONSTRAINT FK_EC5628096DB64F5D FOREIGN KEY (chirurgien_id) REFERENCES chirurgien (id)');
        $this->addSql('ALTER TABLE chirurgien ADD CONSTRAINT FK_1384D5EFF548D04 FOREIGN KEY (specialiser_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE liste_materiel ADD CONSTRAINT FK_40FEB6B6DB64F5D FOREIGN KEY (chirurgien_id) REFERENCES chirurgien (id)');
        $this->addSql('ALTER TABLE liste_materiel ADD CONSTRAINT FK_40FEB6BB6C5A438 FOREIGN KEY (chirurgie_id) REFERENCES chirurgie (id)');
        $this->addSql('ALTER TABLE liste_materiel_materiel ADD CONSTRAINT FK_5B47E140FF6D643 FOREIGN KEY (liste_materiel_id) REFERENCES liste_materiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_materiel_materiel ADD CONSTRAINT FK_5B47E14016880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programme_operatoire ADD CONSTRAINT FK_FC39AF8AA0631C12 FOREIGN KEY (organiser_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE programme_operatoire ADD CONSTRAINT FK_FC39AF8A3580015B FOREIGN KEY (assumer_id) REFERENCES chirurgien (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chirurgie DROP FOREIGN KEY FK_EC562809FC7973B4');
        $this->addSql('ALTER TABLE chirurgie DROP FOREIGN KEY FK_EC5628096DB64F5D');
        $this->addSql('ALTER TABLE chirurgien DROP FOREIGN KEY FK_1384D5EFF548D04');
        $this->addSql('ALTER TABLE liste_materiel DROP FOREIGN KEY FK_40FEB6B6DB64F5D');
        $this->addSql('ALTER TABLE liste_materiel DROP FOREIGN KEY FK_40FEB6BB6C5A438');
        $this->addSql('ALTER TABLE liste_materiel_materiel DROP FOREIGN KEY FK_5B47E140FF6D643');
        $this->addSql('ALTER TABLE liste_materiel_materiel DROP FOREIGN KEY FK_5B47E14016880AAF');
        $this->addSql('ALTER TABLE programme_operatoire DROP FOREIGN KEY FK_FC39AF8AA0631C12');
        $this->addSql('ALTER TABLE programme_operatoire DROP FOREIGN KEY FK_FC39AF8A3580015B');
        $this->addSql('DROP TABLE chirurgie');
        $this->addSql('DROP TABLE chirurgien');
        $this->addSql('DROP TABLE liste_materiel');
        $this->addSql('DROP TABLE liste_materiel_materiel');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('DROP TABLE programme_operatoire');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
