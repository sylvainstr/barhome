<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220812082240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE drink (id INT AUTO_INCREMENT NOT NULL, drinks_id INT DEFAULT NULL, category VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, year INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, INDEX IDX_DBE40D12B4B60FB (drinks_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE drink ADD CONSTRAINT FK_DBE40D12B4B60FB FOREIGN KEY (drinks_id) REFERENCES bar (id)');
        $this->addSql('ALTER TABLE bar DROP category, DROP year, DROP type');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE drink DROP FOREIGN KEY FK_DBE40D12B4B60FB');
        $this->addSql('DROP TABLE drink');
        $this->addSql('ALTER TABLE bar ADD category VARCHAR(255) NOT NULL, ADD year INT DEFAULT NULL, ADD type VARCHAR(255) DEFAULT NULL');
    }
}
