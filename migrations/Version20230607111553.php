<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607111553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');


        $this->addSql('CREATE TABLE permissions (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, value VARCHAR(60) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE roles (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, value VARCHAR(60) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE roles_permissions (id BIGINT AUTO_INCREMENT NOT NULL, role_id BIGINT NOT NULL, permission_id BIGINT NOT NULL, PRIMARY KEY(id), FOREIGN KEY (role_id) REFERENCES roles(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (permission_id) REFERENCES permissions(id) ON UPDATE CASCADE ON DELETE CASCADE)');
        $this->addSql('CREATE TABLE users (id BIGINT AUTO_INCREMENT NOT NULL, username VARCHAR(40) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(100), last_name VARCHAR(100), phone_number VARCHAR(20, email VARCHAR(40) NOT NULL, avatar_url VARCHAR(255), role_id BIGINT, PRIMARY KEY(id), FOREIGN KEY (role_id) REFERENCES roles(id) ON UPDATE CASCADE ON DELETE SET NULL)');
        $this->addSql('CREATE TABLE teams (id BIGINT AUTO_INCREMENT NOT NULL, team_name VARCHAR(100) NOT NULL, owner_id BIGINT, PRIMARY KEY(id), FOREIGN KEY (owner_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE SET NULL)');
        $this->addSql('CREATE TABLE teammates (id BIGINT AUTO_INCREMENT NOT NULL, team_id BIGINT, user_id BIGINT, role_id BIGINT, PRIMARY KEY(id), FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (role_id) REFERENCES roles(id) ON UPDATE CASCADE ON DELETE SET NULL, FOREIGN KEY (team_id) REFERENCES teams(id)  ON UPDATE CASCADE ON DELETE CASCADE)');
        
        $this->addSql('CREATE TABLE tags (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE status (id SMALLINT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, value VARCHAR(100) NOT NULL, PRIMARY KEY(id))');


        $this->addSql('CREATE TABLE projects (id BIGINT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT, progress INT NOT NULL DEFAULT \'0\', status_id SMALLINT, owner_id BIGINT, team_id BIGINT, PRIMARY KEY(id), FOREIGN KEY (owner_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (status_id) REFERENCES status(id) ON UPDATE CASCADE ON DELETE SET NULL, FOREIGN KEY (team_id) REFERENCES teams(id)  ON UPDATE CASCADE ON DELETE SET NULL)');
        $this->addSql('CREATE TABLE project_status (id BIGINT AUTO_INCREMENT NOT NULL, project_id BIGINT, status_id SMALLINT, PRIMARY KEY(id), FOREIGN KEY (project_id) REFERENCES projects(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (status_id) REFERENCES status(id) ON UPDATE CASCADE ON DELETE CASCADE)');
        $this->addSql('CREATE TABLE project_tags (id BIGINT AUTO_INCREMENT NOT NULL, project_id BIGINT, tag_id BIGINT, PRIMARY KEY(id), FOREIGN KEY (project_id) REFERENCES projects(id), FOREIGN KEY (tag_id) REFERENCES tags(id))');
        
        $this->addSql('CREATE TABLE milestones (id BIGINT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT, progress INT NOT NULL DEFAULT \'0\', project_id BIGINT, status_id SMALLINT, planned_start_date DATETIME NOT NULL, planned_end_date DATETIME NOT NULL, owner_id BIGINT NOT NULL, team_id BIGINT, PRIMARY KEY(id), FOREIGN KEY (owner_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (status_id) REFERENCES status(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (project_id) REFERENCES projects(id) ON UPDATE CASCADE ON DELETE CASCADE)');
        $this->addSql('CREATE TABLE milestone_status (id BIGINT AUTO_INCREMENT NOT NULL, milestone_id BIGINT, status_id SMALLINT, PRIMARY KEY(id), FOREIGN KEY (milestone_id) REFERENCES milestones(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (status_id) REFERENCES status(id) ON UPDATE CASCADE ON DELETE CASCADE)');
        $this->addSql('CREATE TABLE milestone_tags (id BIGINT AUTO_INCREMENT NOT NULL, milestone_id BIGINT, tag_id BIGINT, PRIMARY KEY(id), FOREIGN KEY (milestone_id) REFERENCES milestones(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (tag_id) REFERENCES tags(id) ON UPDATE CASCADE ON DELETE CASCADE)');
        
        
        $this->addSql('CREATE TABLE tasks (id BIGINT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT, project_id BIGINT NOT NULL, milestone_id BIGINT, status_id SMALLINT, started_date DATETIME NOT NULL, ended_date DATETIME NOT NULL, owner_id BIGINT NOT NULL, PRIMARY KEY(id), FOREIGN KEY (owner_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (status_id) REFERENCES status(id) ON UPDATE CASCADE ON DELETE SET NULL, FOREIGN KEY (project_id) REFERENCES projects(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (milestone_id) REFERENCES milestones(id) ON UPDATE CASCADE ON DELETE CASCADE)');
        $this->addSql('CREATE TABLE task_status (id BIGINT AUTO_INCREMENT NOT NULL, task_id BIGINT, status_id SMALLINT, PRIMARY KEY(id), FOREIGN KEY (task_id) REFERENCES tasks(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (status_id) REFERENCES status(id) ON UPDATE CASCADE ON DELETE CASCADE)');
        $this->addSql('CREATE TABLE task_tags (id BIGINT AUTO_INCREMENT NOT NULL, task_id BIGINT, tag_id BIGINT, PRIMARY KEY(id), FOREIGN KEY (task_id) REFERENCES tasks(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (tag_id) REFERENCES tags(id) ON UPDATE CASCADE ON DELETE CASCADE)');
    
        $this->addSql('CREATE TABLE discussions (id BIGINT AUTO_INCREMENT NOT NULL, task_id BIGINT, project_id BIGINT, milestone_id BIGINT, PRIMARY KEY(id), FOREIGN KEY (task_id) REFERENCES tasks(id) ON UPDATE CASCADE ON DELETE SET NULL, FOREIGN KEY (project_id) REFERENCES projects(id) ON UPDATE CASCADE ON DELETE SET NULL, FOREIGN KEY (milestone_id) REFERENCES milestones(id) ON UPDATE CASCADE ON DELETE SET NULL)');
        $this->addSql('CREATE TABLE comments (id BIGINT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, discussion_id BIGINT, user_id BIGINT, replied_to BIGINT NOT NULL, PRIMARY KEY(id), FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (discussion_id) REFERENCES discussions(id) ON UPDATE CASCADE ON DELETE CASCADE)');
   
        $this->addSql('CREATE TABLE file_types (id SMALLINT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, value VARCHAR(40) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE files (id BIGINT AUTO_INCREMENT NOT NULL, file_name VARCHAR(255) NOT NULL, file_size FLOAT NOT NULL, file_type_id SMALLINT, upload_by BIGINT, url VARCHAR(255) NOT NULL, project_id BIGINT, milestone_id BIGINT, task_id BIGINT, comment_id BIGINT, PRIMARY KEY(id), FOREIGN KEY (upload_by) REFERENCES users(id) ON UPDATE CASCADE ON DELETE SET NULL, FOREIGN KEY (file_type_id) REFERENCES file_types(id) ON UPDATE CASCADE ON DELETE SET NULL, FOREIGN KEY (project_id) REFERENCES projects(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (milestone_id) REFERENCES milestones(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (task_id) REFERENCES tasks(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (comment_id) REFERENCES comments(id) ON UPDATE CASCADE ON DELETE CASCADE)');
 }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');

        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE file_types');

        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE discussion');

        $this->addSql('DROP TABLE task_tags');
        $this->addSql('DROP TABLE task_status');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE milestone_tags');
        $this->addSql('DROP TABLE milestone_status');
        $this->addSql('DROP TABLE milestones');
        $this->addSql('DROP TABLE project_tags');
        $this->addSql('DROP TABLE project_status');
        $this->addSql('DROP TABLE projects');

        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE status');

        $this->addSql('DROP TABLE roles_permissions');
        $this->addSql('DROP TABLE permissions');
        $this->addSql('DROP TABLE roles');

        $this->addSql('DROP TABLE teammates');
        $this->addSql('DROP TABLE teams');
        $this->addSql('DROP TABLE users');
    }
}
