<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505105337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE signaler (id INT AUTO_INCREMENT NOT NULL, commentaire_id INT DEFAULT NULL, user_action INT NOT NULL, user_prop INT NOT NULL, cause VARCHAR(255) NOT NULL, INDEX IDX_EF69B32BA9CD190 (commentaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire CHANGE commentaire commentaire VARCHAR(65535) DEFAULT NULL');
        $this->addSql('DROP INDEX AFavoris ON favoris');
        $this->addSql('CREATE INDEX AFavoris ON favoris (Fimage)');
        $this->addSql('ALTER TABLE user CHANGE image image VARCHAR(65535) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
      //  $this->addSql('CREATE TABLE signaler (id INT AUTO_INCREMENT NOT NULL, commentaire_id INT DEFAULT NULL, user_action INT NOT NULL, user_prop INT NOT NULL, cause VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_EF69B32BA9CD190 (commentaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commentaire CHANGE commentaire commentaire MEDIUMTEXT DEFAULT NULL');
        $this->addSql('DROP INDEX AFavoris ON favoris');
        $this->addSql('CREATE INDEX AFavoris ON favoris (Fimage(768))');
        $this->addSql('ALTER TABLE user CHANGE image image MEDIUMTEXT DEFAULT NULL');
    }
}
