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
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `configuration_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
 CREATE TABLE `users` (
   `id` varchar(36) NOT NULL,
   `email` varchar(40) NOT NULL,
   `password` varchar(255) NOT NULL,
   `clientLevel` enum('1','2','3') NOT NULL DEFAULT '1',
   UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DELIMITER ;;
CREATE TRIGGER before_insert_users
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
   SET new.id = uuid();
END
;;

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` varchar(36) NOT NULL,
  `slut` NOT NULL varchar(255),
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
  `deleted_at` DATETIME NULL,
  `lockedcomments` TINYINT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DELIMITER ;;
CREATE TRIGGER before_insert_pages
BEFORE INSERT ON pages
FOR EACH ROW
BEGIN
   SET new.id = uuid();
END
;;

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` varchar(36) NOT NULL,
  `parentId` varchar(36) NULL,
  `commentText` TEXT NOT NULL,
  `userId` varchar(36) NOT NULL,
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
  `deleted_at` DATETIME NULL,
  `pageId` varchar(36) NOT NULL,
  `approved` TINYINT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DELIMITER ;;
CREATE TRIGGER before_insert_comments
BEFORE INSERT ON comments
FOR EACH ROW
BEGIN
   SET new.id = uuid();
END
;;

ALTER TABLE `comments` 
ADD CONSTRAINT `FK_user_comment` FOREIGN KEY (`userId`) REFERENCES `users`(`id`); -- ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `comments` 
ADD CONSTRAINT `FK_comment_parentComment` FOREIGN KEY (`parentId`) REFERENCES `comments`(`id`);

ALTER TABLE `comments` 
ADD CONSTRAINT `FK_comment_page` FOREIGN KEY (`pageId`) REFERENCES `pages`(`id`);


INSERT INTO users(email, password)
VALUES('test@me.com','has');
;;

-- VALUES(uuid(),'test@me.com','has');

-- replace(uuid(),'-','')
-- varchar(36)
-- will wrok w/ binary, but unreadable from db, appears as blob, keep varchar for simplicity
-- unhex(replace(uuid(),'-',''))

