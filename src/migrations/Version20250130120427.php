<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250130120427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE hospitalized_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE wards_procedures_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE hospitalized (id INT NOT NULL, patient_id INT NOT NULL, ward_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7E8E259E6B899279 ON hospitalized (patient_id)');
        $this->addSql('CREATE INDEX IDX_7E8E259ED95D22FD ON hospitalized (ward_id)');
        $this->addSql('CREATE TABLE wards_procedures (id INT NOT NULL, ward_id INT NOT NULL, procedure_id INT NOT NULL, sequence INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3D28B5C0D95D22FD ON wards_procedures (ward_id)');
        $this->addSql('CREATE INDEX IDX_3D28B5C01624BCD2 ON wards_procedures (procedure_id)');
        $this->addSql('CREATE UNIQUE INDEX unique_ward_procedure ON wards_procedures (ward_id, procedure_id)');
        $this->addSql('ALTER TABLE hospitalized ADD CONSTRAINT FK_7E8E259E6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hospitalized ADD CONSTRAINT FK_7E8E259ED95D22FD FOREIGN KEY (ward_id) REFERENCES ward (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wards_procedures ADD CONSTRAINT FK_3D28B5C0D95D22FD FOREIGN KEY (ward_id) REFERENCES ward (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wards_procedures ADD CONSTRAINT FK_3D28B5C01624BCD2 FOREIGN KEY (procedure_id) REFERENCES procedure (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE hospitalized_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE wards_procedures_id_seq CASCADE');
        $this->addSql('ALTER TABLE hospitalized DROP CONSTRAINT FK_7E8E259E6B899279');
        $this->addSql('ALTER TABLE hospitalized DROP CONSTRAINT FK_7E8E259ED95D22FD');
        $this->addSql('ALTER TABLE wards_procedures DROP CONSTRAINT FK_3D28B5C0D95D22FD');
        $this->addSql('ALTER TABLE wards_procedures DROP CONSTRAINT FK_3D28B5C01624BCD2');
        $this->addSql('DROP TABLE hospitalized');
        $this->addSql('DROP TABLE wards_procedures');
    }
}
