<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240520141826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB759C6F89');
        $this->addSql('DROP TABLE important_info');
        $this->addSql('DROP INDEX UNIQ_1ADAD7EB759C6F89 ON patient');
        $this->addSql('ALTER TABLE patient ADD ant_medic LONGTEXT DEFAULT NULL, ADD allergies LONGTEXT DEFAULT NULL, ADD vaccins LONGTEXT DEFAULT NULL, ADD tabac LONGTEXT DEFAULT NULL, ADD alcool LONGTEXT DEFAULT NULL, ADD stupefiants LONGTEXT DEFAULT NULL, ADD sommeil LONGTEXT DEFAULT NULL, ADD alimentation LONGTEXT DEFAULT NULL, ADD activite_physique LONGTEXT DEFAULT NULL, ADD employeur LONGTEXT DEFAULT NULL, DROP important_info_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE important_info (id INT AUTO_INCREMENT NOT NULL, ant_medic LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, allergies LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, vaccins LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, tabac LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, alcool LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, stupefiants LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, sommeil LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, alimentation LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, activite_physique LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, employeur LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE patient ADD important_info_id INT DEFAULT NULL, DROP ant_medic, DROP allergies, DROP vaccins, DROP tabac, DROP alcool, DROP stupefiants, DROP sommeil, DROP alimentation, DROP activite_physique, DROP employeur');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB759C6F89 FOREIGN KEY (important_info_id) REFERENCES important_info (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EB759C6F89 ON patient (important_info_id)');
    }
}
