CREATE DATABASE IF NOT EXISTS `sports_tournament_db`
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sports_tournament_db`;

-- users
CREATE TABLE IF NOT EXISTS `users` (
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `full_name`  VARCHAR(100) NOT NULL,
    `username`   VARCHAR(50)  NOT NULL UNIQUE,
    `email`      VARCHAR(100) NOT NULL UNIQUE,
    `password`   VARCHAR(255) NOT NULL,
    `role`       ENUM('admin','coach','employee','spectator') NOT NULL DEFAULT 'spectator',
    `status`     ENUM('active','suspended') NOT NULL DEFAULT 'active',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- tournaments
CREATE TABLE IF NOT EXISTS `tournaments` (
    `id`              INT AUTO_INCREMENT PRIMARY KEY,
    `tournament_name` VARCHAR(150) NOT NULL,
    `tournament_type` ENUM('League','Knockout','Group+Knockout') NOT NULL,
    `status`          ENUM('Upcoming','Ongoing','Completed') NOT NULL DEFAULT 'Upcoming',
    `start_date`      DATE NOT NULL,
    `end_date`        DATE NOT NULL,
    `created_at`      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- teams
CREATE TABLE IF NOT EXISTS `teams` (
    `id`            INT AUTO_INCREMENT PRIMARY KEY,
    `tournament_id` INT NULL,
    `coach_id`      INT NULL,
    `team_name`     VARCHAR(100) NOT NULL,
    `coach_email`   VARCHAR(100) NOT NULL,
    `squad_size`    INT DEFAULT 15,
    `fee_status`    ENUM('Pending','Paid') DEFAULT 'Pending',
    `fee_amount`    DECIMAL(10,2) DEFAULT 50000.00,
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`tournament_id`) REFERENCES `tournaments`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`coach_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- players
CREATE TABLE IF NOT EXISTS `players` (
    `id`             INT AUTO_INCREMENT PRIMARY KEY,
    `team_id`        INT NOT NULL,
    `player_name`    VARCHAR(100) NOT NULL,
    `position`       VARCHAR(50) NOT NULL,
    `matches_played` INT DEFAULT 0,
    `points`         INT DEFAULT 0,
    `assists`        INT DEFAULT 0,
    `rating`         DECIMAL(3,1) DEFAULT 7.0,
    `is_injured`     TINYINT(1) DEFAULT 0,
    FOREIGN KEY (`team_id`) REFERENCES `teams`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- venues
CREATE TABLE IF NOT EXISTS `venues` (
    `id`                 INT AUTO_INCREMENT PRIMARY KEY,
    `venue_name`         VARCHAR(150) NOT NULL,
    `city`               VARCHAR(50) NOT NULL,
    `field_cleaning_pct` INT DEFAULT 80,
    `seating_pct`        INT DEFAULT 100,
    `created_at`         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- equipment inventory
CREATE TABLE IF NOT EXISTS `equipment` (
    `id`        INT AUTO_INCREMENT PRIMARY KEY,
    `item_name` VARCHAR(100) NOT NULL,
    `quantity`  INT NOT NULL DEFAULT 0,
    `status`    ENUM('Available','Low Stock','Out of Stock') DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- preparation tasks (employee checklist)
CREATE TABLE IF NOT EXISTS `preparation_tasks` (
    `id`             INT AUTO_INCREMENT PRIMARY KEY,
    `task_title`     VARCHAR(255) NOT NULL,
    `is_urgent`      TINYINT(1) DEFAULT 0,
    `is_completed`   TINYINT(1) DEFAULT 0,
    `assigned_staff` VARCHAR(100) DEFAULT 'Staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- incidents / maintenance reports
CREATE TABLE IF NOT EXISTS `incidents` (
    `id`            INT AUTO_INCREMENT PRIMARY KEY,
    `problem_type`  VARCHAR(50) NOT NULL,
    `location_area` VARCHAR(150) NOT NULL,
    `description`   TEXT NOT NULL,
    `status`        ENUM('Pending','In Progress','Resolved') DEFAULT 'Pending',
    `reported_by`   VARCHAR(100) DEFAULT 'Staff',
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- spectator tickets
CREATE TABLE IF NOT EXISTS `tickets` (
    `id`             INT AUTO_INCREMENT PRIMARY KEY,
    `user_id`        INT NULL,
    `match_title`    VARCHAR(150) NOT NULL,
    `order_no`       VARCHAR(50) NOT NULL UNIQUE,
    `seat_category`  VARCHAR(50) DEFAULT 'VIP Gallery',
    `ticket_count`   INT DEFAULT 2,
    `payment_status` ENUM('Pending','Paid') DEFAULT 'Paid',
    `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- fan match predictions
CREATE TABLE IF NOT EXISTS `match_predictions` (
    `id`               INT AUTO_INCREMENT PRIMARY KEY,
    `match_name`       VARCHAR(150) NOT NULL,
    `predicted_winner` VARCHAR(100) NOT NULL,
    `voted_at`         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- activity log
CREATE TABLE IF NOT EXISTS `activity_log` (
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `user_id`    INT NULL,
    `username`   VARCHAR(50)  NOT NULL,
    `role`       VARCHAR(20)  NOT NULL,
    `action`     VARCHAR(255) NOT NULL,
    `ip`         VARCHAR(45)  NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- sample data
INSERT INTO `tournaments` (`tournament_name`, `tournament_type`, `status`, `start_date`, `end_date`) VALUES
('Dhaka Premier League (DPL)', 'League', 'Ongoing', '2024-06-01', '2024-07-15'),
('Independence Cup', 'Knockout', 'Upcoming', '2024-08-10', '2024-08-25');

INSERT INTO `venues` (`venue_name`, `city`, `field_cleaning_pct`, `seating_pct`) VALUES
('Bangabandhu National Stadium', 'Dhaka', 85, 100),
('Sylhet International Cricket Stadium', 'Sylhet', 90, 95);

INSERT INTO `equipment` (`item_name`, `quantity`, `status`) VALUES
('Basketballs', 12, 'Available'),
('Nets', 4, 'Available'),
('Referee Whistles', 6, 'Available'),
('First Aid Kit', 3, 'Available');

INSERT INTO `preparation_tasks` (`task_title`, `is_urgent`, `is_completed`, `assigned_staff`) VALUES
('Provide water bottles in dressing rooms', 0, 1, 'Staff'),
('Check scoreboard and shot clock', 0, 1, 'Staff'),
('Prepare referee equipment', 1, 0, 'Staff'),
('Ensure VIP gallery is clean', 0, 0, 'Staff');

INSERT INTO `teams` (`tournament_id`, `coach_id`, `team_name`, `coach_email`, `squad_size`, `fee_status`, `fee_amount`) VALUES
(1, 2, 'Abahani Limited', 'coach@tournamentpro.com', 18, 'Paid', 50000.00),
(1, 2, 'Mohammedan SC', 'coach@tournamentpro.com', 18, 'Paid', 50000.00),
(1, 2, 'Dhaka Dynamites', 'coach@tournamentpro.com', 15, 'Paid', 50000.00);
