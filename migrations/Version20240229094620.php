<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229094620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_address DROP FOREIGN KEY FK_FD4E1B4B67B3B43D');
        $this->addSql('ALTER TABLE users_address DROP FOREIGN KEY FK_FD4E1B4BF5B7AF75');
        $this->addSql('DROP TABLE users_address');
        $this->addSql('ALTER TABLE users ADD roles JSON NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_address (users_id INT NOT NULL, address_id INT NOT NULL, INDEX IDX_FD4E1B4B67B3B43D (users_id), INDEX IDX_FD4E1B4BF5B7AF75 (address_id), PRIMARY KEY(users_id, address_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE users_address ADD CONSTRAINT FK_FD4E1B4B67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_address ADD CONSTRAINT FK_FD4E1B4BF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users DROP roles');
    }
}
