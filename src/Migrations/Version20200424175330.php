<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200424175330 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game_game_list DROP FOREIGN KEY FK_7D7B5536A86C69A4');
        $this->addSql('ALTER TABLE game_game_list DROP FOREIGN KEY FK_7D7B5536E48FD905');
        $this->addSql('ALTER TABLE game_game_list DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE game_game_list ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE game_game_list ADD CONSTRAINT FK_7D7B5536A86C69A4 FOREIGN KEY (game_list_id) REFERENCES game_list (id)');
        $this->addSql('ALTER TABLE game_game_list ADD CONSTRAINT FK_7D7B5536E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game_game_list ADD PRIMARY KEY (game_list_id, game_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game_game_list DROP FOREIGN KEY FK_7D7B5536A86C69A4');
        $this->addSql('ALTER TABLE game_game_list DROP FOREIGN KEY FK_7D7B5536E48FD905');
        $this->addSql('ALTER TABLE game_game_list DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE game_game_list DROP created_at');
        $this->addSql('ALTER TABLE game_game_list ADD CONSTRAINT FK_7D7B5536A86C69A4 FOREIGN KEY (game_list_id) REFERENCES game_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_game_list ADD CONSTRAINT FK_7D7B5536E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_game_list ADD PRIMARY KEY (game_id, game_list_id)');
    }
}
