<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210227133124 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student ADD project_id_id INT NOT NULL, ADD group_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF336C1197C9 FOREIGN KEY (project_id_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF332F68B530 FOREIGN KEY (group_id_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_B723AF336C1197C9 ON student (project_id_id)');
        $this->addSql('CREATE INDEX IDX_B723AF332F68B530 ON student (group_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF336C1197C9');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF332F68B530');
        $this->addSql('DROP INDEX IDX_B723AF336C1197C9 ON student');
        $this->addSql('DROP INDEX IDX_B723AF332F68B530 ON student');
        $this->addSql('ALTER TABLE student DROP project_id_id, DROP group_id_id');
    }
}
