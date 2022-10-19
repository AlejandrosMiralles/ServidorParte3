<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221019070815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE compra_producto (compra_id INT NOT NULL, producto_id INT NOT NULL, INDEX IDX_C455FFD1F2E704D7 (compra_id), INDEX IDX_C455FFD17645698E (producto_id), PRIMARY KEY(compra_id, producto_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producto_old (isbn BIGINT AUTO_INCREMENT NOT NULL, precio INT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(isbn)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compra_producto ADD CONSTRAINT FK_C455FFD1F2E704D7 FOREIGN KEY (compra_id) REFERENCES compra (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE compra_producto ADD CONSTRAINT FK_C455FFD17645698E FOREIGN KEY (producto_id) REFERENCES producto (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compra_producto DROP FOREIGN KEY FK_C455FFD1F2E704D7');
        $this->addSql('ALTER TABLE compra_producto DROP FOREIGN KEY FK_C455FFD17645698E');
        $this->addSql('DROP TABLE compra_producto');
        $this->addSql('DROP TABLE producto_old');
    }
}
