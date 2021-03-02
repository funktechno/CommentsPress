SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acme`
--

-- build images table
DROP TABLE IF EXISTS `configuration`;
CREATE TABLE `configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `configuration_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `contactForm`;
 CREATE TABLE `contactForm` (
   `id` INT(11) NOT NULL AUTO_INCREMENT,
   `email` varchar(40) NOT NULL,
   `subject` varchar(50) NOT NULL,
   `message` varchar(255) NOT NULL,
   `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `users`;
 CREATE TABLE `users` (
   `id` varchar(32) NOT NULL,
   `email` varchar(40) NOT NULL,
   `password` varchar(255) NOT NULL,
   `resetCode` varchar(32) NULL,
   `emailConfirmed` TINYINT NULL,
   `emailCode` varchar(32) NULL,
   `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
   `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   `clientLevel` enum('1','2','3') NOT NULL DEFAULT '1',
   PRIMARY KEY (`id`),
   UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;;
DELIMITER ;;
CREATE TRIGGER before_insert_users
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
   SET new.id = replace(uuid(),'-','');
   SET new.emailCode = replace(uuid(),'-','');
END
;;

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` varchar(32) NOT NULL,
  `slug` varchar(255) NOT NULL ,
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME NULL,
  `lockedcomments` TINYINT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;;
DELIMITER ;;
CREATE TRIGGER before_insert_pages
BEFORE INSERT ON pages
FOR EACH ROW
BEGIN
   SET new.id = replace(uuid(),'-','');
END
;;

CREATE TABLE `comments` (
  `id` varchar(32) NOT NULL,
  `parentId` varchar(32) NULL,
  `commentText` TEXT NOT NULL,
  `userId` varchar(32) NOT NULL,
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME NULL,
  `pageId` varchar(32) NOT NULL,
  `approved` TINYINT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT FK_user_comment FOREIGN KEY (userId) REFERENCES users(id),
  CONSTRAINT FK_comment_parentComment FOREIGN KEY (parentId) REFERENCES comments(id),
  CONSTRAINT FK_comment_page FOREIGN KEY (pageId) REFERENCES pages(id)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;;
DELIMITER ;;
CREATE TRIGGER before_insert_comments
BEFORE INSERT ON comments
FOR EACH ROW
BEGIN
   SET new.id = replace(uuid(),'-','');
END
;;

-- ALTER TABLE `comments` 
-- ADD CONSTRAINT `FK_user_comment` FOREIGN KEY (`userId`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- ALTER TABLE `comments` 
-- ADD CONSTRAINT `FK_comment_parentComment` FOREIGN KEY (`parentId`) REFERENCES `comments`(`id`);

-- ALTER TABLE `comments` 
-- ADD CONSTRAINT `FK_comment_page` FOREIGN KEY (`pageId`) REFERENCES `pages`(`id`);
--
INSERT INTO configuration(name, data)
VALUES('manualPages','false')
,('moderateComments','false')
,('contactFormEmails','admin@me.com,test@me.com')
,('unlimitedReplies','false')	
,('facebookToken','');
;;
-- test insert data
INSERT INTO users(email, password)
VALUES('test@me.com','has');
;;
INSERT INTO users(email, password,clientLevel)
VALUES('admin@me.com','has', 3);
;;
INSERT INTO pages(slug,lockedComments)
VALUES('test',0);
;;
INSERT INTO contactForm(email,subject,message)
VALUES('test@me.com','test sub', 'test message');
;;

-- select top 1 * from pages;
SELECT @pageId:=id FROM pages LIMIT 1;
SELECT @userId:=id FROM users LIMIT 1;
INSERT INTO comments(commentText, userId,pageId)
VALUES('teset text',@userId, @pageId);

-- select @pageId
select * from comments

-- VALUES(uuid(),'test@me.com','has');

-- replace(uuid(),'-','')
-- varchar(32)
-- will wrok w/ binary, but unreadable from db, appears as blob, keep varchar for simplicity
-- unhex(replace(uuid(),'-',''))

;;
select * from users;
;;
select * from contactForm;
;;
select * from pages;
;;
select * from comments;

select * from configuration;