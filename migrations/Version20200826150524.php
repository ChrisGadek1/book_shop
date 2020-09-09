<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200826150524 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE99DED506');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEC83F1AF1');
        $this->addSql('DROP INDEX IDX_E52FFDEE99DED506 ON orders');
        $this->addSql('DROP INDEX UNIQ_E52FFDEEC83F1AF1 ON orders');
        $this->addSql('ALTER TABLE orders ADD id_client_id INT NOT NULL, ADD id_book_id INT NOT NULL, DROP id_client, DROP id_book');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE99DED506 FOREIGN KEY (id_client_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEC83F1AF1 FOREIGN KEY (id_book_id) REFERENCES books (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEE99DED506 ON orders (id_client_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E52FFDEEC83F1AF1 ON orders (id_book_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE99DED506');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEC83F1AF1');
        $this->addSql('DROP INDEX IDX_E52FFDEE99DED506 ON orders');
        $this->addSql('DROP INDEX UNIQ_E52FFDEEC83F1AF1 ON orders');
        $this->addSql('ALTER TABLE orders ADD id_client INT NOT NULL, ADD id_book INT NOT NULL, DROP id_client_id, DROP id_book_id');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE99DED506 FOREIGN KEY (id_client) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEC83F1AF1 FOREIGN KEY (id_book) REFERENCES books (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E52FFDEE99DED506 ON orders (id_client)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E52FFDEEC83F1AF1 ON orders (id_book)');
    }
}
