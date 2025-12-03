<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251203135012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ALTER business_data_company_name DROP NOT NULL');
        $this->addSql('ALTER TABLE client ALTER business_data_nip DROP NOT NULL');
        $this->addSql('ALTER TABLE client ALTER personal_data_firstname DROP NOT NULL');
        $this->addSql('ALTER TABLE client ALTER personal_data_surname DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ALTER business_data_company_name SET NOT NULL');
        $this->addSql('ALTER TABLE client ALTER business_data_nip SET NOT NULL');
        $this->addSql('ALTER TABLE client ALTER personal_data_firstname SET NOT NULL');
        $this->addSql('ALTER TABLE client ALTER personal_data_surname SET NOT NULL');
    }
}
