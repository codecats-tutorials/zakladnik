<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140223105443 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Bookmark ADD author_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE Bookmark ADD CONSTRAINT FK_2314F04BF675F31B FOREIGN KEY (author_id) REFERENCES User (id)");
        $this->addSql("CREATE INDEX IDX_2314F04BF675F31B ON Bookmark (author_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Bookmark DROP FOREIGN KEY FK_2314F04BF675F31B");
        $this->addSql("DROP INDEX IDX_2314F04BF675F31B ON Bookmark");
        $this->addSql("ALTER TABLE Bookmark DROP author_id");
    }
}
