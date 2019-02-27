<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190226150121 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, login VARCHAR(128) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(128) NOT NULL, phone VARCHAR(15) NOT NULL, skype VARCHAR(128) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, removed_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_car (user_id INT NOT NULL, car_id INT NOT NULL, INDEX IDX_9C2B8716A76ED395 (user_id), INDEX IDX_9C2B8716C3C6F69F (car_id), PRIMARY KEY(user_id, car_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, model VARCHAR(128) NOT NULL, number_plate VARCHAR(10) NOT NULL, color VARCHAR(7) DEFAULT NULL, year SMALLINT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, removed_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_car ADD CONSTRAINT FK_9C2B8716A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_car ADD CONSTRAINT FK_9C2B8716C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_car DROP FOREIGN KEY FK_9C2B8716A76ED395');
        $this->addSql('ALTER TABLE user_car DROP FOREIGN KEY FK_9C2B8716C3C6F69F');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_car');
        $this->addSql('DROP TABLE car');
    }
}
