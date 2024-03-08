<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240308095645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address ADD is_primary TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE users ADD google_id VARCHAR(255) DEFAULT NULL, CHANGE date_of_birthday date_of_birthday DATE DEFAULT NULL, CHANGE phone_number phone_number VARCHAR(10) DEFAULT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP is_primary');
        $this->addSql('ALTER TABLE users DROP google_id, CHANGE date_of_birthday date_of_birthday DATE NOT NULL, CHANGE phone_number phone_number VARCHAR(10) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL');
    }
}
