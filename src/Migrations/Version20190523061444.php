<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190523061444 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sk_classe_ecolage (id INT AUTO_INCREMENT NOT NULL, mois VARCHAR(100) NOT NULL, montant VARCHAR(100) NOT NULL, as_name VARCHAR(100) DEFAULT NULL, anne_scolaire_debut DATETIME DEFAULT NULL, anne_scolaire_fin DATETIME DEFAULT NULL, ets_nom VARCHAR(100) DEFAULT NULL, ets_adresse LONGTEXT DEFAULT NULL, ets_responsable VARCHAR(100) DEFAULT NULL, ets_phone VARCHAR(100) DEFAULT NULL, ets_email VARCHAR(150) DEFAULT NULL, ets_logo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sk_classe_ecolage');
    }
}
