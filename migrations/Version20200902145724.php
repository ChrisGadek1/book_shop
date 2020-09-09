<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200902145724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE opinions ADD book_id INT NOT NULL');
        $this->addSql('ALTER TABLE opinions ADD CONSTRAINT FK_BEAF78D016A2B381 FOREIGN KEY (book_id) REFERENCES books (id)');
        $this->addSql('CREATE INDEX IDX_BEAF78D016A2B381 ON opinions (book_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE opinions DROP FOREIGN KEY FK_BEAF78D016A2B381');
        $this->addSql('DROP INDEX IDX_BEAF78D016A2B381 ON opinions');
        $this->addSql('ALTER TABLE opinions DROP book_id');
    }
}
