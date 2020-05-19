
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- job
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `job`;

CREATE TABLE `job`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `link` VARCHAR(255) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `budget` INTEGER,
    `category` VARCHAR(255) NOT NULL,
    `country` VARCHAR(255) NOT NULL,
    `deleted` TINYINT(1),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- job_skill
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `job_skill`;

CREATE TABLE `job_skill`
(
    `job_id` INTEGER NOT NULL,
    `skill_id` INTEGER NOT NULL,
    PRIMARY KEY (`job_id`,`skill_id`),
    INDEX `skill_id` (`skill_id`),
    CONSTRAINT `job_skill_ibfk_1`
        FOREIGN KEY (`job_id`)
        REFERENCES `job` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `job_skill_ibfk_2`
        FOREIGN KEY (`skill_id`)
        REFERENCES `skill` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- skill
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `skill`;

CREATE TABLE `skill`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `skill` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
