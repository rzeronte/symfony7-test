<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423155518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, tax_rate VARCHAR(255) NOT NULL, price_with_tax VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN product.id IS \'(DC2Type:id)\'');
        $this->addSql('COMMENT ON COLUMN product.price IS \'(DC2Type:price)\'');
        $this->addSql('COMMENT ON COLUMN product.tax_rate IS \'(DC2Type:price)\'');
        $this->addSql('COMMENT ON COLUMN product.price_with_tax IS \'(DC2Type:price)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE product');
    }
}
