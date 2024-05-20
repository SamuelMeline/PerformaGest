<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240520133707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE important_info DROP FOREIGN KEY FK_58FF9E36B899279');
        $this->addSql('DROP INDEX UNIQ_58FF9E36B899279 ON important_info');
        $this->addSql('ALTER TABLE important_info DROP patient_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE important_info ADD patient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE important_info ADD CONSTRAINT FK_58FF9E36B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_58FF9E36B899279 ON important_info (patient_id)');
    }
}
