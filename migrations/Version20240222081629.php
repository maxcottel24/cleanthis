<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222081629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE addresses (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, zipcode VARCHAR(6) NOT NULL, city VARCHAR(100) NOT NULL, street VARCHAR(200) NOT NULL, INDEX IDX_6FCA7516A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE appointements (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, employee_id INT DEFAULT NULL, description LONGTEXT NOT NULL, date_appointement DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_FE66E897F5B7AF75 (address_id), INDEX IDX_FE66E8979395C3F3 (customer_id), INDEX IDX_FE66E8978C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_81398E09A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, superior INT NOT NULL, INDEX IDX_5D9F75A1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, identification VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_customer (images_id INT NOT NULL, customer_id INT NOT NULL, INDEX IDX_221AF363D44F05E5 (images_id), INDEX IDX_221AF3639395C3F3 (customer_id), PRIMARY KEY(images_id, customer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoices (id INT AUTO_INCREMENT NOT NULL, operation_id INT DEFAULT NULL, status VARCHAR(50) NOT NULL, amount NUMERIC(10, 2) NOT NULL, date_emission DATE NOT NULL, due_date DATE NOT NULL, pdf_content VARCHAR(255) DEFAULT NULL, payment_method VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_6A2F2F9544AC3583 (operation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operations (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, appointement_id INT DEFAULT NULL, status INT NOT NULL, is_valid TINYINT(1) NOT NULL, discount NUMERIC(10, 2) DEFAULT NULL, final_price INT DEFAULT NULL, INDEX IDX_28145348C54C8C93 (type_id), INDEX IDX_281453481EBF5025 (appointement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operations_employee (operations_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_B5D25A7D9384C38A (operations_id), INDEX IDX_B5D25A7D8C03F15C (employee_id), PRIMARY KEY(operations_id, employee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_operation (id INT AUTO_INCREMENT NOT NULL, wording VARCHAR(200) NOT NULL, price NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, birthday DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', phone_number VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA7516A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE appointements ADD CONSTRAINT FK_FE66E897F5B7AF75 FOREIGN KEY (address_id) REFERENCES addresses (id)');
        $this->addSql('ALTER TABLE appointements ADD CONSTRAINT FK_FE66E8979395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE appointements ADD CONSTRAINT FK_FE66E8978C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE images_customer ADD CONSTRAINT FK_221AF363D44F05E5 FOREIGN KEY (images_id) REFERENCES images (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images_customer ADD CONSTRAINT FK_221AF3639395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE invoices ADD CONSTRAINT FK_6A2F2F9544AC3583 FOREIGN KEY (operation_id) REFERENCES operations (id)');
        $this->addSql('ALTER TABLE operations ADD CONSTRAINT FK_28145348C54C8C93 FOREIGN KEY (type_id) REFERENCES type_operation (id)');
        $this->addSql('ALTER TABLE operations ADD CONSTRAINT FK_281453481EBF5025 FOREIGN KEY (appointement_id) REFERENCES appointements (id)');
        $this->addSql('ALTER TABLE operations_employee ADD CONSTRAINT FK_B5D25A7D9384C38A FOREIGN KEY (operations_id) REFERENCES operations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE operations_employee ADD CONSTRAINT FK_B5D25A7D8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA7516A76ED395');
        $this->addSql('ALTER TABLE appointements DROP FOREIGN KEY FK_FE66E897F5B7AF75');
        $this->addSql('ALTER TABLE appointements DROP FOREIGN KEY FK_FE66E8979395C3F3');
        $this->addSql('ALTER TABLE appointements DROP FOREIGN KEY FK_FE66E8978C03F15C');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09A76ED395');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1A76ED395');
        $this->addSql('ALTER TABLE images_customer DROP FOREIGN KEY FK_221AF363D44F05E5');
        $this->addSql('ALTER TABLE images_customer DROP FOREIGN KEY FK_221AF3639395C3F3');
        $this->addSql('ALTER TABLE invoices DROP FOREIGN KEY FK_6A2F2F9544AC3583');
        $this->addSql('ALTER TABLE operations DROP FOREIGN KEY FK_28145348C54C8C93');
        $this->addSql('ALTER TABLE operations DROP FOREIGN KEY FK_281453481EBF5025');
        $this->addSql('ALTER TABLE operations_employee DROP FOREIGN KEY FK_B5D25A7D9384C38A');
        $this->addSql('ALTER TABLE operations_employee DROP FOREIGN KEY FK_B5D25A7D8C03F15C');
        $this->addSql('DROP TABLE addresses');
        $this->addSql('DROP TABLE appointements');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE images_customer');
        $this->addSql('DROP TABLE invoices');
        $this->addSql('DROP TABLE operations');
        $this->addSql('DROP TABLE operations_employee');
        $this->addSql('DROP TABLE type_operation');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
