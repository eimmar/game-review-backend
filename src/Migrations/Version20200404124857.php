<?php /** @noinspection PhpIllegalPsrClassPathInspection */

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200404124857 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE game_age_rating');
        $this->addSql('ALTER TABLE age_rating ADD game_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE age_rating ADD CONSTRAINT FK_C1705B55E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_C1705B55E48FD905 ON age_rating (game_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE game_age_rating (game_id CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:guid)\', age_rating_id CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:guid)\', INDEX IDX_2FAC9CB8E48FD905 (game_id), INDEX IDX_2FAC9CB857CDC09 (age_rating_id), PRIMARY KEY(game_id, age_rating_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE game_age_rating ADD CONSTRAINT FK_2FAC9CB857CDC09 FOREIGN KEY (age_rating_id) REFERENCES age_rating (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_age_rating ADD CONSTRAINT FK_2FAC9CB8E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE age_rating DROP FOREIGN KEY FK_C1705B55E48FD905');
        $this->addSql('DROP INDEX IDX_C1705B55E48FD905 ON age_rating');
        $this->addSql('ALTER TABLE age_rating DROP game_id');
    }
}
