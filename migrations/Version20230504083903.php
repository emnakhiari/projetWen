<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230504083903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id_avis INT AUTO_INCREMENT NOT NULL, etoile VARCHAR(20) NOT NULL, raison VARCHAR(20) NOT NULL, PRIMARY KEY(id_avis)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id_commande INT AUTO_INCREMENT NOT NULL, id_utilisateur INT NOT NULL, id_produit INT NOT NULL, date DATE NOT NULL, role VARCHAR(50) DEFAULT \'NULL\', status INT DEFAULT NULL, id_livreur INT DEFAULT NULL, id_utilisateurA INT DEFAULT NULL, date_livraison DATE NOT NULL, date_confirmation DATE NOT NULL, PRIMARY KEY(id_commande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE echange (idEchange INT AUTO_INCREMENT NOT NULL, role VARCHAR(20) NOT NULL, rating VARCHAR(20) NOT NULL, date DATE NOT NULL, idOperation INT NOT NULL, IdUtilisateur INT DEFAULT NULL, INDEX user (IdUtilisateur), PRIMARY KEY(idEchange)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id_facture INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, date_facturation DATE NOT NULL, commission DOUBLE PRECISION NOT NULL, statut VARCHAR(20) NOT NULL, INDEX IDX_FE86641082EA2E54 (commande_id), PRIMARY KEY(id_facture)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris (FIdProduit INT AUTO_INCREMENT NOT NULL, Fimage TEXT DEFAULT \'NULL\', Furl TEXT NOT NULL, Fdescription TEXT NOT NULL, Ftitre VARCHAR(30) NOT NULL, Fcategorie VARCHAR(30) NOT NULL, Fprix INT NOT NULL, Flikes INT DEFAULT NULL, Id_utilisateur INT NOT NULL, INDEX AFavoris (Fimage), PRIMARY KEY(FIdProduit)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_facture (id INT AUTO_INCREMENT NOT NULL, id_facture INT NOT NULL, prix_initial DOUBLE PRECISION NOT NULL, prix_vente DOUBLE PRECISION DEFAULT \'0\' NOT NULL, prix_livraison DOUBLE PRECISION NOT NULL, prix_total DOUBLE PRECISION NOT NULL, revenu DOUBLE PRECISION NOT NULL, INDEX IDX_611F5A29201BCD60 (id_facture), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livreur (id_livreur INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, num VARCHAR(20) NOT NULL, PRIMARY KEY(id_livreur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (idMessage INT AUTO_INCREMENT NOT NULL, message TEXT NOT NULL, date DATE NOT NULL, Id_utilisateur INT DEFAULT NULL, INDEX addMessage (Id_utilisateur), PRIMARY KEY(idMessage)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, Contenu VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, image TEXT DEFAULT \'NULL\', description TEXT NOT NULL, titre VARCHAR(30) NOT NULL, categorie VARCHAR(20) NOT NULL, prix INT NOT NULL, id_utilisateur VARCHAR(10) NOT NULL, INDEX ssss (Id_utilisateur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo (idPromo INT AUTO_INCREMENT NOT NULL, titre VARCHAR(30) NOT NULL, description TEXT NOT NULL, pourcentage INT NOT NULL, prix DOUBLE PRECISION NOT NULL, date_deb DATE NOT NULL, date_fin DATE NOT NULL, promoPrix INT NOT NULL, PRIMARY KEY(idPromo)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rdv (idRDV INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, heure VARCHAR(20) NOT NULL, PRIMARY KEY(idRDV)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE saved (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(20) NOT NULL, description VARCHAR(20) NOT NULL, titre VARCHAR(20) NOT NULL, categorie VARCHAR(20) NOT NULL, prix INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id_utilisateur INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, ConfirmerPassword VARCHAR(8) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', image VARCHAR(65535) DEFAULT NULL, type VARCHAR(20) DEFAULT NULL, nombreproduitachetes INT DEFAULT NULL, nombreproduitpublier INT DEFAULT NULL, nombreProduitVendus INT DEFAULT NULL, reset_token VARCHAR(100) DEFAULT NULL, avis VARCHAR(20) DEFAULT NULL, adresse VARCHAR(500) NOT NULL, numero VARCHAR(500) NOT NULL, PRIMARY KEY(id_utilisateur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (Id_utilisateur INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, numero VARCHAR(50) NOT NULL, Adresse VARCHAR(500) NOT NULL, motDepasse VARCHAR(8) NOT NULL, AdresseEmail VARCHAR(500) NOT NULL, Image TEXT NOT NULL, Type VARCHAR(20) NOT NULL, nombreProduitAchetes INT DEFAULT NULL, nombreProduitPublier INT DEFAULT NULL, nombreProduitVendus INT DEFAULT NULL, avis INT DEFAULT NULL, role VARCHAR(20) NOT NULL, PRIMARY KEY(Id_utilisateur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE echange ADD CONSTRAINT FK_B577E3BFEE3FD73E FOREIGN KEY (IdUtilisateur) REFERENCES utilisateur (Id_utilisateur)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641082EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id_commande)');
        $this->addSql('ALTER TABLE ligne_facture ADD CONSTRAINT FK_611F5A29201BCD60 FOREIGN KEY (id_facture) REFERENCES facture (id_facture)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FC86AD69C FOREIGN KEY (Id_utilisateur) REFERENCES utilisateur (Id_utilisateur)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE echange DROP FOREIGN KEY FK_B577E3BFEE3FD73E');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641082EA2E54');
        $this->addSql('ALTER TABLE ligne_facture DROP FOREIGN KEY FK_611F5A29201BCD60');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FC86AD69C');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE echange');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE ligne_facture');
        $this->addSql('DROP TABLE livreur');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE promo');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('DROP TABLE saved');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
