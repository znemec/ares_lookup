CREATE TABLE `test`.`ares` ( `id` INT NOT NULL AUTO_INCREMENT , `ico` VARCHAR(8) NOT NULL , `name` VARCHAR(50) NOT NULL , `address` VARCHAR(50) NULL DEFAULT NULL , `city` VARCHAR(50) NULL DEFAULT NULL , `zip` INT(15) NULL DEFAULT NULL , `dic` VARCHAR(15) NULL DEFAULT NULL , `date` VARCHAR(25) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;