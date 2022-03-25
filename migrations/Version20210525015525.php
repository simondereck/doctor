<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210525015525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE herb (id INT AUTO_INCREMENT NOT NULL, fid INT DEFAULT NULL, tid INT DEFAULT NULL, cmd VARCHAR(255) DEFAULT NULL, hmethod LONGTEXT DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, cc VARCHAR(255) DEFAULT NULL, series VARCHAR(255) DEFAULT NULL, sub_series VARCHAR(255) DEFAULT NULL, pinyin VARCHAR(255) DEFAULT NULL, latin_name VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, real_pinyin VARCHAR(255) DEFAULT NULL, real_latin VARCHAR(255) DEFAULT NULL, membrum VARCHAR(255) DEFAULT NULL, membrum_sub VARCHAR(255) DEFAULT NULL, real_name VARCHAR(255) DEFAULT NULL, fp VARCHAR(255) DEFAULT NULL, france_name VARCHAR(255) DEFAULT NULL, package_france_name VARCHAR(255) DEFAULT NULL, latin_label_name VARCHAR(255) DEFAULT NULL, latin_ftc_name VARCHAR(255) DEFAULT NULL, law LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, utime VARCHAR(255) NOT NULL, ctime VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE herb');
    }
}
