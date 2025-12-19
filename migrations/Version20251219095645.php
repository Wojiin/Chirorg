<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251219120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rend les relations critiques nullable et ON DELETE SET NULL';
    }

    public function up(Schema $schema): void
    {
        // Désactiver temporairement les FK
        $this->addSql('SET FOREIGN_KEY_CHECKS = 0');

        // Chirurgie.operer_id
        $this->addSql('ALTER TABLE chirurgie DROP FOREIGN KEY FK_EC5628095F0388CB');
        $this->addSql('ALTER TABLE chirurgie 
            MODIFY operer_id INT DEFAULT NULL, 
            ADD CONSTRAINT FK_EC5628095F0388CB FOREIGN KEY (operer_id) REFERENCES chirurgien(id) ON DELETE SET NULL');

        // Chirurgie.outiller_id
        $this->addSql('ALTER TABLE chirurgie DROP FOREIGN KEY FK_EC562809E0E4D13F');
        $this->addSql('ALTER TABLE chirurgie 
            MODIFY outiller_id INT DEFAULT NULL, 
            ADD CONSTRAINT FK_EC562809E0E4D13F FOREIGN KEY (outiller_id) REFERENCES liste_materiel(id) ON DELETE SET NULL');

        // Chirurgie.utilisateur_id
        $this->addSql('ALTER TABLE chirurgie DROP FOREIGN KEY FK_EC562809FB88E14F');
        $this->addSql('ALTER TABLE chirurgie 
            MODIFY utilisateur_id INT DEFAULT NULL, 
            ADD CONSTRAINT FK_EC562809FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE SET NULL');

        // Chirurgien.specialiser_id
        $this->addSql('ALTER TABLE chirurgien DROP FOREIGN KEY FK_1384D5EFF548D04');
        $this->addSql('ALTER TABLE chirurgien 
            MODIFY specialiser_id INT DEFAULT NULL, 
            ADD CONSTRAINT FK_1384D5EFF548D04 FOREIGN KEY (specialiser_id) REFERENCES specialite(id) ON DELETE SET NULL');

        // Materiel.classer_id
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY FK_18D2B091269E3C41');
        $this->addSql('ALTER TABLE materiel 
            MODIFY classer_id INT DEFAULT NULL, 
            ADD CONSTRAINT FK_18D2B091269E3C41 FOREIGN KEY (classer_id) REFERENCES specialite(id) ON DELETE SET NULL');

        // Réactiver les FK
        $this->addSql('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down(Schema $schema): void
    {
        // Optionnel : restaurer l’état précédent
        $this->addSql('SET FOREIGN_KEY_CHECKS = 0');

        // Chirurgie.operer_id
        $this->addSql('ALTER TABLE chirurgie DROP FOREIGN KEY FK_EC5628095F0388CB');
        $this->addSql('ALTER TABLE chirurgie 
            MODIFY operer_id INT NOT NULL, 
            ADD CONSTRAINT FK_EC5628095F0388CB FOREIGN KEY (operer_id) REFERENCES chirurgien(id)');

        // Chirurgie.outiller_id
        $this->addSql('ALTER TABLE chirurgie DROP FOREIGN KEY FK_EC562809E0E4D13F');
        $this->addSql('ALTER TABLE chirurgie 
            MODIFY outiller_id INT NOT NULL, 
            ADD CONSTRAINT FK_EC562809E0E4D13F FOREIGN KEY (outiller_id) REFERENCES liste_materiel(id)');

        // Chirurgie.utilisateur_id
        $this->addSql('ALTER TABLE chirurgie DROP FOREIGN KEY FK_EC562809FB88E14F');
        $this->addSql('ALTER TABLE chirurgie 
            MODIFY utilisateur_id INT NOT NULL, 
            ADD CONSTRAINT FK_EC562809FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id)');

        // Chirurgien.specialiser_id
        $this->addSql('ALTER TABLE chirurgien DROP FOREIGN KEY FK_1384D5EFF548D04');
        $this->addSql('ALTER TABLE chirurgien 
            MODIFY specialiser_id INT NOT NULL, 
            ADD CONSTRAINT FK_1384D5EFF548D04 FOREIGN KEY (specialiser_id) REFERENCES specialite(id)');

        // Materiel.classer_id
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY FK_18D2B091269E3C41');
        $this->addSql('ALTER TABLE materiel 
            MODIFY classer_id INT NOT NULL, 
            ADD CONSTRAINT FK_18D2B091269E3C41 FOREIGN KEY (classer_id) REFERENCES specialite(id)');

        $this->addSql('SET FOREIGN_KEY_CHECKS = 1');
    }
}
