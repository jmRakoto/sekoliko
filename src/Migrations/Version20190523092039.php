<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190523092039 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sk_classe_ecolage ADD classe_ecolage INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sk_classe_ecolage ADD CONSTRAINT FK_13095C3685F8C02E FOREIGN KEY (classe_ecolage) REFERENCES sk_classe (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_13095C3685F8C02E ON sk_classe_ecolage (classe_ecolage)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sk_classe_ecolage DROP FOREIGN KEY FK_13095C3685F8C02E');
        $this->addSql('DROP INDEX IDX_13095C3685F8C02E ON sk_classe_ecolage');
        $this->addSql('ALTER TABLE sk_classe_ecolage DROP classe_ecolage');
    }
}
