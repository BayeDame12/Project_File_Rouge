<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707114737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande CHANGE numero_commande numero_commande INT DEFAULT NULL, CHANGE statut_commande statut_commande TINYINT(1) DEFAULT NULL, CHANGE paiement paiement INT DEFAULT NULL, CHANGE numero_ticket numero_ticket INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande CHANGE numero_commande numero_commande INT NOT NULL, CHANGE statut_commande statut_commande TINYINT(1) NOT NULL, CHANGE paiement paiement INT NOT NULL, CHANGE numero_ticket numero_ticket INT NOT NULL');
    }
}
