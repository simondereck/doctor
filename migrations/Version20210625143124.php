<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210625143124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE herb ADD fr_price DOUBLE PRECISION DEFAULT NULL, ADD jing_price DOUBLE PRECISION DEFAULT NULL, ADD baicao_price DOUBLE PRECISION DEFAULT NULL, ADD cmc DOUBLE PRECISION DEFAULT NULL, ADD old_price DOUBLE PRECISION DEFAULT NULL, ADD new_price DOUBLE PRECISION DEFAULT NULL, ADD jiangying_price DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE herb DROP fr_price, DROP jing_price, DROP baicao_price, DROP cmc, DROP old_price, DROP new_price, DROP jiangying_price');
    }
}
