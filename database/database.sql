DROP TABLE IF EXISTS USER;
DROP TABLE IF EXISTS TICKET;
DROP TABLE IF EXISTS MESSAGE;
DROP TABLE IF EXISTS FAQ;
DROP TABLE IF EXISTS DEPARTMENT;
DROP TABLE IF EXISTS TICKETSTATUS;
DROP TABLE IF EXISTS HASHTAG;
DROP TABLE IF EXISTS TICKET_HASHTAG;
DROP TABLE IF EXISTS STATUS;

CREATE TABLE USER 
(
    USERID INTEGER NOT NULL,
    USERNAME VARCHAR NOT NULL,
    NAME VARCHAR NOT NULL,
    EMAIL VARCHAR NOT NULL, 
    PASSWORD VARCHAR NOT NULL,
    ISAGENT BOOLEAN NOT NULL,
    ISADMIN BOOLEAN NOT NULL,
    PROFILEIMG VARCHAR NOT NULL,
    DEPARTMENT VARCHAR,
    PRIMARY KEY (USERID)

);

CREATE TABLE HASHTAG (
    HASHTAGID INTEGER,
    HASHTAG VARCHAR NOT NULL,
    PRIMARY KEY (HASHTAGID)
);


CREATE TABLE TICKET 
(
    TICKETID INTEGER,
    TITLE VARCHAR NOT NULL,
    TICKETDATE DATETIME NOT NULL,
    DEPARTMENT VARCHAR ,
    PRIORITY VARCHAR NOT NULL,
    DESCRIPTION MEDIUMTEXT NOT NULL,
    CLIENT INTEGER NOT NULL,
    AGENT INTEGER,
    STATUS VARCHAR NOT NULL,
    HASHTAGID INTEGER,
    PRIMARY KEY (TICKETID),
    FOREIGN KEY (AGENT) REFERENCES USER(USERID),
    FOREIGN KEY (DEPARTMENT) REFERENCES DEPARTMENT(DEPARTMENTID),
    FOREIGN KEY (HASHTAGID) REFERENCES HASHTAG(HASHTAGID)
    

);

CREATE TABLE MESSAGE 
(
    AUTHOR INTEGER NOT NULL,
    MESSAGEID INTEGER ,
    CONTENT MEDIUMTEXT NOT NULL,
    TICKET INTEGER NOT NULL,
    PRIMARY KEY (MESSAGEID),
    FOREIGN KEY (TICKET) REFERENCES TICKET(TICKETID)
);

CREATE TABLE FAQ
(
    FAQID INTEGER NOT NULL,
    TITLE MEDIUMTEXT NOT NULL,
    CONTENT MEDIUMTEXT NOT NULL,
    PRIMARY KEY (FAQID)

);

CREATE TABLE DEPARTMENT 
(
    DEPARTMENTID VARCHAR NOT NULL,
    PRIMARY KEY (DEPARTMENTID)
    
);

CREATE TABLE TICKETSTATUS
(
    TICKETSTATUSID INTEGER,
    USER INTEGER NOT NULL,
    TICKET INTEGER NOT NULL,
    STATUS VARCHAR NOT NULL,
    PRIMARY KEY(TICKETSTATUSID),
    FOREIGN KEY (TICKET) REFERENCES TICKET(TICKETID)
);

CREATE TABLE TICKET_HASHTAG (
    TICKETID INTEGER NOT NULL,
    HASHTAGID INTEGER NOT NULL,
    FOREIGN KEY (TICKETID) REFERENCES TICKET(TICKETID),
    FOREIGN KEY (HASHTAGID) REFERENCES HASHTAG(HASHTAGID),
    PRIMARY KEY (TICKETID, HASHTAGID)
);

CREATE TABLE STATUS(
    STATUSID VARCHAR NOT NULL
);

-- statuses
INSERT INTO STATUS(STATUSID) VALUES ("Assigned");
INSERT INTO STATUS(STATUSID) VALUES ("Completed");
INSERT INTO STATUS(STATUSID) VALUES ("Unassigned");

-- departments
INSERT INTO DEPARTMENT(DEPARTMENTID) VALUES ("Intervention");
INSERT INTO DEPARTMENT(DEPARTMENTID) VALUES ("Senate");
INSERT INTO DEPARTMENT(DEPARTMENTID) VALUES ("Adminstration");

-- users
INSERT INTO USER (USERID, USERNAME, NAME, EMAIL, PASSWORD, ISAGENT, ISADMIN, PROFILEIMG, DEPARTMENT) VALUES (1, 'empPalpatine123', 'Emperor Palpatine' ,'shiv@gmail.com', '$2y$10$9LFn30GJg6zcUBSwzDvKZOHGzAyQ8mocUWKUWS3i/qAR/D570jUzm', 1, 1, '../docs/users/1.jpg', "Administration"); -- pass: th3Senate
INSERT INTO USER (USERID, USERNAME, NAME, EMAIL, PASSWORD, ISAGENT, ISADMIN, PROFILEIMG, DEPARTMENT) VALUES (2, 'anakinthegreat', 'Darth Vader' ,'anakin@gmail.com', '$2y$10$qZ47ztJ6sXU7mmj6LQ6GxONlJnqQUSbsSUG/1BOe.Ffj5eJAC0EBO', 1, 0, '../docs/users/2.jpg', "Intervention"); -- pass: 1lovePadme
INSERT INTO USER (USERID, USERNAME, NAME, EMAIL, PASSWORD, ISAGENT, ISADMIN, PROFILEIMG) VALUES (3, 'twosuns','Tatooine Citizen' ,'2suns@gmail.com', '$2y$10$3kD2utjn2Pj.QSw5PUuC6OvshM2vnAtpJR4JjQBUlQlAE4A8KW6ui', 0, 0, '../docs/users/3.jpg'); -- pass: D3sertPlanet
INSERT INTO USER (USERID, USERNAME, NAME, EMAIL, PASSWORD, ISAGENT, ISADMIN, PROFILEIMG) VALUES (4, 'senatorMothma', 'Senator Mon Mothma', 'naboo@gmail.com', '$2y$10$.ZZ555Dc/6L4mpUgZDgmx.7oahUu/uBccrD0UA1X/K3hs.DkGvs/G', 0, 0, '../docs/users/4.jpg'); --pass: NabooSenator1
INSERT INTO USER (USERID, USERNAME, NAME, EMAIL, PASSWORD, ISAGENT, ISADMIN, PROFILEIMG, DEPARTMENT) VALUES (5, 'captainCody2012', 'Officer Cody', 'cody@gmail.com', '$2y$10$Cdmu4EWC2R7aa2eBzx4Vs.cRKtbdzce01/M4aiqtYQfMM2DyiH4o6', 1, 0, '../docs/users/5.jpg', "Senate"); --pass: 3mpireOfficer
INSERT INTO USER (USERID, USERNAME, NAME, EMAIL, PASSWORD, ISAGENT, ISADMIN, PROFILEIMG, DEPARTMENT) VALUES (6, 'peaceGiVeR', 'General Tarkin', 'tarkin@gmail.com', '$2y$10$7oWZiB6IORz4synTkSXbXe/H9qGrq7XuSy0RYx9D6WRnh8li7.V0y', 1, 0, '../docs/users/default.jpeg', "Intervention"); --pass: heirTo3mpire
INSERT INTO USER (USERID, USERNAME, NAME, EMAIL, PASSWORD, ISAGENT, ISADMIN, PROFILEIMG, DEPARTMENT) VALUES (7, 'CloneCommander', 'Captain Rex', 'rex@gmail.com', '$2y$10$ZEvwtoVNuqT3aRI7Wo.SZu7dFNz9OHIZBJNjZp2cLpujUMgtJnC.y', 1, 0, '../docs/users/default.jpeg', 'Senate'); --pass: CaptainR3x
INSERT INTO USER (USERID, USERNAME, NAME, EMAIL, PASSWORD, ISAGENT, ISADMIN, PROFILEIMG, DEPARTMENT) VALUES (8, 'ShadowHunter', 'Fifth Sister', '5sis@gmail.com', '$2y$10$h71HvYGCYQNMWKC336Zq5uhNLEX9rK.bpnpC36tipwrLmPTwe5fIS', 1, 0, '../docs/users/default.jpeg', "Intervention"); --pass: Fifth1quisitor
INSERT INTO USER (USERID, USERNAME, NAME, EMAIL, PASSWORD, ISAGENT, ISADMIN, PROFILEIMG) VALUES (9, 'magistrate1', 'High Magistrate', 'magistrate@gmail.com', '$2y$10$6vnom6GrYmShdy7LkHeJfO5KHYLzmo3AZNH2SMQgZwCu7nDy4RE5W', 0, 0, '../docs/users/default.jpeg') ;--pass: H1ghMagNavarro
INSERT INTO USER (USERID, USERNAME, NAME, EMAIL, PASSWORD, ISAGENT, ISADMIN, PROFILEIMG) VALUES (10, 'worriedCitizen', 'Worrying Citizen', 'loveempire@gmail.com', '$2y$10$hHp79y6tJPtHt9FoJSab/OP35mzDW.AaHQ3Qw6cjEstDu7x7xYe56', 0, 0, '../docs/users/default.jpeg'); --pass: Ilove3mpire


-- faqs
INSERT INTO FAQ (FAQID, TITLE, CONTENT) VALUES (1, 'How do I know how much credits I need to pay for taxes?', "Please go to your planet's Imperial Center to know how much credits you have to pay, the norm is: Inner Rim(100 - 200 credits), Mid Rim(200 - 300 credits), Outer Rim(300 - 500 credits)");
INSERT INTO FAQ (FAQID, TITLE, CONTENT) VALUES (2, 'How do I report any rebelion against the Empire?', 'If you suspect any rebelion against the Empire, please go to your closest Imperial Stormtrooper commander patrolling the streets and report the issue to them, so that it is treated swiftly and peacefully');
INSERT INTO FAQ (FAQID, TITLE, CONTENT) VALUES (3, 'How do I know if my system is under the protection of the Empire?', 'If the Imperial Flag is on the main Palace/Center of Power and you see Stormtroopers patrolling the streets, then your country is under the protection of the great Galatic Empire');
INSERT INTO FAQ (FAQID, TITLE, CONTENT) VALUES (4, 'I see a Stormtrooper misbehaving or not performing his duty while on duty', 'If you see a Stormtrooper performing any lower than the best soldier in the Galaxy, please report this to the Imperial Security Center and this matter will be dealt with immediately');


-- ticket 1
INSERT INTO TICKET(TICKETID, TICKETDATE, TITLE, DEPARTMENT, DESCRIPTION, PRIORITY, CLIENT,  AGENT, STATUS) VALUES (1, '2023-05-10 12:00:01', 'Pirates in Tatooine', 'Intervention','Pirates invaded a town in Tatooine','Medium', 3, 2, 'Assigned');
INSERT INTO MESSAGE( AUTHOR, CONTENT, TICKET) VALUES ( 3, 'There have been constant pirate raids to our moisture farms, we need help!', 1);
INSERT INTO MESSAGE( AUTHOR, CONTENT, TICKET) VALUES ( 2, 'I personally will deal with this matter. Glory to the the Empire!', 1);

-- ticket 2
INSERT INTO TICKET(TICKETID, TICKETDATE, TITLE, DEPARTMENT, DESCRIPTION, PRIORITY, CLIENT,  AGENT, STATUS) VALUES (2 , '2023-05-11 14:05:01', 'Shortage of Droids in the Senate','Senate','A senator has no personal droid in her chambers','Low', 4, 5, 'Completed');
INSERT INTO MESSAGE( AUTHOR, CONTENT, TICKET) VALUES ( 4, 'Today, when I got into my personal chamber after the Senate session, there were no droids to help me! This is unnaceptable, I am a senator from the Naboo planet and I demand to be treated with more respect !', 2);
INSERT INTO MESSAGE( AUTHOR, CONTENT, TICKET) VALUES ( 5, 'We are very sorry this happened to you senator , we will dispatch a C3 unit as soon as possible to your chamber.', 2);
INSERT INTO MESSAGE( AUTHOR, CONTENT, TICKET) VALUES ( 4, 'Thank you very much officer, the droid has arrived and I am very pleased with the unit I got. Glory to the Empire.', 2);
INSERT INTO MESSAGE( AUTHOR, CONTENT, TICKET) VALUES ( 5, 'Honor to serve you senator. Glory to the Great Empire', 2);

--ticket 3
INSERT INTO TICKET(TICKETID, TICKETDATE, TITLE, DEPARTMENT, DESCRIPTION, PRIORITY, CLIENT,  AGENT, STATUS) VALUES (3, '2023-05-15 23:50:11', 'Jedi sighting','Intervention','A Jedi survivor has been sighted in Bogano', 'High', 9, 8, 'Assigned');
INSERT INTO MESSAGE( AUTHOR, CONTENT, TICKET) VALUES ( 9, 'Today was reported to me that a jedi was sighted in the main market of my planet, Bogano. I request that a competent Empire force to deal with this matter', 3);
INSERT INTO MESSAGE( AUTHOR, CONTENT, TICKET) VALUES ( 8, 'I will deal with this matter. Can you give me a description of this alleged Jedi Knight?', 3);
INSERT INTO MESSAGE( AUTHOR, CONTENT, TICKET) VALUES ( 9, 'I was told he was a red haired Human, medium stature, wearing a poncho.', 3);
INSERT INTO MESSAGE( AUTHOR, CONTENT, TICKET) VALUES ( 8, 'Thank you Sir, this matter will be dealt with right now by me and my Imperial Intervention Force', 3);

-- ticket 4
INSERT INTO TICKET(TICKETID, TICKETDATE, TITLE, DEPARTMENT, DESCRIPTION, PRIORITY, CLIENT, STATUS) VALUES (4, '2023-05-18 16:43:21', 'Fighting between Mandalorian', 'Intervention', 'Infighting between opposing Mandalorian Clans', 'High', 9, 'Unassigned');


--ticket 5
INSERT INTO TICKET(TICKETID, TICKETDATE, TITLE, DEPARTMENT, DESCRIPTION, PRIORITY, CLIENT, STATUS) VALUES (5, '2023-05-18 22:45:14', 'Empire Day: Event','Senate', 'Need more Imperial Troopers to patrol the streets due to Empire Day' ,'Medium', 4, 'Unassigned');

--ticket 6
INSERT INTO TICKET(TICKETID, TICKETDATE, TITLE, DEPARTMENT, DESCRIPTION, PRIORITY, CLIENT, AGENT, STATUS) VALUES (6, '2023-05-12 22:40:14', 'Conquering of Mars','Adminstration', 'Need more Imperial Troopers to take over Mars' ,'High', 4, 1,'Assigned');
INSERT INTO MESSAGE( AUTHOR, CONTENT, TICKET) VALUES (6, 'I need more resources to get Mars!',6);
INSERT INTO MESSAGE( AUTHOR, CONTENT, TICKET) VALUES (1, 'We cant simply do that!',6);
INSERT INTO MESSAGE( AUTHOR, CONTENT, TICKET) VALUES (6, 'Then i will do it myself!',6);

--ticlet 7
INSERT INTO TICKET(TICKETID, TICKETDATE, TITLE, DEPARTMENT, DESCRIPTION, PRIORITY, CLIENT, STATUS) VALUES (7, '2023-05-18 22:45:14', 'Stealing on the main hall','Adminstration', 'Need more security on the safe spots!' ,'Medium', 3, 'Unassigned');


-- hashtags
INSERT INTO HASHTAG(HASHTAG)
VALUES ('urgent'), ('mandalorians'), ('droids'), ('troopers'), ('celebration'), ('pirates');

-- Associating hashtags with tickets in the TICKET_HASHTAG table
INSERT INTO TICKET_HASHTAG(TICKETID, HASHTAGID) VALUES
    (1, 1);

INSERT INTO TICKET_HASHTAG(TICKETID, HASHTAGID) VALUES
    (1, 6);
