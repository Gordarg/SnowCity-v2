-- MySQL Workbench Forward Engineering


-- With update 28
-- Version 1.8.0.0

-- -----------------------------------------------------
-- Schema gordcms
-- -----------------------------------------------------

-- CREATE SCHEMA IF NOT EXISTS `gordcms` DEFAULT CHARACTER SET latin1 ;
-- USE `gordcms` ;

-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(45) NULL DEFAULT NULL,
  `HashPassword` TINYTEXT NULL DEFAULT NULL,
  `IsActive` BIT(1) NULL DEFAULT b'1',
  `Role` CHAR(5) NULL DEFAULT 'VSTOR',
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `Username` (`Username` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 20
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `posts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `posts` (
  `MasterId` CHAR(36) NOT NULL,
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(400) NULL DEFAULT NULL,
  `Submit` DATETIME NOT NULL,
  `Type` CHAR(5) NOT NULL DEFAULT 'POST' COMMENT 'POST, FILE, ARTL, COMT, SURV, QUST, ANSR,CHAT,TRNL,QUOT',
  `Level` CHAR(2) NULL DEFAULT 'DC' COMMENT 'Data Content by default. Other SEO and publish levels must be declared with integrers.',
  `BinContent` LONGBLOB NULL DEFAULT NULL,
  `Body` LONGTEXT NULL DEFAULT NULL,
  `UserId` INT(11) NULL DEFAULT NULL,
  `Status` CHAR(7) NULL DEFAULT 'DRAFT' COMMENT 'Post lifecycle',
  `Language` VARCHAR(5) NULL DEFAULT 'en-us',
  `RefrenceId` CHAR(36) NULL DEFAULT NULL,
  `Index` SMALLINT(6) NULL DEFAULT NULL,
  `IsDeleted` BIT(1) NOT NULL DEFAULT b'0',
  `IsContentDeleted` BIT(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`Id`, `MasterId`),
  INDEX `fk_posts_user_idx` (`UserId` ASC),
  CONSTRAINT `fk_posts_user`
    FOREIGN KEY (`UserId`)
    REFERENCES `users` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 221
DEFAULT CHARACTER SET = latin1;

-- USE `gordcms` ;

-- -----------------------------------------------------
-- Placeholder table for view `post_contributers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `post_contributers` (`MasterID` INT, `ID` INT, `UserID` INT, `Username` INT, `Submit` INT, `Language` INT);

-- -----------------------------------------------------
-- Placeholder table for view `post_details`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `post_details` (`MasterID` INT, `Title` INT, `ID` INT, `Submit` INT, `UserID` INT, `Username` INT, `Body` INT, `Type` INT, `Level` INT, `RefrenceID` INT, `Index` INT, `Status` INT, `Language` INT, `BinContent` INT);

-- -----------------------------------------------------
-- View `post_contributers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `post_contributers`;
-- USE `gordcms`;
CREATE OR REPLACE VIEW `post_contributers` AS select `P`.`MasterId` AS `MasterID`,`P`.`Id` AS `ID`,`P`.`UserId` AS `UserID`,`U`.`Username` AS `Username`,`P`.`Submit` AS `Submit`,`P`.`Language` AS `Language` from (`posts` `P` join `users` `U` on((`P`.`UserId` = `U`.`Id`)));

-- -----------------------------------------------------
-- View `post_details`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `post_details`;
-- USE `gordcms`;
CREATE OR REPLACE VIEW `post_details` AS 
SELECT `P`.`masterid`   AS `MasterID`, 
       `P`.`title`      AS `Title`, 
       `P`.`id`         AS `ID`, 
       `P`.`submit`     AS `Submit`, 
       `P`.`userid`     AS `UserID`, 
       `U`.`username`   AS `Username`, 
       `P`.`body`       AS `Body`, 
       `P`.`type`       AS `Type`, 
       `P`.`level`      AS `Level`, 
       `P`.`refrenceid` AS `RefrenceID`, 
       `P`.`index`      AS `Index`, 
       `P`.`status`     AS `Status`, 
       `P`.`language`   AS `Language`, 
       ( CASE 
           WHEN ( (SELECT `P2`.`submit` 
                   FROM   `posts` `P2` 
                   WHERE  ( ( `P2`.`iscontentdeleted` = 1 ) 
                            AND ( `P`.`masterid` = `P2`.`masterid` ) ) 
                   ORDER  BY `P2`.`submit` DESC 
                   LIMIT  1) > (SELECT `P1`.`submit` 
                                FROM   `posts` `P1` 
                                WHERE  ( ( `P1`.`bincontent` IS NOT NULL ) 
                                         AND ( `P`.`masterid` = 
                                             `P1`.`masterid` ) ) 
                                ORDER  BY `P1`.`submit` DESC 
                                LIMIT  1) ) THEN NULL 
           ELSE (SELECT `P1`.`bincontent` 
                 FROM   `posts` `P1` 
                 WHERE  ( ( `P1`.`bincontent` IS NOT NULL ) 
                          AND ( `P`.`masterid` = `P1`.`masterid` ) ) 
                 ORDER  BY `P1`.`submit` DESC 
                 LIMIT  1) 
         end )          AS `BinContent` 
FROM   (`posts` `P` 
        JOIN `users` `U` 
          ON(( `P`.`userid` = `U`.`id` ))) 
WHERE  ( `P`.`id` IN (SELECT Max(`posts`.`id`) 
                      FROM   `posts` 
                      GROUP  BY `posts`.`masterid`, 
                                `posts`.`language`) 
         AND ( `P`.`isdeleted` = '0' ) ) 