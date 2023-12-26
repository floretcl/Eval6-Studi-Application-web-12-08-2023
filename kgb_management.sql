/*

sudo mysql
CREATE DATABASE kgb_management;
GRANT ALL ON kgb_management.* TO 'username'@'localhost';
FLUSH PRIVILEGES;
\q

mariadb kgb_management -u username -p */

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
    specialty_id SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    specialty_name VARCHAR(50) NOT NULL
);

CREATE TABLE Mission_type (
    mission_type_id SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    mission_type_name VARCHAR(50) NOT NULL
);

CREATE TABLE Mission_status (
    mission_status_id TINYINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    mission_status_name VARCHAR(50) NOT NULL
);

CREATE TABLE Hideout_type (
    hideout_type_id SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    hideout_type_name VARCHAR(50) NOT NULL
);

/* MAIN TABLES */

CREATE TABLE Mission (
    mission_uuid VARCHAR(36) DEFAULT (UUID()) NOT NULL PRIMARY KEY,
    mission_code_name VARCHAR(30) NOT NULL,
    mission_title VARCHAR(80) NOT NULL,
    mission_description TEXT NOT NULL,
    mission_country VARCHAR(50) NOT NULL,
    mission_type SMALLINT NOT NULL,
    mission_specialty SMALLINT NOT NULL,
    mission_status TINYINT NOT NULL,
    mission_start_date DATETIME NOT NULL,
    mission_end_date DATETIME NOT NULL
);

CREATE TABLE Agent (
    agent_uuid VARCHAR(36) DEFAULT (UUID()) NOT NULL PRIMARY KEY,
    agent_code VARCHAR(6) NOT NULL UNIQUE,
    agent_firstname VARCHAR(30),
    agent_lastname VARCHAR(30),
    agent_birthday DATETIME NOT NULL,
    agent_nationality VARCHAR(50) NOT NULL,
    agent_mission VARCHAR(36)
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
    hideout_address VARCHAR(255) NOT NULL,
    hideout_country VARCHAR(50) NOT NULL, 
    hideout_type SMALLINT NOT NULL
);

/* FOREIGN KEYS */

ALTER TABLE Agent
ADD CONSTRAINT Fk_Agent_Mission
FOREIGN KEY (agent_mission) REFERENCES Mission(mission_uuid);

ALTER TABLE Mission 
ADD CONSTRAINT Fk_Mission_specialty
FOREIGN KEY (mission_specialty) REFERENCES Specialty(specialty_id);

ALTER TABLE Mission 
ADD CONSTRAINT Fk_Mission_status
FOREIGN KEY (mission_status) REFERENCES Mission_status(mission_status_id);

ALTER TABLE Mission 
ADD CONSTRAINT Fk_Mission_type
FOREIGN KEY (mission_type) REFERENCES Mission_type(mission_type_id);

ALTER TABLE Hideout
ADD CONSTRAINT Fk_Hideout_type
FOREIGN KEY (hideout_type) REFERENCES Hideout_type(hideout_type_id);

/* ASSOCIATIONS TABLES */

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
    FOREIGN KEY (contact_uuid) REFERENCES Contact(contact_uuid)
);

CREATE TABLE Mission_Target (
    mission_uuid VARCHAR(36) NOT NULL,
    target_uuid VARCHAR(36) NOT NULL,
    PRIMARY KEY (mission_uuid, target_uuid),
    FOREIGN KEY (mission_uuid) REFERENCES Mission(mission_uuid) ON DELETE CASCADE,
    FOREIGN KEY (target_uuid) REFERENCES Target(target_uuid)
);

CREATE TABLE Agent_Specialty (
    agent_uuid VARCHAR(36) NOT NULL,
    specialty_id SMALLINT NOT NULL,
    FOREIGN KEY (agent_uuid) REFERENCES Agent(agent_uuid) ON DELETE CASCADE,
    FOREIGN KEY (specialty_id) REFERENCES Specialty(specialty_id)
);