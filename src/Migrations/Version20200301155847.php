<?php /** @noinspection PhpIllegalPsrClassPathInspection */

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200301155847 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE game (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', external_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, cover_image VARCHAR(255) NOT NULL, summary VARCHAR(255) NOT NULL, storyline VARCHAR(255) NOT NULL, release_date DATETIME DEFAULT NULL, category INT DEFAULT NULL, time_to_beat_completely INT DEFAULT NULL, time_to_beat_hastly INT NOT NULL, time_to_beat_normally INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_232B318C9F75D7B0 (external_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_age_rating (game_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', age_rating_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_2FAC9CB8E48FD905 (game_id), INDEX IDX_2FAC9CB857CDC09 (age_rating_id), PRIMARY KEY(game_id, age_rating_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_genre (game_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', genre_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_B1634A77E48FD905 (game_id), INDEX IDX_B1634A774296D31F (genre_id), PRIMARY KEY(game_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_theme (game_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', theme_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_A5469E87E48FD905 (game_id), INDEX IDX_A5469E8759027487 (theme_id), PRIMARY KEY(game_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_platform (game_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', platform_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_92162FEDE48FD905 (game_id), INDEX IDX_92162FEDFFE6496F (platform_id), PRIMARY KEY(game_id, platform_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_game_mode (game_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', game_mode_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_AE79EA85E48FD905 (game_id), INDEX IDX_AE79EA85E227FA65 (game_mode_id), PRIMARY KEY(game_id, game_mode_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_company (game_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', company_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_DA7D7660E48FD905 (game_id), INDEX IDX_DA7D7660979B1AD6 (company_id), PRIMARY KEY(game_id, company_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_game_list (game_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', game_list_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_7D7B5536E48FD905 (game_id), INDEX IDX_7D7B5536A86C69A4 (game_list_id), PRIMARY KEY(game_id, game_list_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', game_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', comment VARCHAR(255) NOT NULL, rating INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_794381C6E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_mode (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE platform (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', external_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, abbreviation VARCHAR(255) NOT NULL, summary VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, category INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_3952D0CB9F75D7B0 (external_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE screenshot (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', game_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', external_id VARCHAR(255) NOT NULL, image_id VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, height INT NOT NULL, width INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_58991E419F75D7B0 (external_id), INDEX IDX_58991E41E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE website (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', game_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', external_id VARCHAR(255) NOT NULL, trusted TINYINT(1) NOT NULL, url VARCHAR(255) NOT NULL, category INT NOT NULL, UNIQUE INDEX UNIQ_476F5DE79F75D7B0 (external_id), INDEX IDX_476F5DE7E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_website (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', company_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', external_id VARCHAR(255) NOT NULL, trusted TINYINT(1) NOT NULL, url VARCHAR(255) NOT NULL, category INT NOT NULL, UNIQUE INDEX UNIQ_673D47309F75D7B0 (external_id), INDEX IDX_673D4730979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', external_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, url VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_4FBF094F9F75D7B0 (external_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', external_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_9775E7089F75D7B0 (external_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE aggregated_rating (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', game_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', count INT NOT NULL, rating DOUBLE PRECISION NOT NULL, INDEX IDX_F447D1B6E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', external_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_835033F89F75D7B0 (external_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE age_rating (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', external_id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, synopsis VARCHAR(255) NOT NULL, category INT NOT NULL, rating INT NOT NULL, UNIQUE INDEX UNIQ_C1705B559F75D7B0 (external_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_list (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', privacy_type INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_age_rating ADD CONSTRAINT FK_2FAC9CB8E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_age_rating ADD CONSTRAINT FK_2FAC9CB857CDC09 FOREIGN KEY (age_rating_id) REFERENCES age_rating (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_genre ADD CONSTRAINT FK_B1634A77E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_genre ADD CONSTRAINT FK_B1634A774296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_theme ADD CONSTRAINT FK_A5469E87E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_theme ADD CONSTRAINT FK_A5469E8759027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_platform ADD CONSTRAINT FK_92162FEDE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_platform ADD CONSTRAINT FK_92162FEDFFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_game_mode ADD CONSTRAINT FK_AE79EA85E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_game_mode ADD CONSTRAINT FK_AE79EA85E227FA65 FOREIGN KEY (game_mode_id) REFERENCES game_mode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_company ADD CONSTRAINT FK_DA7D7660E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_company ADD CONSTRAINT FK_DA7D7660979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_game_list ADD CONSTRAINT FK_7D7B5536E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_game_list ADD CONSTRAINT FK_7D7B5536A86C69A4 FOREIGN KEY (game_list_id) REFERENCES game_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE screenshot ADD CONSTRAINT FK_58991E41E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE website ADD CONSTRAINT FK_476F5DE7E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE company_website ADD CONSTRAINT FK_673D4730979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE aggregated_rating ADD CONSTRAINT FK_F447D1B6E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game_age_rating DROP FOREIGN KEY FK_2FAC9CB8E48FD905');
        $this->addSql('ALTER TABLE game_genre DROP FOREIGN KEY FK_B1634A77E48FD905');
        $this->addSql('ALTER TABLE game_theme DROP FOREIGN KEY FK_A5469E87E48FD905');
        $this->addSql('ALTER TABLE game_platform DROP FOREIGN KEY FK_92162FEDE48FD905');
        $this->addSql('ALTER TABLE game_game_mode DROP FOREIGN KEY FK_AE79EA85E48FD905');
        $this->addSql('ALTER TABLE game_company DROP FOREIGN KEY FK_DA7D7660E48FD905');
        $this->addSql('ALTER TABLE game_game_list DROP FOREIGN KEY FK_7D7B5536E48FD905');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6E48FD905');
        $this->addSql('ALTER TABLE screenshot DROP FOREIGN KEY FK_58991E41E48FD905');
        $this->addSql('ALTER TABLE website DROP FOREIGN KEY FK_476F5DE7E48FD905');
        $this->addSql('ALTER TABLE aggregated_rating DROP FOREIGN KEY FK_F447D1B6E48FD905');
        $this->addSql('ALTER TABLE game_game_mode DROP FOREIGN KEY FK_AE79EA85E227FA65');
        $this->addSql('ALTER TABLE game_platform DROP FOREIGN KEY FK_92162FEDFFE6496F');
        $this->addSql('ALTER TABLE game_company DROP FOREIGN KEY FK_DA7D7660979B1AD6');
        $this->addSql('ALTER TABLE company_website DROP FOREIGN KEY FK_673D4730979B1AD6');
        $this->addSql('ALTER TABLE game_theme DROP FOREIGN KEY FK_A5469E8759027487');
        $this->addSql('ALTER TABLE game_genre DROP FOREIGN KEY FK_B1634A774296D31F');
        $this->addSql('ALTER TABLE game_age_rating DROP FOREIGN KEY FK_2FAC9CB857CDC09');
        $this->addSql('ALTER TABLE game_game_list DROP FOREIGN KEY FK_7D7B5536A86C69A4');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_age_rating');
        $this->addSql('DROP TABLE game_genre');
        $this->addSql('DROP TABLE game_theme');
        $this->addSql('DROP TABLE game_platform');
        $this->addSql('DROP TABLE game_game_mode');
        $this->addSql('DROP TABLE game_company');
        $this->addSql('DROP TABLE game_game_list');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE game_mode');
        $this->addSql('DROP TABLE platform');
        $this->addSql('DROP TABLE screenshot');
        $this->addSql('DROP TABLE website');
        $this->addSql('DROP TABLE company_website');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE aggregated_rating');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE age_rating');
        $this->addSql('DROP TABLE game_list');
    }
}
