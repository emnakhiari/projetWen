<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230504113241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire CHANGE commentaire commentaire VARCHAR(65535) DEFAULT NULL');
        $this->addSql('DROP INDEX AFavoris ON favoris');
        $this->addSql('CREATE INDEX AFavoris ON favoris (Fimage)');
        $this->addSql('ALTER TABLE user CHANGE image image VARCHAR(65535) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire CHANGE commentaire commentaire MEDIUMTEXT DEFAULT NULL');
        $this->addSql('DROP INDEX AFavoris ON favoris');
        $this->addSql('CREATE INDEX AFavoris ON favoris (Fimage(768))');
        $this->addSql('ALTER TABLE user CHANGE image image MEDIUMTEXT DEFAULT NULL');
    }
}
