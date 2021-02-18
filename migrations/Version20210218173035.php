<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210218173035 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comentarios ADD hilo_id INT NOT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comentarios ADD CONSTRAINT FK_F54B3FC0AC49E255 FOREIGN KEY (hilo_id) REFERENCES hilo (id)');
        $this->addSql('ALTER TABLE comentarios ADD CONSTRAINT FK_F54B3FC0A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_F54B3FC0AC49E255 ON comentarios (hilo_id)');
        $this->addSql('CREATE INDEX IDX_F54B3FC0A76ED395 ON comentarios (user_id)');
        $this->addSql('ALTER TABLE hilo ADD hilo_foro_id INT NOT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hilo ADD CONSTRAINT FK_8C95A83DD286B34D FOREIGN KEY (hilo_foro_id) REFERENCES foro (id)');
        $this->addSql('ALTER TABLE hilo ADD CONSTRAINT FK_8C95A83DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_8C95A83DD286B34D ON hilo (hilo_foro_id)');
        $this->addSql('CREATE INDEX IDX_8C95A83DA76ED395 ON hilo (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comentarios DROP FOREIGN KEY FK_F54B3FC0AC49E255');
        $this->addSql('ALTER TABLE comentarios DROP FOREIGN KEY FK_F54B3FC0A76ED395');
        $this->addSql('DROP INDEX IDX_F54B3FC0AC49E255 ON comentarios');
        $this->addSql('DROP INDEX IDX_F54B3FC0A76ED395 ON comentarios');
        $this->addSql('ALTER TABLE comentarios DROP hilo_id, DROP user_id');
        $this->addSql('ALTER TABLE hilo DROP FOREIGN KEY FK_8C95A83DD286B34D');
        $this->addSql('ALTER TABLE hilo DROP FOREIGN KEY FK_8C95A83DA76ED395');
        $this->addSql('DROP INDEX IDX_8C95A83DD286B34D ON hilo');
        $this->addSql('DROP INDEX IDX_8C95A83DA76ED395 ON hilo');
        $this->addSql('ALTER TABLE hilo DROP hilo_foro_id, DROP user_id');
    }
}
