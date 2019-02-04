CREATE TABLE `spotify`.`users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(25) NOT NULL,
    `firstName` VARCHAR(50) NOT NULL,
    `lastName` VARCHAR(50) NOT NULL,
    `email` VARCHAR(200) NOT NULL,
    `password` VARCHAR(32) NOT NULL,
    `signUpDate` DATETIME NOT NULL,
    `profilePic` VARCHAR(500) NOT NULL,
    PRIMARY KEY (`id`)
);