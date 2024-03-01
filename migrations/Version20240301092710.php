<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240301092710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, zipcode VARCHAR(6) NOT NULL, city VARCHAR(50) NOT NULL, street VARCHAR(255) NOT NULL, INDEX IDX_D4E6F81A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE belong (id INT AUTO_INCREMENT NOT NULL, invoice_id INT DEFAULT NULL, operation_id INT DEFAULT NULL, created_at DATE NOT NULL, UNIQUE INDEX UNIQ_BFFF81BB2989F1FD (invoice_id), UNIQUE INDEX UNIQ_BFFF81BB44AC3583 (operation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, amount DOUBLE PRECISION NOT NULL, closing_at DATE DEFAULT NULL, payment_method VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meeting (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, reserved_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', description LONGTEXT NOT NULL, INDEX IDX_F515E139F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, meeting_id INT DEFAULT NULL, type_operation_id INT DEFAULT NULL, status INT NOT NULL, is_valid TINYINT(1) NOT NULL, price DOUBLE PRECISION NOT NULL, discount DOUBLE PRECISION DEFAULT NULL, finished_at DATE NOT NULL, description LONGTEXT NOT NULL, floor_space NUMERIC(15, 2) NOT NULL, INDEX IDX_1981A66D67433D9C (meeting_id), INDEX IDX_1981A66DC3EF8F86 (type_operation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_operation (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(100) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', lastname VARCHAR(255) NOT NULL, date_of_birthday DATE NOT NULL, phone_number VARCHAR(10) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, job_title VARCHAR(255) DEFAULT NULL, unit INT DEFAULT NULL, serial_worker INT DEFAULT NULL, surpervisor INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_meeting (users_id INT NOT NULL, meeting_id INT NOT NULL, INDEX IDX_51595F367B3B43D (users_id), INDEX IDX_51595F367433D9C (meeting_id), PRIMARY KEY(users_id, meeting_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE belong ADD CONSTRAINT FK_BFFF81BB2989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('ALTER TABLE belong ADD CONSTRAINT FK_BFFF81BB44AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E139F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D67433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DC3EF8F86 FOREIGN KEY (type_operation_id) REFERENCES type_operation (id)');
        $this->addSql('ALTER TABLE users_meeting ADD CONSTRAINT FK_51595F367B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_meeting ADD CONSTRAINT FK_51595F367433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81A76ED395');
        $this->addSql('ALTER TABLE belong DROP FOREIGN KEY FK_BFFF81BB2989F1FD');
        $this->addSql('ALTER TABLE belong DROP FOREIGN KEY FK_BFFF81BB44AC3583');
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E139F5B7AF75');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D67433D9C');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66DC3EF8F86');
        $this->addSql('ALTER TABLE users_meeting DROP FOREIGN KEY FK_51595F367B3B43D');
        $this->addSql('ALTER TABLE users_meeting DROP FOREIGN KEY FK_51595F367433D9C');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE belong');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE meeting');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE type_operation');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_meeting');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
