<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220814125048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64967B3B43D');
        $this->addSql('DROP INDEX UNIQ_8D93D64967B3B43D ON user');
        $this->addSql('ALTER TABLE user CHANGE users_id user_bar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496DC83E07 FOREIGN KEY (user_bar_id) REFERENCES bar (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6496DC83E07 ON user (user_bar_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496DC83E07');
        $this->addSql('DROP INDEX UNIQ_8D93D6496DC83E07 ON user');
        $this->addSql('ALTER TABLE user CHANGE user_bar_id users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64967B3B43D FOREIGN KEY (users_id) REFERENCES bar (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64967B3B43D ON user (users_id)');
    }
}
