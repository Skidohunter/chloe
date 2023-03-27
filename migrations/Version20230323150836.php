<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230323150836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formules (id INT AUTO_INCREMENT NOT NULL, relation_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, prix INT NOT NULL, INDEX IDX_E5BA88E13256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formules ADD CONSTRAINT FK_E5BA88E13256915B FOREIGN KEY (relation_id) REFERENCES prestations (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formules DROP FOREIGN KEY FK_E5BA88E13256915B');
        $this->addSql('DROP TABLE formules');
    }
}
