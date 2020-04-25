<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200425143306 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE friendship DROP FOREIGN KEY FK_7234A45F6A5458E8');
        $this->addSql('ALTER TABLE friendship DROP FOREIGN KEY FK_7234A45FA76ED395');
        $this->addSql('DROP INDEX IDX_7234A45F6A5458E8 ON friendship');
        $this->addSql('DROP INDEX IDX_7234A45FA76ED395 ON friendship');
        $this->addSql('ALTER TABLE friendship DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE friendship ADD sender_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ADD receiver_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', DROP user_id, DROP friend_id');
        $this->addSql('ALTER TABLE friendship ADD CONSTRAINT FK_7234A45FF624B39D FOREIGN KEY (sender_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE friendship ADD CONSTRAINT FK_7234A45FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_7234A45FF624B39D ON friendship (sender_id)');
        $this->addSql('CREATE INDEX IDX_7234A45FCD53EDB6 ON friendship (receiver_id)');
        $this->addSql('ALTER TABLE friendship ADD PRIMARY KEY (sender_id, receiver_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE friendship DROP FOREIGN KEY FK_7234A45FF624B39D');
        $this->addSql('ALTER TABLE friendship DROP FOREIGN KEY FK_7234A45FCD53EDB6');
        $this->addSql('DROP INDEX IDX_7234A45FF624B39D ON friendship');
        $this->addSql('DROP INDEX IDX_7234A45FCD53EDB6 ON friendship');
        $this->addSql('ALTER TABLE friendship DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE friendship ADD user_id CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:guid)\', ADD friend_id CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:guid)\', DROP sender_id, DROP receiver_id');
        $this->addSql('ALTER TABLE friendship ADD CONSTRAINT FK_7234A45F6A5458E8 FOREIGN KEY (friend_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE friendship ADD CONSTRAINT FK_7234A45FA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_7234A45F6A5458E8 ON friendship (friend_id)');
        $this->addSql('CREATE INDEX IDX_7234A45FA76ED395 ON friendship (user_id)');
        $this->addSql('ALTER TABLE friendship ADD PRIMARY KEY (user_id, friend_id)');
    }
}
