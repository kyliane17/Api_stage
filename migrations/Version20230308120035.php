<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308120035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE intership (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, idstudent_id INTEGER NOT NULL, idcompagnies_id INTEGER NOT NULL, startdate DATE NOT NULL, endate DATE NOT NULL, CONSTRAINT FK_CBD07C9E63D5220 FOREIGN KEY (idstudent_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CBD07C9E2604F415 FOREIGN KEY (idcompagnies_id) REFERENCES compagnies (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_CBD07C9E63D5220 ON intership (idstudent_id)');
        $this->addSql('CREATE INDEX IDX_CBD07C9E2604F415 ON intership (idcompagnies_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE intership');
    }
}
