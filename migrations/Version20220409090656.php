<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220409090656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT fk_f52993981ad5cdbf');
        $this->addSql('DROP INDEX idx_f52993981ad5cdbf');
        $this->addSql('ALTER TABLE "order" ADD size VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "order" DROP cart_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "order" ADD cart_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" DROP size');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT fk_f52993981ad5cdbf FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f52993981ad5cdbf ON "order" (cart_id)');
    }
}
