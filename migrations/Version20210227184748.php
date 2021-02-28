<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210227184748 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student ADD project_id INT NOT NULL, ADD project_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33C31A529C FOREIGN KEY (project_group_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_B723AF33166D1F9C ON student (project_id)');
        $this->addSql('CREATE INDEX IDX_B723AF33C31A529C ON student (project_group_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33166D1F9C');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33C31A529C');
        $this->addSql('DROP INDEX IDX_B723AF33166D1F9C ON student');
        $this->addSql('DROP INDEX IDX_B723AF33C31A529C ON student');
        $this->addSql('ALTER TABLE student DROP project_id, DROP project_group_id');
    }
}
