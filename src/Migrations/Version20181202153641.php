<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181202153641 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE appartment (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, status_id INT NOT NULL, city_id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(150) NOT NULL, area INT NOT NULL, room INT NOT NULL, description LONGTEXT NOT NULL, garage SMALLINT DEFAULT NULL, locker SMALLINT DEFAULT NULL, people VARCHAR(20) NOT NULL, bedroom INT DEFAULT NULL, ski INT DEFAULT NULL, information LONGTEXT DEFAULT NULL, adress LONGTEXT NOT NULL, lat DOUBLE PRECISION NOT NULL, lng DOUBLE PRECISION NOT NULL, reference VARCHAR(30) NOT NULL, date DATETIME NOT NULL, INDEX IDX_CD632DF0C54C8C93 (type_id), INDEX IDX_CD632DF06BF700BD (status_id), INDEX IDX_CD632DF08BAC62AF (city_id), INDEX IDX_CD632DF0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, lat DOUBLE PRECISION NOT NULL, lng DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, firstname VARCHAR(100) DEFAULT NULL, lastname VARCHAR(100) DEFAULT NULL, password VARCHAR(255) NOT NULL, date DATETIME NOT NULL, gender VARCHAR(50) DEFAULT NULL, role JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appartment ADD CONSTRAINT FK_CD632DF0C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appartment ADD CONSTRAINT FK_CD632DF06BF700BD FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appartment ADD CONSTRAINT FK_CD632DF08BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appartment ADD CONSTRAINT FK_CD632DF0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appartment DROP FOREIGN KEY FK_CD632DF08BAC62AF');
        $this->addSql('ALTER TABLE appartment DROP FOREIGN KEY FK_CD632DF06BF700BD');
        $this->addSql('ALTER TABLE appartment DROP FOREIGN KEY FK_CD632DF0C54C8C93');
        $this->addSql('ALTER TABLE appartment DROP FOREIGN KEY FK_CD632DF0A76ED395');
        $this->addSql('DROP TABLE appartment');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
    }
}
