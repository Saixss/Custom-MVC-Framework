CREATE TABLE `users` (
    `user_id` INT(11) NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
    `password` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
    `first_name` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
    `last_name` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
    PRIMARY KEY (`user_id`) USING BTREE,
    UNIQUE INDEX (`username`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;