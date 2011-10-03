<?php 

$up = "
/*NOT CORE */
CREATE  TABLE IF NOT EXISTS `posts` (
  `PID` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NOT NULL ,
  `content` TEXT NOT NULL ,
  `content_html` TEXT NOT NULL ,
  `time_create` DATETIME NOT NULL ,
  `time_update` DATETIME NOT NULL ,
  `time_bump` DATETIME NULL ,
  `status` INT NOT NULL ,
  `post_UID` INT UNSIGNED NOT NULL ,
  `count_views` INT UNSIGNED NULL DEFAULT 0 ,
  `count_reply` INT UNSIGNED NULL DEFAULT 0 ,

  # ALTER TABLE posts DROP COLUMN post_views
  # ALTER TABLE posts ADD COLUMN count_views INT UNSIGNED NOT NULL DEFAULT 0 AFTER status; 
  # ALTER TABLE posts ADD COLUMN count_reply INT UNSIGNED NOT NULL DEFAULT 0 AFTER status; 

  `post_GID` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`PID`) ,
  UNIQUE INDEX `PID_UNIQUE` (`PID` ASC) ,
  INDEX `POST_GID_INDEX` (`post_gid` ASC) ,
  INDEX `POST_UID_INDEX` (`post_uid` ASC) ,
  INDEX `STATUS_INDEX` (`status` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

/*NOT CORE */
CREATE  TABLE IF NOT EXISTS `groups` (
  `GID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL ,
  `parent_GID` INT UNSIGNED NULL ,
  `description` TEXT NOT NULL ,
  `description_html` TEXT NOT NULL ,
  `status` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`GID`) ,
  INDEX `NAME_INDEX` (`name` ASC) ,
  INDEX `PARENT_GID_INDEX` (`parent_GID` ASC) ,
  INDEX `STATUS_INDEX` (`status` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;
";

# status
# 0 = category
# 1 = groups admin post
# 2 = groups all post ( trade + posts )
# 3 = groups all post ( posts )
# 4 = groups all post ( trade )
# 5 = groups disabled

$down = "
DROP TABLE `users`
";

$test = "SELECT * FROM `users`";

$dbh = new PDO('mysql:host=localhost;dbname=netcoid', 'root', '');

$dbh->exec($test) 
or die(print_r($dbh->errorInfo(), true));
?>