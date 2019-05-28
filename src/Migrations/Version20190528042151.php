<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190528042151 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trimestre CHANGE as_name as_name VARCHAR(100) DEFAULT NULL, CHANGE ets_nom ets_nom VARCHAR(100) DEFAULT NULL, CHANGE ets_addresse ets_addresse VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE professeur CHANGE as_name as_name VARCHAR(100) DEFAULT NULL, CHANGE ets_nom ets_nom VARCHAR(100) DEFAULT NULL, CHANGE ets_addresse ets_addresse VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE classe CHANGE as_name as_name VARCHAR(100) DEFAULT NULL, CHANGE ets_nom ets_nom VARCHAR(100) DEFAULT NULL, CHANGE ets_addresse ets_addresse VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE niveau CHANGE as_name as_name VARCHAR(100) DEFAULT NULL, CHANGE ets_nom ets_nom VARCHAR(100) DEFAULT NULL, CHANGE ets_addresse ets_addresse VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE personnel CHANGE as_name as_name VARCHAR(100) DEFAULT NULL, CHANGE ets_nom ets_nom VARCHAR(100) DEFAULT NULL, CHANGE ets_addresse ets_addresse VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE matiere CHANGE as_name as_name VARCHAR(100) DEFAULT NULL, CHANGE ets_nom ets_nom VARCHAR(100) DEFAULT NULL, CHANGE ets_addresse ets_addresse VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE etudiant CHANGE as_name as_name VARCHAR(100) DEFAULT NULL, CHANGE ets_nom ets_nom VARCHAR(100) DEFAULT NULL, CHANGE ets_addresse ets_addresse VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE classe_matiere CHANGE as_name as_name VARCHAR(100) DEFAULT NULL, CHANGE ets_nom ets_nom VARCHAR(100) DEFAULT NULL, CHANGE ets_addresse ets_addresse VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE as_name as_name VARCHAR(100) DEFAULT NULL, CHANGE ets_nom ets_nom VARCHAR(100) DEFAULT NULL, CHANGE ets_addresse ets_addresse VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE classe CHANGE as_name as_name VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_nom ets_nom VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_addresse ets_addresse VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE classe_matiere CHANGE as_name as_name VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_nom ets_nom VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_addresse ets_addresse VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE etudiant CHANGE as_name as_name VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_nom ets_nom VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_addresse ets_addresse VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE matiere CHANGE as_name as_name VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_nom ets_nom VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_addresse ets_addresse VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE niveau CHANGE as_name as_name VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_nom ets_nom VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_addresse ets_addresse VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE personnel CHANGE as_name as_name VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_nom ets_nom VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_addresse ets_addresse VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE professeur CHANGE as_name as_name VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_nom ets_nom VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_addresse ets_addresse VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE trimestre CHANGE as_name as_name VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_nom ets_nom VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_addresse ets_addresse VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE as_name as_name VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_nom ets_nom VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE ets_addresse ets_addresse VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
