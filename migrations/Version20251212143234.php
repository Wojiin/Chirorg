<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251212143234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materiel_chirurgie DROP FOREIGN KEY `FK_D7CE099616880AAF`');
        $this->addSql('ALTER TABLE materiel_chirurgie DROP FOREIGN KEY `FK_D7CE0996B6C5A438`');
        $this->addSql('DROP TABLE materiel_chirurgie');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE materiel_chirurgie (materiel_id INT NOT NULL, chirurgie_id INT NOT NULL, INDEX IDX_D7CE099616880AAF (materiel_id), INDEX IDX_D7CE0996B6C5A438 (chirurgie_id), PRIMARY KEY (materiel_id, chirurgie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE materiel_chirurgie ADD CONSTRAINT `FK_D7CE099616880AAF` FOREIGN KEY (materiel_id) REFERENCES materiel (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE materiel_chirurgie ADD CONSTRAINT `FK_D7CE0996B6C5A438` FOREIGN KEY (chirurgie_id) REFERENCES chirurgie (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
