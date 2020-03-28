<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200328153001 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE aggregated_rating');
        $this->addSql('ALTER TABLE game_list ADD user_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', ADD type INT NOT NULL');
        $this->addSql('ALTER TABLE game_list ADD CONSTRAINT FK_AFDD9434A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_AFDD9434A76ED395 ON game_list (user_id)');
        $this->addSql('ALTER TABLE game ADD rating DOUBLE PRECISION DEFAULT NULL, DROP time_to_beat_hastly, DROP time_to_beat_normally, CHANGE external_id external_id INT NOT NULL, CHANGE time_to_beat_completely rating_count INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game_mode ADD external_id INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7CDF2B879F75D7B0 ON game_mode (external_id)');
        $this->addSql('ALTER TABLE platform CHANGE external_id external_id INT NOT NULL');
        $this->addSql('ALTER TABLE screenshot CHANGE external_id external_id INT NOT NULL');
        $this->addSql('ALTER TABLE website CHANGE external_id external_id INT NOT NULL');
        $this->addSql('ALTER TABLE company CHANGE external_id external_id INT NOT NULL');
        $this->addSql('ALTER TABLE theme CHANGE external_id external_id INT NOT NULL');
        $this->addSql('ALTER TABLE genre CHANGE external_id external_id INT NOT NULL');
        $this->addSql('ALTER TABLE age_rating DROP name, CHANGE external_id external_id INT NOT NULL');
        $this->addSql('ALTER TABLE company_website CHANGE external_id external_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE aggregated_rating (id CHAR(36) NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:guid)\', game_id CHAR(36) DEFAULT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:guid)\', count INT NOT NULL, rating DOUBLE PRECISION NOT NULL, INDEX IDX_F447D1B6E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE aggregated_rating ADD CONSTRAINT FK_F447D1B6E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE age_rating ADD name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE external_id external_id VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE company CHANGE external_id external_id VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE company_website CHANGE external_id external_id VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE game ADD time_to_beat_hastly INT NOT NULL, ADD time_to_beat_normally INT NOT NULL, DROP rating, CHANGE external_id external_id VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE rating_count time_to_beat_completely INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game_list DROP FOREIGN KEY FK_AFDD9434A76ED395');
        $this->addSql('DROP INDEX IDX_AFDD9434A76ED395 ON game_list');
        $this->addSql('ALTER TABLE game_list DROP user_id, DROP type');
        $this->addSql('DROP INDEX UNIQ_7CDF2B879F75D7B0 ON game_mode');
        $this->addSql('ALTER TABLE game_mode DROP external_id');
        $this->addSql('ALTER TABLE genre CHANGE external_id external_id VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE platform CHANGE external_id external_id VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE screenshot CHANGE external_id external_id VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE theme CHANGE external_id external_id VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE website CHANGE external_id external_id VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
