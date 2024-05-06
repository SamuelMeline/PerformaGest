<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506171345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patients ADD age VARCHAR(255) NOT NULL, ADD phone VARCHAR(255) NOT NULL, ADD contact_urgence VARCHAR(255) NOT NULL, ADD groupe_sanguin VARCHAR(255) NOT NULL, ADD taille VARCHAR(255) NOT NULL, ADD poids VARCHAR(255) NOT NULL, DROP description, DROP price, CHANGE image firstname VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patients ADD description LONGTEXT NOT NULL, ADD image VARCHAR(255) NOT NULL, ADD price DOUBLE PRECISION NOT NULL, DROP firstname, DROP age, DROP phone, DROP contact_urgence, DROP groupe_sanguin, DROP taille, DROP poids');
    }
}
