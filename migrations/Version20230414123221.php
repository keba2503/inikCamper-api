<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230414123221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog DROP image, DROP url, DROP button, DROP text_tree, DROP text_two');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog ADD image VARCHAR(255) DEFAULT NULL, ADD url VARCHAR(255) NOT NULL, ADD button VARCHAR(255) NOT NULL, ADD text_tree LONGTEXT NOT NULL, ADD text_two LONGTEXT NOT NULL');
    }
}
