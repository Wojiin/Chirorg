<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251219095936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_materiel DROP FOREIGN KEY `FK_40FEB6B6DB64F5D`');
        $this->addSql('ALTER TABLE liste_materiel CHANGE chirurgien_id chirurgien_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liste_materiel ADD CONSTRAINT FK_40FEB6B6DB64F5D FOREIGN KEY (chirurgien_id) REFERENCES chirurgien (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_materiel DROP FOREIGN KEY FK_40FEB6B6DB64F5D');
        $this->addSql('ALTER TABLE liste_materiel CHANGE chirurgien_id chirurgien_id INT NOT NULL');
        $this->addSql('ALTER TABLE liste_materiel ADD CONSTRAINT `FK_40FEB6B6DB64F5D` FOREIGN KEY (chirurgien_id) REFERENCES chirurgien (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
