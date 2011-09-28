<?php 

$up = "
CREATE TABLE `messages` (
  `MID` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `SUID` INT UNSIGNED NOT NULL ,
  `RUID` INT UNSIGNED NOT NULL ,
  `subject` VARCHAR(255) NOT NULL ,
  `message` TEXT NULL ,
  `type` TINYINT(1)  NOT NULL ,
  `timecreate` DATETIME NULL,
  PRIMARY KEY (`MID`) ,
  UNIQUE INDEX `MID_UNIQUE` (`MID` ASC) ,
  INDEX `fk_message.suid.users.uid` (`SUID` ASC) ,
  INDEX `fk_message.ruid.users.uid` (`RUID` ASC) ,
    
  CONSTRAINT `fk_message.suid.users.uid`
    FOREIGN KEY (`SUID` )
    REFERENCES `users` (`UID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_message.ruid.users.uid`
    FOREIGN KEY (`RUID` )
    REFERENCES `users` (`UID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8

COLLATE = utf8_unicode_ci;


/*NOT CORE */
CREATE  TABLE IF NOT EXISTS `comments` (
  `CID` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `comment` TEXT NOT NULL ,
  `comment_html` TEXT NOT NULL,
  `comment_PID` INT UNSIGNED NOT NULL ,
  `comment_UID` INT UNSIGNED NOT NULL ,
  `comment_CID` INT UNSIGNED NULL ,
  `timecreate` DATETIME NULL ,
  PRIMARY KEY (`CID`) ,
  INDEX `COMMENT_UID_INDEX` (`comment_UID` ASC) ,
  INDEX `COMMENT_PID_INDEX` (`comment_PID` ASC) ,
  INDEX `COMMENT_CID_INDEX` (`comment_CID` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

CREATE  TABLE IF NOT EXISTS `mentions` (
  `MID` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `mention_CID` INT UNSIGNED NOT NULL ,
  `mention_UID` INT UNSIGNED NOT NULL ,
  `read` TINYINT(1) UNSIGNED NOT NULL ,
  PRIMARY KEY (`MID`) ,
  INDEX `MENTION_CID_INDEX` (`mention_CID` ASC) ,
  INDEX `MENTION_UID_INDEX` (`mention_UID` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

CREATE  TABLE IF NOT EXISTS `follow` (
  `FID` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `follow_uid` INT UNSIGNED NOT NULL ,
  `target_uid` INT UNSIGNED NOT NULL ,
  `target_gid` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`FID`) ,
  INDEX `follow_uid_INDEX` (`follow_uid` ASC) ,
  INDEX `target_uid_INDEX` (`target_uid` ASC) ,
  INDEX `target_gid_INDEX` (`target_gid` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;
";
  
$down = "
DROP TABLE `comments`
";

$test = "SELECT * FROM `users`";

$dbh = new PDO('mysql:host=localhost;dbname=netcoid', 'root', '');

#$dbh->exec($up)
#$dbh->exec($down)
$dbh->exec($test)
or die(print_r($dbh->errorInfo(), true));
?>