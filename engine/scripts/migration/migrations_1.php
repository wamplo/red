<?php 

$up = "
CREATE TABLE `users` (
  `UID` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(200) NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(255) NOT NULL ,
  `phone` VARCHAR(30) NOT NULL ,
  `logo` VARCHAR(255) NULL ,
  `seal_image` VARCHAR(255) NULL , 
  `seal_date` DATETIME NULL , 
#ALTER TABLE users ADD COLUMN seal_image VARCHAR(255) NULL AFTER logo; 
#ALTER TABLE users ADD COLUMN seal_date DATETIME NULL AFTER seal_image; 
#ALTER TABLE users ADD COLUMN reset VARCHAR(255) NULL AFTER facebook; 
#ALTER TABLE users DROP COLUMN image_seal;  
  `address` VARCHAR(100) NULL ,
  `information` TEXT NULL ,
  `information_html` TEXT NULL ,
#ALTER TABLE users ADD COLUMN information_html TEXT NULL AFTER information; 
  `announcement` TEXT NULL ,
  `role` INT UNSIGNED NULL ,
  `yahoo` VARCHAR(100) NULL ,
  `twitter` VARCHAR(20) NULL ,
  `facebook` VARCHAR(255) NULL ,
  `reset` VARCHAR(255) NULL ,
#ALTER TABLE users ADD COLUMN timeregister DATETIME NULL AFTER reset; 
#ALTER TABLE users CHANGE timeregister time_register DATETIME NULL;
#ALTER TABLE users CHANGE timelogin time_login DATETIME NULL;
  `timeregister` DATETIME NULL,
  `timelogin` DATETIME NULL,
  PRIMARY KEY (`UID`) ,
  UNIQUE INDEX `UID_UNIQUE` (`UID` ASC) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) ,
  UNIQUE INDEX `logo_UNIQUE` (`logo` ASC) ,	
  UNIQUE INDEX `username_UNIQUE` (`username` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
#ALTER TABLE users ADD COLUMN facebook VARCHAR(255) NULL AFTER twitter;  
COLLATE = utf8_unicode_ci;
";

$down = "
DROP TABLE `users`
";

$test = "SELECT * FROM `users`";

$dbh = new PDO('mysql:host=localhost;dbname=netcoid', 'root', '');

$dbh->exec($test) 
or die(print_r($dbh->errorInfo(), true));
?>