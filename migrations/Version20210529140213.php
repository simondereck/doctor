<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210529140213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE single (id INT AUTO_INCREMENT NOT NULL, type INT NOT NULL, series VARCHAR(255) DEFAULT NULL, sub_series VARCHAR(255) NOT NULL, category VARCHAR(255) DEFAULT NULL, cc VARCHAR(255) DEFAULT NULL, tid VARCHAR(255) DEFAULT NULL, declare_no VARCHAR(255) DEFAULT NULL, sku VARCHAR(255) DEFAULT NULL, ean VARCHAR(255) DEFAULT NULL, lot VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, latin VARCHAR(255) DEFAULT NULL, pinyin VARCHAR(255) DEFAULT NULL, etiquette VARCHAR(255) DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, use_as LONGTEXT DEFAULT NULL, shop VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, utime VARCHAR(255) NOT NULL, ctime VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE single');
    }
}
