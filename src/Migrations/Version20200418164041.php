<?php /** @noinspection PhpIllegalPsrClassPathInspection */

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200418164041 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE game_mode ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE platform ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE theme ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE genre ADD slug VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game DROP slug');
        $this->addSql('ALTER TABLE game_mode DROP slug');
        $this->addSql('ALTER TABLE genre DROP slug');
        $this->addSql('ALTER TABLE platform DROP slug');
        $this->addSql('ALTER TABLE theme DROP slug');
    }
}
