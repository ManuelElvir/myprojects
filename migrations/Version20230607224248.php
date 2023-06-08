<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607224248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE permission (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, value VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, owner_id INT NOT NULL, team_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, progress INT NOT NULL, INDEX IDX_2FB3D0EE6BF700BD (status_id), INDEX IDX_2FB3D0EE7E3C61F9 (owner_id), INDEX IDX_2FB3D0EE296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_user (project_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B4021E51166D1F9C (project_id), INDEX IDX_B4021E51A76ED395 (user_id), PRIMARY KEY(project_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, value VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_permission (role_id INT NOT NULL, permission_id INT NOT NULL, INDEX IDX_6F7DF886D60322AC (role_id), INDEX IDX_6F7DF886FED90CCA (permission_id), PRIMARY KEY(role_id, permission_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, team_name VARCHAR(100) NOT NULL, INDEX IDX_C4E0A61F7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teammate (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_C06EEBAE296CD8AE (team_id), INDEX IDX_C06EEBAEA76ED395 (user_id), INDEX IDX_C06EEBAED60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, username VARCHAR(100) NOT NULL, email VARCHAR(40) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(100) DEFAULT NULL, last_name VARCHAR(100) DEFAULT NULL, phone_number VARCHAR(20) DEFAULT NULL, avatar_url VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D649D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE project_user ADD CONSTRAINT FK_B4021E51166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_user ADD CONSTRAINT FK_B4021E51A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_permission ADD CONSTRAINT FK_6F7DF886D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_permission ADD CONSTRAINT FK_6F7DF886FED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE teammate ADD CONSTRAINT FK_C06EEBAE296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE teammate ADD CONSTRAINT FK_C06EEBAEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE teammate ADD CONSTRAINT FK_C06EEBAED60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY comments_ibfk_2');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY comments_ibfk_1');
        $this->addSql('ALTER TABLE discussions DROP FOREIGN KEY discussions_ibfk_3');
        $this->addSql('ALTER TABLE discussions DROP FOREIGN KEY discussions_ibfk_1');
        $this->addSql('ALTER TABLE discussions DROP FOREIGN KEY discussions_ibfk_2');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY files_ibfk_3');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY files_ibfk_6');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY files_ibfk_1');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY files_ibfk_4');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY files_ibfk_2');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY files_ibfk_5');
        $this->addSql('ALTER TABLE milestones DROP FOREIGN KEY milestones_ibfk_3');
        $this->addSql('ALTER TABLE milestones DROP FOREIGN KEY milestones_ibfk_1');
        $this->addSql('ALTER TABLE milestones DROP FOREIGN KEY milestones_ibfk_2');
        $this->addSql('ALTER TABLE milestone_status DROP FOREIGN KEY milestone_status_ibfk_1');
        $this->addSql('ALTER TABLE milestone_status DROP FOREIGN KEY milestone_status_ibfk_2');
        $this->addSql('ALTER TABLE milestone_tags DROP FOREIGN KEY milestone_tags_ibfk_1');
        $this->addSql('ALTER TABLE milestone_tags DROP FOREIGN KEY milestone_tags_ibfk_2');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY projects_ibfk_2');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY projects_ibfk_3');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY projects_ibfk_1');
        $this->addSql('ALTER TABLE project_status DROP FOREIGN KEY project_status_ibfk_2');
        $this->addSql('ALTER TABLE project_status DROP FOREIGN KEY project_status_ibfk_1');
        $this->addSql('ALTER TABLE project_tags DROP FOREIGN KEY project_tags_ibfk_1');
        $this->addSql('ALTER TABLE project_tags DROP FOREIGN KEY project_tags_ibfk_2');
        $this->addSql('ALTER TABLE roles_permissions DROP FOREIGN KEY roles_permissions_ibfk_1');
        $this->addSql('ALTER TABLE roles_permissions DROP FOREIGN KEY roles_permissions_ibfk_2');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY tasks_ibfk_1');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY tasks_ibfk_4');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY tasks_ibfk_2');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY tasks_ibfk_3');
        $this->addSql('ALTER TABLE task_status DROP FOREIGN KEY task_status_ibfk_1');
        $this->addSql('ALTER TABLE task_status DROP FOREIGN KEY task_status_ibfk_2');
        $this->addSql('ALTER TABLE task_tags DROP FOREIGN KEY task_tags_ibfk_1');
        $this->addSql('ALTER TABLE task_tags DROP FOREIGN KEY task_tags_ibfk_2');
        $this->addSql('ALTER TABLE teammates DROP FOREIGN KEY teammates_ibfk_2');
        $this->addSql('ALTER TABLE teammates DROP FOREIGN KEY teammates_ibfk_3');
        $this->addSql('ALTER TABLE teammates DROP FOREIGN KEY teammates_ibfk_1');
        $this->addSql('ALTER TABLE teams DROP FOREIGN KEY teams_ibfk_1');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY users_ibfk_1');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE discussions');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE file_types');
        $this->addSql('DROP TABLE milestones');
        $this->addSql('DROP TABLE milestone_status');
        $this->addSql('DROP TABLE milestone_tags');
        $this->addSql('DROP TABLE permissions');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE project_status');
        $this->addSql('DROP TABLE project_tags');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE roles_permissions');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE task_status');
        $this->addSql('DROP TABLE task_tags');
        $this->addSql('DROP TABLE teammates');
        $this->addSql('DROP TABLE teams');
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE status CHANGE id id INT AUTO_INCREMENT NOT NULL');

        $this->addSql('CREATE TABLE project_users (id BIGINT AUTO_INCREMENT NOT NULL, project_id BIGINT NOT NULL, user_id BIGINT NOT NULL, PRIMARY KEY(id), FOREIGN KEY (project_id) REFERENCES projects(id) ON UPDATE CASCADE ON DELETE CASCADE, FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE project_users');

        $this->addSql('CREATE TABLE comments (id BIGINT AUTO_INCREMENT NOT NULL, discussion_id BIGINT DEFAULT NULL, user_id BIGINT DEFAULT NULL, content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, replied_to BIGINT NOT NULL, INDEX discussion_id (discussion_id), INDEX user_id (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE discussions (id BIGINT AUTO_INCREMENT NOT NULL, task_id BIGINT DEFAULT NULL, project_id BIGINT DEFAULT NULL, milestone_id BIGINT DEFAULT NULL, INDEX project_id (project_id), INDEX milestone_id (milestone_id), INDEX task_id (task_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE files (id BIGINT AUTO_INCREMENT NOT NULL, file_type_id SMALLINT DEFAULT NULL, upload_by BIGINT DEFAULT NULL, project_id BIGINT DEFAULT NULL, milestone_id BIGINT DEFAULT NULL, task_id BIGINT DEFAULT NULL, comment_id BIGINT DEFAULT NULL, file_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, file_size DOUBLE PRECISION NOT NULL, url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX comment_id (comment_id), INDEX project_id (project_id), INDEX milestone_id (milestone_id), INDEX upload_by (upload_by), INDEX task_id (task_id), INDEX file_type_id (file_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE file_types (id SMALLINT AUTO_INCREMENT NOT NULL, name VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, value VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE milestones (id BIGINT AUTO_INCREMENT NOT NULL, project_id BIGINT DEFAULT NULL, status_id SMALLINT DEFAULT NULL, owner_id BIGINT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, progress INT DEFAULT 0 NOT NULL, planned_start_date DATETIME NOT NULL, planned_end_date DATETIME NOT NULL, team_id BIGINT DEFAULT NULL, INDEX owner_id (owner_id), INDEX status_id (status_id), INDEX project_id (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE milestone_status (id BIGINT AUTO_INCREMENT NOT NULL, milestone_id BIGINT DEFAULT NULL, status_id SMALLINT DEFAULT NULL, INDEX milestone_id (milestone_id), INDEX status_id (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE milestone_tags (id BIGINT AUTO_INCREMENT NOT NULL, milestone_id BIGINT DEFAULT NULL, tag_id BIGINT DEFAULT NULL, INDEX milestone_id (milestone_id), INDEX tag_id (tag_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE permissions (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, value VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE projects (id BIGINT AUTO_INCREMENT NOT NULL, status_id SMALLINT DEFAULT NULL, owner_id BIGINT DEFAULT NULL, team_id BIGINT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, progress INT DEFAULT 0 NOT NULL, INDEX team_id (team_id), INDEX owner_id (owner_id), INDEX status_id (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE project_status (id BIGINT AUTO_INCREMENT NOT NULL, project_id BIGINT DEFAULT NULL, status_id SMALLINT DEFAULT NULL, INDEX status_id (status_id), INDEX project_id (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE project_tags (id BIGINT AUTO_INCREMENT NOT NULL, project_id BIGINT DEFAULT NULL, tag_id BIGINT DEFAULT NULL, INDEX tag_id (tag_id), INDEX project_id (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE roles (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, value VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE roles_permissions (id BIGINT AUTO_INCREMENT NOT NULL, role_id BIGINT NOT NULL, permission_id BIGINT NOT NULL, INDEX role_id (role_id), INDEX permission_id (permission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tags (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tasks (id BIGINT AUTO_INCREMENT NOT NULL, project_id BIGINT NOT NULL, milestone_id BIGINT DEFAULT NULL, status_id SMALLINT DEFAULT NULL, owner_id BIGINT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, started_date DATETIME NOT NULL, ended_date DATETIME NOT NULL, INDEX project_id (project_id), INDEX milestone_id (milestone_id), INDEX owner_id (owner_id), INDEX status_id (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE task_status (id BIGINT AUTO_INCREMENT NOT NULL, task_id BIGINT DEFAULT NULL, status_id SMALLINT DEFAULT NULL, INDEX task_id (task_id), INDEX status_id (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE task_tags (id BIGINT AUTO_INCREMENT NOT NULL, task_id BIGINT DEFAULT NULL, tag_id BIGINT DEFAULT NULL, INDEX task_id (task_id), INDEX tag_id (tag_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE teammates (id BIGINT AUTO_INCREMENT NOT NULL, team_id BIGINT DEFAULT NULL, user_id BIGINT DEFAULT NULL, role_id BIGINT DEFAULT NULL, INDEX user_id (user_id), INDEX role_id (role_id), INDEX team_id (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE teams (id BIGINT AUTO_INCREMENT NOT NULL, owner_id BIGINT DEFAULT NULL, team_name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX owner_id (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE users (id BIGINT AUTO_INCREMENT NOT NULL, role_id BIGINT DEFAULT NULL, username VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, first_name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, last_name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, phone_number VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, avatar_url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, INDEX role_id (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT comments_ibfk_2 FOREIGN KEY (discussion_id) REFERENCES discussions (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT comments_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discussions ADD CONSTRAINT discussions_ibfk_3 FOREIGN KEY (milestone_id) REFERENCES milestones (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('ALTER TABLE discussions ADD CONSTRAINT discussions_ibfk_1 FOREIGN KEY (task_id) REFERENCES tasks (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('ALTER TABLE discussions ADD CONSTRAINT discussions_ibfk_2 FOREIGN KEY (project_id) REFERENCES projects (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT files_ibfk_3 FOREIGN KEY (project_id) REFERENCES projects (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT files_ibfk_6 FOREIGN KEY (comment_id) REFERENCES comments (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT files_ibfk_1 FOREIGN KEY (upload_by) REFERENCES users (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT files_ibfk_4 FOREIGN KEY (milestone_id) REFERENCES milestones (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT files_ibfk_2 FOREIGN KEY (file_type_id) REFERENCES file_types (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT files_ibfk_5 FOREIGN KEY (task_id) REFERENCES tasks (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE milestones ADD CONSTRAINT milestones_ibfk_3 FOREIGN KEY (project_id) REFERENCES projects (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE milestones ADD CONSTRAINT milestones_ibfk_1 FOREIGN KEY (owner_id) REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE milestones ADD CONSTRAINT milestones_ibfk_2 FOREIGN KEY (status_id) REFERENCES status (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE milestone_status ADD CONSTRAINT milestone_status_ibfk_1 FOREIGN KEY (milestone_id) REFERENCES milestones (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE milestone_status ADD CONSTRAINT milestone_status_ibfk_2 FOREIGN KEY (status_id) REFERENCES status (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE milestone_tags ADD CONSTRAINT milestone_tags_ibfk_1 FOREIGN KEY (milestone_id) REFERENCES milestones (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE milestone_tags ADD CONSTRAINT milestone_tags_ibfk_2 FOREIGN KEY (tag_id) REFERENCES tags (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT projects_ibfk_2 FOREIGN KEY (status_id) REFERENCES status (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT projects_ibfk_3 FOREIGN KEY (team_id) REFERENCES teams (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT projects_ibfk_1 FOREIGN KEY (owner_id) REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_status ADD CONSTRAINT project_status_ibfk_2 FOREIGN KEY (status_id) REFERENCES status (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_status ADD CONSTRAINT project_status_ibfk_1 FOREIGN KEY (project_id) REFERENCES projects (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_tags ADD CONSTRAINT project_tags_ibfk_1 FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE project_tags ADD CONSTRAINT project_tags_ibfk_2 FOREIGN KEY (tag_id) REFERENCES tags (id)');
        $this->addSql('ALTER TABLE roles_permissions ADD CONSTRAINT roles_permissions_ibfk_1 FOREIGN KEY (role_id) REFERENCES roles (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roles_permissions ADD CONSTRAINT roles_permissions_ibfk_2 FOREIGN KEY (permission_id) REFERENCES permissions (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT tasks_ibfk_1 FOREIGN KEY (owner_id) REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT tasks_ibfk_4 FOREIGN KEY (milestone_id) REFERENCES milestones (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT tasks_ibfk_2 FOREIGN KEY (status_id) REFERENCES status (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT tasks_ibfk_3 FOREIGN KEY (project_id) REFERENCES projects (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_status ADD CONSTRAINT task_status_ibfk_1 FOREIGN KEY (task_id) REFERENCES tasks (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_status ADD CONSTRAINT task_status_ibfk_2 FOREIGN KEY (status_id) REFERENCES status (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_tags ADD CONSTRAINT task_tags_ibfk_1 FOREIGN KEY (task_id) REFERENCES tasks (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_tags ADD CONSTRAINT task_tags_ibfk_2 FOREIGN KEY (tag_id) REFERENCES tags (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teammates ADD CONSTRAINT teammates_ibfk_2 FOREIGN KEY (role_id) REFERENCES roles (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('ALTER TABLE teammates ADD CONSTRAINT teammates_ibfk_3 FOREIGN KEY (team_id) REFERENCES teams (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teammates ADD CONSTRAINT teammates_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teams ADD CONSTRAINT teams_ibfk_1 FOREIGN KEY (owner_id) REFERENCES users (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT users_ibfk_1 FOREIGN KEY (role_id) REFERENCES roles (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE6BF700BD');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE7E3C61F9');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE296CD8AE');
        $this->addSql('ALTER TABLE project_user DROP FOREIGN KEY FK_B4021E51166D1F9C');
        $this->addSql('ALTER TABLE project_user DROP FOREIGN KEY FK_B4021E51A76ED395');
        $this->addSql('ALTER TABLE role_permission DROP FOREIGN KEY FK_6F7DF886D60322AC');
        $this->addSql('ALTER TABLE role_permission DROP FOREIGN KEY FK_6F7DF886FED90CCA');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F7E3C61F9');
        $this->addSql('ALTER TABLE teammate DROP FOREIGN KEY FK_C06EEBAE296CD8AE');
        $this->addSql('ALTER TABLE teammate DROP FOREIGN KEY FK_C06EEBAEA76ED395');
        $this->addSql('ALTER TABLE teammate DROP FOREIGN KEY FK_C06EEBAED60322AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_user');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_permission');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE teammate');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE status CHANGE id id SMALLINT AUTO_INCREMENT NOT NULL');
    }
}
