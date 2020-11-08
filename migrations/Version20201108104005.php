<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201108104005 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE joueur ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tournois ADD slug VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe DROP slug');
        $this->addSql('ALTER TABLE joueur DROP slug');
        $this->addSql('ALTER TABLE tournois DROP slug');
    }
}
