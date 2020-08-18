<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818064955 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE students CHANGE teacher_id teacher_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB241807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('CREATE INDEX IDX_A4698DB241807E1D ON students (teacher_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB241807E1D');
        $this->addSql('DROP INDEX IDX_A4698DB241807E1D ON students');
        $this->addSql('ALTER TABLE students CHANGE teacher_id teacher_id INT NOT NULL');
    }
}
