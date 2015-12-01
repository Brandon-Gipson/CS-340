-- Creates a table called player with the following properties:
-- id - an auto incrementing integer which is the primary key
-- name - a varchar of maximum length 255, cannot be null
-- timezone - a varchar of maximum length 255

CREATE TABLE player (
	id int AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	age int,
	timezone VARCHAR(255), 
	PRIMARY KEY (id)
) ENGINE=InnoDB;


-- Creates a table called pCharacter with the following properties:
-- id - an auto incrementing integer which is the primary key
-- name - a varchar of maximum length 255, cannot be null
-- cLevel - an integer
-- classId - a foriegn key reference to the id found in the playable_classes table
-- role - a foriegn key reference to the id found in roles table
-- pid - a foriegn key reference to the id found in the player table

CREATE TABLE pCharacter (
	id int AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	cLevel int,
	classId int,
	primaryRole int,
	secondaryRole int,
	pid int,
	PRIMARY KEY (id),
	FOREIGN KEY (pid) REFERENCES player (id)
	ON DELETE CASCADE,
	FOREIGN KEY (classId) REFERENCES playable_classes (id)
	ON DELETE CASCADE,
	FOREIGN KEY (primaryRole) REFERENCES roles (id)
	ON DELETE CASCADE,
	FOREIGN KEY (secondaryRole) REFERENCES roles (id)
	ON DELETE CASCADE
) ENGINE=InnoDB;


-- Creates a table called playable_classes with the following properties:
-- id - an auto incrementing integer which is the primary key
-- className - a varchar of maximum length 255, cannot be null

CREATE TABLE playable_classes (
	id int AUTO_INCREMENT,
	className VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;


-- Creates a table called roles with the following properties:
-- id - an auto incrementing integer which is the primary key
-- roleType - a varchar of maximum length 255, cannot be null

CREATE TABLE roles (
	id int AUTO_INCREMENT,
	roleType VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;


-- Populates the static tables

INSERT INTO playable_classes VALUES (1, 'Warrior'), (2, 'Paladin'), (3, 'Hunter'), (4, 'Rogue'), (5, 'Priest'), 
									(6, 'Death Knight'), (7, 'Shaman'), (8, 'Mage'), (9, 'Warlock'), (10, 'Monk'), (11, 'Druid'), (12, 'Demon Hunter');
INSERT INTO roles VALUES (1, 'Tank'), (2, 'Healer'), (3, 'Melee DPS'), (4, 'Ranged DPS');