CREATE TABLE `hotspot`.`users` ( 
    `user_id` INT NOT NULL AUTO_INCREMENT , 
    `nickname` VARCHAR(15) NOT NULL , 
    `email` VARCHAR(30) NOT NULL , 
    `password` VARCHAR(50) NOT NULL , 
    `salt` VARCHAR(50) NOT NULL , 
    `token` VARCHAR(50) NOT NULL DEFAULT '0', 
    `account_token` VARCHAR(50) NOT NULL , 
    `status` TINYINT NOT NULL DEFAULT '0' , 
    PRIMARY KEY (`user_id`)) ENGINE = InnoDB;

CREATE TABLE `hotspot`.`posts` ( 
    `post_id` INT NOT NULL AUTO_INCREMENT , 
    `title` VARCHAR(50) NOT NULL , 
    `text` TEXT NOT NULL , 
    `publication_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `user_id` INT NOT NULL , 
    `image_url` VARCHAR(100) NOT NULL , 
    `short_desc` TEXT NOT NULL ,
    `likes` INT NOT NULL DEFAULT '0' AFTER `short_desc` , 
    `dislikes` INT NOT NULL DEFAULT '0' ,
    PRIMARY KEY (`post_id`)) ENGINE = InnoDB;

ALTER TABLE `posts` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) 
ON DELETE NO ACTION ON UPDATE CASCADE;

CREATE TABLE `hotspot`.`comments` ( 
    `comment_id` INT NOT NULL AUTO_INCREMENT , 
    `text` TEXT NOT NULL , 
    `publication_time` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `user_id` INT NOT NULL , 
    `post_id` INT NOT NULL , 
    PRIMARY KEY (`comment_id`)) ENGINE = InnoDB;