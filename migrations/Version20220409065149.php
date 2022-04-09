<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220409065149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE cart_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cloth_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE image_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE model_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE order_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cart (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cloth (id INT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE image (id INT NOT NULL, model_id INT NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_original_name VARCHAR(255) DEFAULT NULL, image_mime_type VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, image_dimensions TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C53D045F7975B7E7 ON image (model_id)');
        $this->addSql('COMMENT ON COLUMN image.image_dimensions IS \'(DC2Type:simple_array)\'');
        $this->addSql('CREATE TABLE model (id INT NOT NULL, name VARCHAR(255) NOT NULL, sku VARCHAR(255) DEFAULT \'\' NOT NULL, description TEXT DEFAULT NULL, sizes TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN model.sizes IS \'(DC2Type:simple_array)\'');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, cart_id INT NOT NULL, model_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F52993981AD5CDBF ON "order" (cart_id)');
        $this->addSql('CREATE INDEX IDX_F52993987975B7E7 ON "order" (model_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F52993981AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F52993987975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F52993981AD5CDBF');
        $this->addSql('ALTER TABLE image DROP CONSTRAINT FK_C53D045F7975B7E7');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F52993987975B7E7');
        $this->addSql('DROP SEQUENCE cart_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cloth_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE image_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE model_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE order_id_seq CASCADE');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cloth');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
