<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250224140822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables structure for task 2.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE classification_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE classification_student_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE student_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE classification (id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE classification_student (id INT NOT NULL, student_id INT NOT NULL, classification_id INT DEFAULT NULL, grade NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_44702761CB944F1A ON classification_student (student_id)');
        $this->addSql('CREATE INDEX IDX_447027612A86559F ON classification_student (classification_id)');
        $this->addSql('CREATE TABLE student (id INT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE classification_student ADD CONSTRAINT FK_44702761CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE classification_student ADD CONSTRAINT FK_447027612A86559F FOREIGN KEY (classification_id) REFERENCES classification (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE classification_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE classification_student_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE student_id_seq CASCADE');
        $this->addSql('ALTER TABLE classification_student DROP CONSTRAINT FK_44702761CB944F1A');
        $this->addSql('ALTER TABLE classification_student DROP CONSTRAINT FK_447027612A86559F');
        $this->addSql('DROP TABLE classification');
        $this->addSql('DROP TABLE classification_student');
        $this->addSql('DROP TABLE student');
    }
}
