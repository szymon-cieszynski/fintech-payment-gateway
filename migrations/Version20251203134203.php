<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251203134203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD business_data_nip VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client ADD personal_data_firstname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client ADD personal_data_surname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client DROP nip');
        $this->addSql('ALTER TABLE client DROP firstname');
        $this->addSql('ALTER TABLE client DROP surname');
        $this->addSql('ALTER TABLE client RENAME COLUMN name TO business_data_company_name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client ADD nip VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD firstname VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE client ADD surname VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE client DROP business_data_company_name');
        $this->addSql('ALTER TABLE client DROP business_data_nip');
        $this->addSql('ALTER TABLE client DROP personal_data_firstname');
        $this->addSql('ALTER TABLE client DROP personal_data_surname');
    }
}
