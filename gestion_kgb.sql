/* sudo mysql */

CREATE DATABASE gestion_kgb;
GRANT ALL ON gestion_kgb.* TO 'username'@'localhost';

/* sudo mysql dbname -u username -p */

/* USERS TABLES */

CREATE TABLE Admin (
    admin_uuid VARCHAR(36) DEFAULT (UUID()) NOT NULL PRIMARY KEY,
    admin_firstname VARCHAR(30),
    admin_lastname VARCHAR(30),
    admin_email VARCHAR(254) NOT NULL UNIQUE,
    admin_password TEXT NOT NULL,
    admin_creation_date DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL
);

/* ENUMS AND SETS TABLES */

CREATE TABLE Specialty (
    specialty_name SET(
    'shooter',
    'support',
    'discretion',
    'diplomacy',
    'seduction',
    'engineering',
    'hacking') NOT NULL PRIMARY KEY
);

CREATE TABLE Mission_type (
    type_id INT NOT NULL PRIMARY KEY,
    type_name ENUM(
    'assassination',
    'cleaning',
    'undercover',
    'exfiltration',
    'monitoring',
    'intelligence',
    'sabotage',
    'manipulation',
    'kidnapping') NOT NULL
);

CREATE TABLE Mission_status (
    status_id INT NOT NULL PRIMARY KEY,
    status_name ENUM(
    'in preparation',
    'in progress',
    'finished',
    'failure') NOT NULL
);

CREATE TABLE Hideout_type (
    hideout_type_id INT NOT NULL PRIMARY KEY,
    hideout_type_name ENUM(
    'hotel room',
    'villa',
    'high moutain chalet',
    'private domain',
    'fitted box',
    'bunker',
    'unmarked vehicle') NOT NULL
);

/* MAIN TABLES */

CREATE TABLE Mission (
    mission_uuid VARCHAR(36) DEFAULT (UUID()) NOT NULL PRIMARY KEY,
    mission_code_name VARCHAR(30) NOT NULL,
    mission_title VARCHAR(80) NOT NULL,
    mission_description TEXT NOT NULL,
    mission_country VARCHAR(50) NOT NULL,
    mission_type INT NOT NULL,
    mission_specialty SET(
    'shooter',
    'support',
    'discretion',
    'diplomacy',
    'seduction',
    'engineering',
    'hacking'), 
    mission_status INT NOT NULL,
    start_date DATETIME NOT NULL, 
    end_date DATETIME NOT NULL
);

CREATE TABLE Agent (
    agent_uuid VARCHAR(36) DEFAULT (UUID()) NOT NULL PRIMARY KEY,
    agent_code VARCHAR(6) NOT NULL UNIQUE,
    agent_firstname VARCHAR(30),
    agent_lastname VARCHAR(30),
    agent_birthday DATETIME NOT NULL,
    agent_nationality VARCHAR(50) NOT NULL,
    agent_mission_uuid VARCHAR(36)
);

CREATE TABLE Target (
    target_uuid VARCHAR(36) DEFAULT (UUID()) NOT NULL PRIMARY KEY, 
    target_code_name VARCHAR(30) NOT NULL, 
    target_firstname VARCHAR(30), 
    target_lastname VARCHAR(30), 
    target_birthday DATETIME NOT NULL, 
    target_nationality VARCHAR(50) NOT NULL
);

CREATE TABLE Contact (
    contact_uuid VARCHAR(36) DEFAULT (UUID()) NOT NULL PRIMARY KEY, 
    contact_code_name VARCHAR(30) NOT NULL, 
    contact_firstname VARCHAR(30), 
    contact_lastname VARCHAR(30), 
    contact_birthday DATETIME NOT NULL, 
    contact_nationality VARCHAR(50) NOT NULL
);

CREATE TABLE Hideout (
    hideout_uuid VARCHAR(36) DEFAULT (UUID()) NOT NULL PRIMARY KEY, 
    hideout_code_name VARCHAR(30) NOT NULL, 
    hideout_adress VARCHAR(255) NOT NULL, 
    hideout_country VARCHAR(50) NOT NULL, 
    hideout_type INT NOT NULL
);

/* FOREIGN KEYS */

ALTER TABLE Mission 
ADD CONSTRAINT Fk_Mission_specialty
FOREIGN KEY (mission_specialty) REFERENCES Specialty(specialty_name);

ALTER TABLE Mission 
ADD CONSTRAINT Fk_Mission_status
FOREIGN KEY (mission_status) REFERENCES Mission_status(status_id);

ALTER TABLE Mission 
ADD CONSTRAINT Fk_Mission_type
FOREIGN KEY (mission_type) REFERENCES Mission_type(type_id);

ALTER TABLE Hideout
ADD CONSTRAINT Fk_Hideout_type
FOREIGN KEY (hideout_type) REFERENCES Hideout_type(hideout_type_id);

/* ASSOCS TABLES */

CREATE TABLE Mission_Hideout (
    mission_uuid VARCHAR(36) NOT NULL, 
    hideout_uuid VARCHAR(36) NOT NULL, 
    PRIMARY KEY (mission_uuid, hideout_uuid),
    FOREIGN KEY (mission_uuid) REFERENCES Mission(mission_uuid) ON DELETE CASCADE,
    FOREIGN KEY (hideout_uuid) REFERENCES Hideout(hideout_uuid) ON DELETE CASCADE
);

CREATE TABLE Mission_Contact (
    mission_uuid VARCHAR(36) NOT NULL, 
    contact_uuid VARCHAR(36) NOT NULL, 
    PRIMARY KEY (mission_uuid, contact_uuid),
    FOREIGN KEY (mission_uuid) REFERENCES Mission(mission_uuid) ON DELETE CASCADE,
    FOREIGN KEY (contact_uuid) REFERENCES Contact(contact_uuid) ON DELETE CASCADE
);

CREATE TABLE Mission_Target (
    mission_uuid VARCHAR(36) NOT NULL,
    target_uuid VARCHAR(36) NOT NULL,
    PRIMARY KEY (mission_uuid, target_uuid),
    FOREIGN KEY (mission_uuid) REFERENCES Mission(mission_uuid) ON DELETE CASCADE,
    FOREIGN KEY (target_uuid) REFERENCES Target(target_uuid) ON DELETE CASCADE
);

CREATE TABLE Agent_Specialty (
    agent_uuid VARCHAR(36) NOT NULL,
    agent_specialty SET(
    'shooter',
    'support',
    'discretion',
    'diplomacy',
    'seduction',
    'engineering',
    'hacking') NOT NULL,
    FOREIGN KEY (agent_uuid) REFERENCES Agent(agent_uuid) ON DELETE CASCADE,
    FOREIGN KEY (agent_specialty) REFERENCES Specialty(specialty_name) ON DELETE CASCADE
);

/* CONSTRAINTS */

/* sudo mysql dbname */

DELIMITER $$
CREATE TRIGGER ck_mission_hideout_country
BEFORE INSERT ON Mission_Hideout
FOR EACH ROW
BEGIN
    DECLARE mission_country VARCHAR(50);
    DECLARE hideout_country VARCHAR(50);
    SET mission_country = (SELECT mission_country FROM Mission WHERE mission_uuid = new.mission_uuid);
    SET hideout_country = (SELECT hideout_country FROM Hideout WHERE hideout_uuid = new.hideout_uuid);
    IF mission_country <> hideout_country
    THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "The hideout must be in the same country as mission";
    END IF;
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER ck_mission_contact_country
BEFORE INSERT ON Mission_Contact
FOR EACH ROW
BEGIN
    DECLARE mission_country VARCHAR(50);
    DECLARE contact_country VARCHAR(50);
    SET mission_country = (SELECT mission_country FROM Mission WHERE mission_uuid = new.mission_uuid);
    SET contact_country = (SELECT contact_nationality FROM Contact WHERE contact_uuid = new.contact_uuid);
    IF mission_country <> contact_country
    THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "The contact must have the nationality of mission country";
    END IF;
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER ck_agent_target_nationality
BEFORE INSERT ON Agent_Mission
FOR EACH ROW
BEGIN
    DECLARE agent_nationality VARCHAR(50);
    DECLARE mission_target_uuid VARCHAR(36);
    DECLARE target_nationality VARCHAR(50);
    SET agent_nationality = (SELECT agent_nationality FROM Agent WHERE agent_uuid = new.agent_uuid);
    SET mission_target_uuid = (SELECT target_uuid FROM Mission_Target WHERE mission_uuid = new.mission_uuid);
    SET target_nationality = (SELECT target_nationality FROM Target WHERE target_uuid = mission_target_uuid);
    IF agent_nationality = target_nationality
    THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "An agent can't have the same nationality as target";
    END IF;
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER ck_mission_agent_specialty
AFTER INSERT ON Agent_Mission
FOR EACH ROW
BEGIN
    DECLARE mission_specialty SET(
    'shooter',
    'support',
    'discretion',
    'diplomacy',
    'seduction',
    'engineering',
    'hacking');
    SET mission_specialty = (SELECT mission_specialty FROM Mission WHERE mission_uuid = new.mission_uuid);
    IF NOT EXISTS (SELECT 1 FROM Agent WHERE agent_uuid = new.agent_uuid AND agent_specialty = mission_specialty)
    THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "A mission requires at least 1 Agent with the require specialty";
    END IF;
END $$
DELIMITER ;
