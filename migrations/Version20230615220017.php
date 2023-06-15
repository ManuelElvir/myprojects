<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230615220017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, content LONGTEXT NOT NULL, replied_to INT DEFAULT NULL, INDEX IDX_9474526C7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, task_id INT DEFAULT NULL, milestone_id INT DEFAULT NULL, project_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_C0B9F90F8DB60186 (task_id), UNIQUE INDEX UNIQ_C0B9F90F4B3E2EDA (milestone_id), UNIQUE INDEX UNIQ_C0B9F90F166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, file_type_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, task_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, file_name VARCHAR(255) NOT NULL, file_size DOUBLE PRECISION NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_8C9F36109E2A35A8 (file_type_id), INDEX IDX_8C9F36107E3C61F9 (owner_id), INDEX IDX_8C9F36108DB60186 (task_id), INDEX IDX_8C9F3610F8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE milestone (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, project_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, dependencies LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', planned_start_date DATE DEFAULT NULL, planned_end_date DATE DEFAULT NULL, INDEX IDX_4FAC83826BF700BD (status_id), INDEX IDX_4FAC8382166D1F9C (project_id), INDEX IDX_4FAC83827E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE milestone_tag (milestone_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_E10DAF44B3E2EDA (milestone_id), INDEX IDX_E10DAF4BAD26311 (tag_id), PRIMARY KEY(milestone_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permission (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, value VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, owner_id INT NOT NULL, team_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, progress DOUBLE PRECISION DEFAULT NULL, INDEX IDX_2FB3D0EE6BF700BD (status_id), INDEX IDX_2FB3D0EE7E3C61F9 (owner_id), INDEX IDX_2FB3D0EE296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_user (project_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B4021E51166D1F9C (project_id), INDEX IDX_B4021E51A76ED395 (user_id), PRIMARY KEY(project_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_tag (project_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_91F26D60166D1F9C (project_id), INDEX IDX_91F26D60BAD26311 (tag_id), PRIMARY KEY(project_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_setting (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_96AB4FD166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_setting_status (project_setting_id INT NOT NULL, status_id INT NOT NULL, INDEX IDX_A84BA883F693C640 (project_setting_id), INDEX IDX_A84BA8836BF700BD (status_id), PRIMARY KEY(project_setting_id, status_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_setting_milestone_status (project_setting_id INT NOT NULL, status_id INT NOT NULL, INDEX IDX_E4CAD5D6F693C640 (project_setting_id), INDEX IDX_E4CAD5D66BF700BD (status_id), PRIMARY KEY(project_setting_id, status_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_setting_task_status (project_setting_id INT NOT NULL, status_id INT NOT NULL, INDEX IDX_41029328F693C640 (project_setting_id), INDEX IDX_410293286BF700BD (status_id), PRIMARY KEY(project_setting_id, status_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, value VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_permission (role_id INT NOT NULL, permission_id INT NOT NULL, INDEX IDX_6F7DF886D60322AC (role_id), INDEX IDX_6F7DF886FED90CCA (permission_id), PRIMARY KEY(role_id, permission_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, value VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, assigned_to_id INT DEFAULT NULL, milestone_id INT DEFAULT NULL, project_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_527EDB25B03A8386 (created_by_id), INDEX IDX_527EDB25F4BD7827 (assigned_to_id), INDEX IDX_527EDB254B3E2EDA (milestone_id), INDEX IDX_527EDB25166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_tag (task_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_6C0B4F048DB60186 (task_id), INDEX IDX_6C0B4F04BAD26311 (tag_id), PRIMARY KEY(task_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, team_name VARCHAR(100) NOT NULL, INDEX IDX_C4E0A61F7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teammate (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_C06EEBAE296CD8AE (team_id), INDEX IDX_C06EEBAEA76ED395 (user_id), INDEX IDX_C06EEBAED60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, username VARCHAR(100) NOT NULL, email VARCHAR(40) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(100) DEFAULT NULL, last_name VARCHAR(100) DEFAULT NULL, phone_number VARCHAR(20) DEFAULT NULL, avatar_url VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D649D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F8DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F4B3E2EDA FOREIGN KEY (milestone_id) REFERENCES milestone (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F36109E2A35A8 FOREIGN KEY (file_type_id) REFERENCES file_type (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F36107E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F36108DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE milestone ADD CONSTRAINT FK_4FAC83826BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE milestone ADD CONSTRAINT FK_4FAC8382166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE milestone ADD CONSTRAINT FK_4FAC83827E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE milestone_tag ADD CONSTRAINT FK_E10DAF44B3E2EDA FOREIGN KEY (milestone_id) REFERENCES milestone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE milestone_tag ADD CONSTRAINT FK_E10DAF4BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE project_user ADD CONSTRAINT FK_B4021E51166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_user ADD CONSTRAINT FK_B4021E51A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_tag ADD CONSTRAINT FK_91F26D60166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_tag ADD CONSTRAINT FK_91F26D60BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_setting ADD CONSTRAINT FK_96AB4FD166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE project_setting_status ADD CONSTRAINT FK_A84BA883F693C640 FOREIGN KEY (project_setting_id) REFERENCES project_setting (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_setting_status ADD CONSTRAINT FK_A84BA8836BF700BD FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_setting_milestone_status ADD CONSTRAINT FK_E4CAD5D6F693C640 FOREIGN KEY (project_setting_id) REFERENCES project_setting (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_setting_milestone_status ADD CONSTRAINT FK_E4CAD5D66BF700BD FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_setting_task_status ADD CONSTRAINT FK_41029328F693C640 FOREIGN KEY (project_setting_id) REFERENCES project_setting (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_setting_task_status ADD CONSTRAINT FK_410293286BF700BD FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_permission ADD CONSTRAINT FK_6F7DF886D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_permission ADD CONSTRAINT FK_6F7DF886FED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25F4BD7827 FOREIGN KEY (assigned_to_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB254B3E2EDA FOREIGN KEY (milestone_id) REFERENCES milestone (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE task_tag ADD CONSTRAINT FK_6C0B4F048DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_tag ADD CONSTRAINT FK_6C0B4F04BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE teammate ADD CONSTRAINT FK_C06EEBAE296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE teammate ADD CONSTRAINT FK_C06EEBAEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE teammate ADD CONSTRAINT FK_C06EEBAED60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7E3C61F9');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F8DB60186');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F4B3E2EDA');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F166D1F9C');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F36109E2A35A8');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F36107E3C61F9');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F36108DB60186');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610F8697D13');
        $this->addSql('ALTER TABLE milestone DROP FOREIGN KEY FK_4FAC83826BF700BD');
        $this->addSql('ALTER TABLE milestone DROP FOREIGN KEY FK_4FAC8382166D1F9C');
        $this->addSql('ALTER TABLE milestone DROP FOREIGN KEY FK_4FAC83827E3C61F9');
        $this->addSql('ALTER TABLE milestone_tag DROP FOREIGN KEY FK_E10DAF44B3E2EDA');
        $this->addSql('ALTER TABLE milestone_tag DROP FOREIGN KEY FK_E10DAF4BAD26311');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE6BF700BD');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE7E3C61F9');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE296CD8AE');
        $this->addSql('ALTER TABLE project_user DROP FOREIGN KEY FK_B4021E51166D1F9C');
        $this->addSql('ALTER TABLE project_user DROP FOREIGN KEY FK_B4021E51A76ED395');
        $this->addSql('ALTER TABLE project_tag DROP FOREIGN KEY FK_91F26D60166D1F9C');
        $this->addSql('ALTER TABLE project_tag DROP FOREIGN KEY FK_91F26D60BAD26311');
        $this->addSql('ALTER TABLE project_setting DROP FOREIGN KEY FK_96AB4FD166D1F9C');
        $this->addSql('ALTER TABLE project_setting_status DROP FOREIGN KEY FK_A84BA883F693C640');
        $this->addSql('ALTER TABLE project_setting_status DROP FOREIGN KEY FK_A84BA8836BF700BD');
        $this->addSql('ALTER TABLE project_setting_milestone_status DROP FOREIGN KEY FK_E4CAD5D6F693C640');
        $this->addSql('ALTER TABLE project_setting_milestone_status DROP FOREIGN KEY FK_E4CAD5D66BF700BD');
        $this->addSql('ALTER TABLE project_setting_task_status DROP FOREIGN KEY FK_41029328F693C640');
        $this->addSql('ALTER TABLE project_setting_task_status DROP FOREIGN KEY FK_410293286BF700BD');
        $this->addSql('ALTER TABLE role_permission DROP FOREIGN KEY FK_6F7DF886D60322AC');
        $this->addSql('ALTER TABLE role_permission DROP FOREIGN KEY FK_6F7DF886FED90CCA');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25B03A8386');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25F4BD7827');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB254B3E2EDA');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25166D1F9C');
        $this->addSql('ALTER TABLE task_tag DROP FOREIGN KEY FK_6C0B4F048DB60186');
        $this->addSql('ALTER TABLE task_tag DROP FOREIGN KEY FK_6C0B4F04BAD26311');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F7E3C61F9');
        $this->addSql('ALTER TABLE teammate DROP FOREIGN KEY FK_C06EEBAE296CD8AE');
        $this->addSql('ALTER TABLE teammate DROP FOREIGN KEY FK_C06EEBAEA76ED395');
        $this->addSql('ALTER TABLE teammate DROP FOREIGN KEY FK_C06EEBAED60322AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE file_type');
        $this->addSql('DROP TABLE milestone');
        $this->addSql('DROP TABLE milestone_tag');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_user');
        $this->addSql('DROP TABLE project_tag');
        $this->addSql('DROP TABLE project_setting');
        $this->addSql('DROP TABLE project_setting_status');
        $this->addSql('DROP TABLE project_setting_milestone_status');
        $this->addSql('DROP TABLE project_setting_task_status');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_permission');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE task_tag');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE teammate');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
