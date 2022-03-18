<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317150150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE flashcard (id INT AUTO_INCREMENT NOT NULL, lesson_id INT DEFAULT NULL, question VARCHAR(255) DEFAULT NULL, answer VARCHAR(255) DEFAULT NULL, INDEX IDX_70511A09CDF80196 (lesson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, subject_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_F87474F323EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_FBCE3E7AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(64) DEFAULT NULL, roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE flashcard ADD CONSTRAINT FK_70511A09CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F323EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flashcard DROP FOREIGN KEY FK_70511A09CDF80196');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F323EDC87');
        $this->addSql('ALTER TABLE subject DROP FOREIGN KEY FK_FBCE3E7AA76ED395');
        $this->addSql('DROP TABLE flashcard');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE user');
    }
}
