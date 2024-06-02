<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240601190243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_category (products_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_CDFC73566C8A81A9 (products_id), INDEX IDX_CDFC7356A21214B7 (categories_id), PRIMARY KEY(products_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC73566C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC7356A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5AA21214B7');
        $this->addSql('DROP INDEX IDX_B3BA5A5AA21214B7 ON products');
        $this->addSql('ALTER TABLE products DROP categories_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC73566C8A81A9');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC7356A21214B7');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('ALTER TABLE products ADD categories_id INT NOT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5AA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5AA21214B7 ON products (categories_id)');
    }
}
