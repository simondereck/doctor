<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210528174130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medical (id INT AUTO_INCREMENT NOT NULL, type INT NOT NULL, series VARCHAR(255) DEFAULT NULL, use_as VARCHAR(255) DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, cc VARCHAR(255) DEFAULT NULL, tid INT DEFAULT NULL, declare_no VARCHAR(255) DEFAULT NULL, sku VARCHAR(255) DEFAULT NULL, ean VARCHAR(255) DEFAULT NULL, price_internal DOUBLE PRECISION DEFAULT NULL, price_cp DOUBLE PRECISION DEFAULT NULL, price_gl VARCHAR(255) DEFAULT NULL, price_shop DOUBLE PRECISION DEFAULT NULL, price_inter_gl DOUBLE PRECISION DEFAULT NULL, price_inter_cp DOUBLE PRECISION DEFAULT NULL, shop INT NOT NULL, pinyin_real VARCHAR(255) DEFAULT NULL, pinyin VARCHAR(255) DEFAULT NULL, chinese VARCHAR(255) DEFAULT NULL, formula LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, utime VARCHAR(255) NOT NULL, ctime VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE medical');
    }
}
