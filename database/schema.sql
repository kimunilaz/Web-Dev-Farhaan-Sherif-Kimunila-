
-- X-Men Roster Manager - Database Schema
-- Run this file to create the database, tables,
-- and seed data. Example:



CREATE DATABASE IF NOT EXISTS xmen_roster CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE xmen_roster;

-- ------------------------------------------------
-- Table: heroes
-- ------------------------------------------------
DROP TABLE IF EXISTS heroes;
CREATE TABLE heroes (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    hero_name     VARCHAR(100) NOT NULL,
    real_name     VARCHAR(100) NOT NULL,
    short_bio     VARCHAR(255) NOT NULL,
    long_bio      TEXT NOT NULL,
    image_url     VARCHAR(255) DEFAULT NULL,
    powers        VARCHAR(255) DEFAULT NULL,
    team          VARCHAR(100) DEFAULT 'X-Men',
    publisher     VARCHAR(100) DEFAULT 'Marvel Comics',
    status        VARCHAR(50)  DEFAULT 'Active',
    date_created  DATE DEFAULT NULL
);

-- ------------------------------------------------
-- Table: users  (for authentication)
-- ------------------------------------------------
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    username      VARCHAR(50) NOT NULL UNIQUE,
    password      VARCHAR(255) NOT NULL  -- stored as a bcrypt hash, never plain text
);

-- ------------------------------------------------
-- Seed data: heroes
-- ------------------------------------------------
INSERT INTO heroes (hero_name, real_name, short_bio, long_bio, image_url, powers, team, publisher, status, date_created) VALUES
('Cyclops', 'Scott Summers', 'Field leader of the X-Men with optic blast powers.',
 'Scott Summers was one of Professor Xavier''s first students and has served as the primary field leader of the X-Men for most of the team''s history. He fires concussive energy beams from his eyes that he can only control through a specialized visor or glasses.',
 'images/cyclops.jpeg',
 'Optic energy blasts', 'X-Men', 'Marvel Comics', 'Active', '1963-09-01'),

('Jean Grey', 'Jean Grey-Summers', 'Telepathic and telekinetic founding member.',
 'Jean Grey is one of the founding members of the X-Men, gifted with powerful telepathy and telekinesis. Her connection to the cosmic Phoenix Force has made her one of the most powerful and complex figures in the Marvel Universe.',
 'images/jean-grey.jpeg',
 'Telepathy, telekinesis', 'X-Men', 'Marvel Comics', 'Active', '1963-09-01'),

('Wolverine', 'James "Logan" Howlett', 'Feral mutant with a healing factor and claws.',
 'Logan is a mutant with animal-keen senses, a powerful regenerative healing factor, and retractable bone claws later bonded with unbreakable adamantium. His long life and military past make him one of the X-Men''s most experienced members.',
 'images/wolverine.jpeg',
 'Healing factor, adamantium claws', 'X-Men', 'Marvel Comics', 'Active', '1974-10-01'),

('Storm', 'Ororo Munroe', 'Weather-manipulating X-Men leader.',
 'Ororo Munroe can manipulate atmospheric conditions, generating wind, lightning, and rain at will. Revered since childhood in parts of Africa, she has led the X-Men on multiple occasions and is considered one of the most powerful mutants alive.',
 'images/storm.jpeg',
 'Weather manipulation', 'X-Men', 'Marvel Comics', 'Active', '1975-05-01'),

('Beast', 'Henry "Hank" McCoy', 'Genius scientist with ape-like agility and strength.',
 'Hank McCoy combines a brilliant scientific mind with a mutation that gives him enhanced strength, agility, and later a more feline, fur-covered appearance. He often serves as the team''s resident scientist and medical expert.',
 'images/beast.jpeg',
 'Superhuman agility and strength, genius intellect', 'X-Men', 'Marvel Comics', 'Active', '1963-09-01'),

('Nightcrawler', 'Kurt Wagner', 'Teleporting acrobat with a swashbuckling spirit.',
 'Kurt Wagner can teleport short distances in a burst of brimstone-scented smoke. Despite a demonic appearance, he is one of the most good-natured X-Men, balancing deep religious faith with acrobatic swordsmanship.',
 'images/nightcrawler.jpeg',
 'Teleportation, agility', 'X-Men', 'Marvel Comics', 'Active', '1975-05-01'),

('Rogue', 'Anna Marie', 'Absorbs the powers and memories of anyone she touches.',
 'Rogue absorbs the memories, physical abilities, and if the contact is with a mutant, the powers of anyone she touches skin-to-skin, originally being unable to control the effect. She later gained flight and superhuman strength permanently.',
 'images/rogue.jpeg',
 'Power/memory absorption, flight, super strength', 'X-Men', 'Marvel Comics', 'Active', '1981-01-01'),

('Gambit', 'Remy LeBeau', 'Cajun thief who charges objects with kinetic energy.',
 'Remy LeBeau is a master thief from New Orleans who can charge objects with explosive kinetic energy, most famously his signature playing cards. He is also a skilled hand-to-hand combatant and bo-staff fighter.',
 'images/gambit.jpeg',
 'Kinetic energy charging', 'X-Men', 'Marvel Comics', 'Active', '1990-04-01');

-- ------------------------------------------------
-- Seed data: users
-- Default login:
-- username: admin  
-- password: password123
-- (hash below is bcrypt for "password123")
-- ------------------------------------------------
INSERT INTO users (username, password) VALUES
('admin', '$2b$10$VE8MlS2mRm5XaQZEbyzLEO0YRrKPn7GSCiEmDc9ScXwzBvfKcPoDq');
