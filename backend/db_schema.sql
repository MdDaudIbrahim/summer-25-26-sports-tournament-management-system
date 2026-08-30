-- ==========================================
-- SPORTS TOURNAMENT MANAGEMENT SYSTEM
-- MySQL Database Schema (AIUB Web Tech Pattern)
-- ==========================================

CREATE DATABASE IF NOT EXISTS `sports_tournament_db`;
USE `sports_tournament_db`;

-- 1. Users Table (Admin, Coach, Spectator, Employee)
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'coach', 'employee', 'spectator') NOT NULL DEFAULT 'spectator',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tournaments Table
CREATE TABLE IF NOT EXISTS `tournaments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tournament_name` VARCHAR(150) NOT NULL,
  `tournament_type` ENUM('League', 'Knockout', 'Group+Knockout') NOT NULL,
  `status` ENUM('Upcoming', 'Ongoing', 'Completed') NOT NULL DEFAULT 'Upcoming',
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Teams Table
CREATE TABLE IF NOT EXISTS `teams` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tournament_id` INT,
  `team_name` VARCHAR(100) NOT NULL,
  `coach_email` VARCHAR(100) NOT NULL,
  `squad_size` INT DEFAULT 15,
  `fee_status` ENUM('Pending', 'Paid') DEFAULT 'Paid',
  `fee_amount` DECIMAL(10,2) DEFAULT 50000.00,
  FOREIGN KEY (`tournament_id`) REFERENCES `tournaments`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Players Table
CREATE TABLE IF NOT EXISTS `players` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `team_id` INT,
  `player_name` VARCHAR(100) NOT NULL,
  `position` VARCHAR(20) NOT NULL,
  `matches_played` INT DEFAULT 0,
  `points` INT DEFAULT 0,
  `assists` INT DEFAULT 0,
  `rating` DECIMAL(3,1) DEFAULT 7.0,
  `is_injured` TINYINT(1) DEFAULT 0,
  FOREIGN KEY (`team_id`) REFERENCES `teams`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Venues & Schedules Table
CREATE TABLE IF NOT EXISTS `venues` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `venue_name` VARCHAR(150) NOT NULL,
  `city` VARCHAR(50) NOT NULL,
  `field_cleaning_pct` INT DEFAULT 80,
  `seating_pct` INT DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Equipment Inventory Table
CREATE TABLE IF NOT EXISTS `equipment` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `item_name` VARCHAR(100) NOT NULL,
  `quantity` INT NOT NULL DEFAULT 0,
  `status` VARCHAR(50) DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Employee Preparation Tasks Table
CREATE TABLE IF NOT EXISTS `preparation_tasks` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `task_title` VARCHAR(255) NOT NULL,
  `is_urgent` TINYINT(1) DEFAULT 0,
  `is_completed` TINYINT(1) DEFAULT 0,
  `assigned_staff` VARCHAR(100) DEFAULT 'Rahim Mia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. Incidents / Maintenance Reports Table
CREATE TABLE IF NOT EXISTS `incidents` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `problem_type` VARCHAR(50) NOT NULL,
  `location_area` VARCHAR(150) NOT NULL,
  `description` TEXT NOT NULL,
  `status` ENUM('Pending', 'In Progress', 'Resolved') DEFAULT 'Pending',
  `reported_by` VARCHAR(100) DEFAULT 'Staff',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 9. Spectator Tickets Table
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT,
  `match_title` VARCHAR(150) NOT NULL,
  `order_no` VARCHAR(50) NOT NULL UNIQUE,
  `seat_category` VARCHAR(50) DEFAULT 'VIP Gallery',
  `ticket_count` INT DEFAULT 2,
  `payment_status` ENUM('Pending', 'Paid') DEFAULT 'Paid',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 10. Fan Predictions Table
CREATE TABLE IF NOT EXISTS `match_predictions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `match_name` VARCHAR(150) NOT NULL,
  `predicted_winner` VARCHAR(100) NOT NULL,
  `voted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- Sample Seed Data
-- ==========================================
INSERT INTO `users` (`full_name`, `email`, `password`, `role`) VALUES
('Admin Officer', 'admin@tournamentpro.com', 'admin123', 'admin'),
('Coach Tariq', 'coach@tournamentpro.com', 'coach123', 'coach'),
('Rahim Mia', 'employee@tournamentpro.com', 'employee123', 'employee'),
('Spectator Fan', 'fan@tournamentpro.com', 'spectator123', 'spectator');

INSERT INTO `tournaments` (`tournament_name`, `tournament_type`, `status`, `start_date`, `end_date`) VALUES
('Dhaka Premier League (DPL)', 'League', 'Ongoing', '2024-06-01', '2024-07-15'),
('Independence Cup', 'Knockout', 'Upcoming', '2024-08-10', '2024-08-25');

INSERT INTO `teams` (`tournament_id`, `team_name`, `coach_email`, `squad_size`, `fee_status`, `fee_amount`) VALUES
(1, 'Dhaka Warriors', 'coach@tournamentpro.com', 15, 'Paid', 50000.00),
(1, 'Abahani Limited', 'abahani@sports.bd', 18, 'Paid', 50000.00),
(1, 'Mohammedan SC', 'mohammedan@sports.bd', 18, 'Paid', 50000.00);

INSERT INTO `players` (`team_id`, `player_name`, `position`, `matches_played`, `points`, `assists`, `rating`, `is_injured`) VALUES
(1, 'Jamal Bhuyan', 'Captain (MID)', 5, 12, 8, 8.5, 0),
(1, 'Topu Barman', 'Defender (DEF)', 4, 3, 1, 7.2, 1),
(1, 'Zico', 'Point Guard (PG)', 5, 10, 6, 8.0, 0),
(1, 'Rakib', 'Shooting Guard (SG)', 5, 14, 4, 7.8, 0),
(1, 'Anik', 'Center (C)', 5, 8, 9, 7.6, 0);

INSERT INTO `equipment` (`item_name`, `quantity`, `status`) VALUES
('Basketballs', 12, 'Available'),
('Nets', 4, 'Available');

INSERT INTO `preparation_tasks` (`task_title`, `is_urgent`, `is_completed`, `assigned_staff`) VALUES
('Provide water bottles in dressing rooms', 0, 1, 'Rahim Mia'),
('Check scoreboard and shot clock', 0, 1, 'Rahim Mia'),
('Prepare referee equipment', 1, 0, 'Rahim Mia'),
('Ensure VIP gallery is clean', 0, 0, 'Rahim Mia');
