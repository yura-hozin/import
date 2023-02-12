CREATE TABLE `admin_import_list` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`date_create` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
	`status` TINYINT(4) NOT NULL DEFAULT '0',
	`date_begin` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
	`date_end` TIMESTAMP NULL DEFAULT NULL ON UPDATE current_timestamp(),
	`comment` TEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;

CREATE TABLE `admin_import_tmp` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`key` INT(11) NOT NULL DEFAULT '0',
	`data` TEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	`type` TINYINT(2) NULL DEFAULT '0',
	`status` TINYINT(1) NULL DEFAULT '0',
	`comment` TEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	`create_date` TIMESTAMP NULL DEFAULT current_timestamp(),
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `key` (`key`, `type`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;

CREATE TABLE `admin_import_model` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(127) NOT NULL DEFAULT '',
	`path` VARCHAR(64) NOT NULL DEFAULT '',
	`source` TINYINT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
