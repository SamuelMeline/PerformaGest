<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240520123108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE important_info (id INT AUTO_INCREMENT NOT NULL, ant_medic LONGTEXT DEFAULT NULL, allergie LONGTEXT DEFAULT NULL, vaccins LONGTEXT DEFAULT NULL, tabac LONGTEXT DEFAULT NULL, alcool LONGTEXT DEFAULT NULL, stupefiants LONGTEXT DEFAULT NULL, sommeil LONGTEXT DEFAULT NULL, alimentation LONGTEXT DEFAULT NULL, activite_physique LONGTEXT DEFAULT NULL, employeur LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient ADD important_info_id INT DEFAULT NULL, DROP important_info');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB759C6F89 FOREIGN KEY (important_info_id) REFERENCES important_info (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EB759C6F89 ON patient (important_info_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB759C6F89');
        $this->addSql('DROP TABLE important_info');
        $this->addSql('DROP INDEX UNIQ_1ADAD7EB759C6F89 ON patient');
        $this->addSql('ALTER TABLE patient ADD important_info LONGTEXT DEFAULT NULL, DROP important_info_id');
    }
}
