<?php 

$up = "
ALTER TABLE users CHANGE timeregister time_register DATETIME NULL;
ALTER TABLE users CHANGE timelogin time_login DATETIME NULL;
ALTER TABLE messages CHANGE timecreate time_create DATETIME NULL;
ALTER TABLE comments CHANGE timecreate time_create DATETIME NULL;
ALTER TABLE users CHANGE reset token VARCHAR(255) NULL ,
ALTER TABLE users ADD COLUMN domain VARCHAR(255) NULL AFTER role;

#rename table netcoid_comments to comments;
#rename table netcoid_follow to follow;
#rename table netcoid_groups to groups;
#rename table netcoid_mentions to mentions;
#rename table netcoid_posts to posts;
#rename table netcoid_users to users;
#rename table netcoid_messages to messages;

CREATE TABLE `vipusers` (
  `VUID` INT UNSIGNED NOT NULL ,
  `UID_ACC` INT UNSIGNED NOT NULL ,
  `UID_REP` INT UNSIGNED NOT NULL ,
  `time_registered` DATETIME NOT NULL ,
  `time_expire` DATETIME NOT NULL ,
  `comments` TEXT NULL ,
  PRIMARY KEY (`VUID`) ,
  UNIQUE INDEX `VUID_UNIQUE` (`VUID` ASC) ,
  UNIQUE INDEX `UID_ACC_UNIQUE` (`UID_ACC` ASC) ,
  UNIQUE INDEX `UID_REP_UNIQUE` (`UID_REP` ASC),

  # FK UID_ACC FROM USERS.UID
  INDEX `fk_vipusers.uid_acc.users.uid` (`UID_ACC` ASC) ,
  CONSTRAINT `fk_vipusers.uid_acc.users.uid`
  FOREIGN KEY (`UID_ACC` )
  REFERENCES `users` (`UID` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,

  # FK UID_REP FROM USERS.UID
  INDEX `fk_vipusers.uid_rep.users.uid` (`UID_REP` ASC) ,
  CONSTRAINT `fk_vipusers.uid_rep.users.uid`
  FOREIGN KEY (`UID_REP` )
  REFERENCES `users` (`UID` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION

  )
ENGINE = InnoDB;
";


$down = "
DROP TABLE `vipusers`

ALTER TABLE users CHANGE time_register timeregister DATETIME NULL;
ALTER TABLE users CHANGE time_login timelogin DATETIME NULL;
ALTER TABLE messages CHANGE time_create timecreate DATETIME NULL;
ALTER TABLE comments CHANGE time_create timecreate DATETIME NULL;
";

$test = "SELECT * FROM `users`";

$dbh = new PDO('mysql:host=localhost;dbname=netcoid', 'root', '');

$dbh->exec($test) 
or die(print_r($dbh->errorInfo(), true));
?>