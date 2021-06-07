<?php declare(strict_types=1);
require_once 'vendor/autoload.php';

require_once APPPATH . 'config/app.php';
global $config;
use Core\Database\DB;
use Core\Exceptions\DatabaseException;
use Core\Helpers\Lang;
use Core\Logs\Logger;
use App\model\User;
use App\model\Posts;

function gererateDatabase() {
    return "CREATE DATABASE IF NOT EXISTS `". env('DB_NAME') ."` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
}

function Users() {
    return "CREATE TABLE `blog`.`users` (
        `id` BIGINT NOT NULL AUTO_INCREMENT,
        `first_name` VARCHAR(50) NULL DEFAULT NULL,
        `last_name` VARCHAR(50) NULL DEFAULT NULL,
        `mobile` VARCHAR(15) NULL,
        `email` VARCHAR(50) NULL,
        `password` VARCHAR(128) NOT NULL,
        `registeredAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `lastLogin` DATETIME NULL DEFAULT NULL,
        `intro` TINYTEXT NULL DEFAULT NULL,
        `profile` TEXT NULL DEFAULT NULL,
        `type` INT NULL DEFAULT 1,
        `status` INT NULL DEFAULT 0,
        PRIMARY KEY (`id`),
        UNIQUE INDEX `uq_mobile` (`mobile` ASC),
        UNIQUE INDEX `uq_email` (`email` ASC) );";
}

function Posts() {
    return "CREATE TABLE `blog`.`posts` (
        `id` BIGINT NOT NULL AUTO_INCREMENT,
        `authorId` BIGINT NOT NULL,
        `parentId` BIGINT NULL DEFAULT NULL,
        `title` VARCHAR(75) NOT NULL,
        `metaTitle` VARCHAR(100) NULL,
        `slug` VARCHAR(100) NOT NULL,
        `summary` TINYTEXT NULL,
        `published` TINYINT(1) NOT NULL DEFAULT 0,
        `createdAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updatedAt` DATETIME NULL DEFAULT NULL,
        `publishedAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `content` TEXT NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE INDEX `uq_slug` (`slug` ASC),
        INDEX `idx_post_user` (`authorId` ASC),
        CONSTRAINT `fk_post_user`
          FOREIGN KEY (`authorId`)
          REFERENCES `blog`.`users` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION);
      
      ALTER TABLE `blog`.`posts` 
      ADD INDEX `idx_post_parent` (`parentId` ASC);
      ALTER TABLE `blog`.`post` 
      ADD CONSTRAINT `fk_post_parent`
        FOREIGN KEY (`parentId`)
        REFERENCES `blog`.`post` (`id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION;";
}

function post_comment() {
    return "CREATE TABLE `blog`.`post_comment` (
        `id` BIGINT NOT NULL AUTO_INCREMENT,
        `postId` BIGINT NOT NULL,
        `parentId` BIGINT NULL DEFAULT NULL,
        `title` VARCHAR(100) NOT NULL,
        `published` TINYINT(1) NOT NULL DEFAULT 0,
        `createdAt` DATETIME NOT NULL,
        `publishedAt` DATETIME NULL DEFAULT NULL,
        `content` TEXT NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        INDEX `idx_comment_post` (`postId` ASC),
        CONSTRAINT `fk_comment_post`
          FOREIGN KEY (`postId`)
          REFERENCES `blog`.`posts` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION);
      
      ALTER TABLE `blog`.`post_comment` 
      ADD INDEX `idx_comment_parent` (`parentId` ASC);
      ALTER TABLE `blog`.`post_comment` 
      ADD CONSTRAINT `fk_comment_parent`
        FOREIGN KEY (`parentId`)
        REFERENCES `blog`.`post_comment` (`id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION;";
}

function category() {
    return "CREATE TABLE `blog`.`category` (
        `id` BIGINT NOT NULL AUTO_INCREMENT,
        `parentId` BIGINT NULL DEFAULT NULL,
        `title` VARCHAR(75) NOT NULL,
        `metaTitle` VARCHAR(100) NULL DEFAULT NULL,
        `slug` VARCHAR(100) NOT NULL,
        `content` TEXT NULL DEFAULT NULL,
        PRIMARY KEY (`id`));
      
      ALTER TABLE `blog`.`category` 
      ADD INDEX `idx_category_parent` (`parentId` ASC);
      ALTER TABLE `blog`.`category` 
      ADD CONSTRAINT `fk_category_parent`
        FOREIGN KEY (`parentId`)
        REFERENCES `blog`.`category` (`id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION;";
}

function post_category() {
    return "CREATE TABLE `blog`.`post_category` (
        `postId` BIGINT NOT NULL,
        `categoryId` BIGINT NOT NULL,
        PRIMARY KEY (`postId`, `categoryId`),
        INDEX `idx_pc_category` (`categoryId` ASC),
        INDEX `idx_pc_post` (`postId` ASC),
        CONSTRAINT `fk_pc_post`
          FOREIGN KEY (`postId`)
          REFERENCES `blog`.`posts` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION,
        CONSTRAINT `fk_pc_category`
          FOREIGN KEY (`categoryId`)
          REFERENCES `blog`.`category` (`id`)
          ON DELETE NO ACTION
          ON UPDATE NO ACTION);";
}

function Post_Meta() {
    return "CREATE TABLE `blog`.`post_meta`(
        `id` BIGINT NOT NULL AUTO_INCREMENT,
        `postId` BIGINT NOT NULL,
        `key` VARCHAR(50) NOT NULL,
        `content` TEXT NULL DEFAULT NULL,
        PRIMARY KEY(`id`),
        INDEX `idx_meta_post`(`postId` ASC),
        UNIQUE INDEX `uq_post_meta`(`postId` ASC, `key` ASC)
    ) ENGINE = INNODB;";
}

function initDatabase() {
    $db = DB::getInstance();

    echo '<i style="color:blue;font-size:16px;font-family:calibri ;">(!) Creating tables and database</i><br />';
    try {
        $db->smtp->prepare(gererateDatabase())->execute();
        $db->smtp->prepare(Users())->execute();
        $db->smtp->prepare(Posts())->execute();
        $db->smtp->prepare(category())->execute();
        $db->smtp->prepare(post_comment())->execute();
        $db->smtp->prepare(Post_Meta())->execute();
    
        Logger::debug("Database migration complete loaded");
        echo "Databse created";
    } catch(Exception $e) {
        echo "That tables or database already exist.<br />";
    }

    try {
        echo "<i style='color:blue;font-size:14px;font-family:calibri ;'><br />(!) Generator of users and posts created...</i>\r\n";
    
        User::created([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'mobile' => '+407896351432',
            'email' => '0pingosegotast@tumicha.com',
            'password' => password_hash("admin", PASSWORD_DEFAULT, ['cost' => 12]),
            'type' => 2,
            'status' => 1
        ]);
    
        Logger::debug("Database users migration complete loaded");
        var_dump("Database users migration complete loaded complete");
    } catch(Exception $e) {
        echo "<br />That user already exist.\r\n<br />";
    }

    try {
        echo "<i style='color:blue;font-size:14px;font-family:calibri ;'><br />(!) Creating first posts for blog...</i>\r\n";
        Posts::created([
            'authorId' => 1,
            'title' => 'Sample blog post 2',
            'metaTitle' => 'Sample blog post',
            'slug' => 'sample_blog_post_2',
            'summary' => 'This blog post shows a few different types of content that’s supported and styled with Bootstrap.',
            'published' => 1,
            'content' => 'This blog post shows a few different types of content that’s supported and styled with Bootstrap. Basic typography, lists, tables, images, code, and more are all supported as expected.'
        ]);

        Posts::created([
            'authorId' => 1,
            'title' => 'Sample blog post 3',
            'metaTitle' => 'Sample blog post',
            'slug' => 'sample_blog_post_3',
            'summary' => 'This blog post shows a few different types of content that’s supported and styled with Bootstrap.',
            'published' => 1,
            'content' => 'This blog post shows a few different types of content that’s supported and styled with Bootstrap. Basic typography, lists, tables, images, code, and more are all supported as expected.'
        ]);

        Posts::created([
            'authorId' => 1,
            'title' => 'Sample blog post 4',
            'metaTitle' => 'Sample blog post',
            'slug' => 'sample_blog_post_4',
            'summary' => 'This blog post shows a few different types of content that’s supported and styled with Bootstrap.',
            'published' => 1,
            'content' => 'This blog post shows a few different types of content that’s supported and styled with Bootstrap. Basic typography, lists, tables, images, code, and more are all supported as expected.'
        ]);

        Posts::created([
            'authorId' => 1,
            'title' => 'Sample blog post',
            'metaTitle' => 'Sample blog post',
            'slug' => 'sample_blog_post',
            'summary' => 'This blog post shows a few different types of content that’s supported and styled with Bootstrap.',
            'published' => 1,
            'content' => 'This blog post shows a few different types of content that’s supported and styled with Bootstrap. Basic typography, lists, tables, images, code, and more are all supported as expected.'
        ]);

        Logger::debug("Database posts migration complete loaded");
        var_dump("Database posts migration complete loaded complete");
        echo "\r\nDatabase migration complete loaded";
    } catch(Exception $e) {
        echo "<br />That posts already exist.\r\n<br /><br />";
        echo '<i style="color:red;font-size:16px;font-family:calibri ;">(!) Nothing to migrate</i>';
    }
}

initDatabase();