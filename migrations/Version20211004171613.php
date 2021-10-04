<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211004171613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C62E6386C6E55B5 ON contact (nom)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C62E638A625945B ON contact (prenom)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C62E638450FF010 ON contact (telephone)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_4C62E6386C6E55B5 ON contact');
        $this->addSql('DROP INDEX UNIQ_4C62E638A625945B ON contact');
        $this->addSql('DROP INDEX UNIQ_4C62E638450FF010 ON contact');
    }
}
