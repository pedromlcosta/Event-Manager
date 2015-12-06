 /*PRAGMA foreign_keys = ON;

.open web.db*/
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS images;
DROP TABLE IF EXISTS tags;
DROP TABLE IF EXISTS types;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS tags_events;
DROP TABLE IF EXISTS users_images;
DROP TABLE IF EXISTS events_types;
DROP TABLE IF EXISTS events_users;
DROP TABLE IF EXISTS events_images;
DROP TRIGGER IF EXISTS userGoingToEvent;
DROP TRIGGER IF EXISTS userNotGoingToEvent;
DROP TRIGGER IF EXISTS userAddedToEvent;
DROP TRIGGER IF EXISTS userRemovedFromEvent;
DROP TRIGGER IF EXISTS creatorAttendsEvent;
DROP TRIGGER IF EXISTS defaultImageOnRegister;
 
-- TODO - por os UNIQUE necessarios e/ou os NOT NULL echo .quit|
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
	username	VARCHAR UNIQUE,
	password	VARCHAR,
	fullname	TEXT,
	visible	Boolean DEFAULT 1
);

CREATE TABLE events (
	id	INTEGER PRIMARY KEY AUTOINCREMENT,
	title	VARCHAR,
	fulltext	VARCHAR,
	private	Boolean,
	data	Date,
	numberUsers INTEGER DEFAULT 0,
	user_id	INTEGER,
	visible	Boolean DEFAULT 1,
	FOREIGN KEY(user_id) REFERENCES users ( id ) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE types (
	id	INTEGER PRIMARY KEY AUTOINCREMENT,
	name VARCHAR,
	visible	Boolean DEFAULT 1
);

CREATE TABLE images (
	id	INTEGER PRIMARY KEY AUTOINCREMENT,
	title	VARCHAR,
	description	VARCHAR,
	url	VARCHAR,
	visible	Boolean DEFAULT 1
);

CREATE TABLE tags (
	id	INTEGER PRIMARY KEY AUTOINCREMENT,
	description	VARCHAR UNIQUE,
	visible	Boolean DEFAULT 1
);

CREATE TABLE comments(
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	user_id INTEGER,
	event_id INTEGER,
	comment TEXT,
	data	Date
);

CREATE TABLE users_images (
	user_id	INTEGER,
	image_id	INTEGER,
	visible	Boolean DEFAULT 1,
	FOREIGN KEY(user_id) REFERENCES users ( id ) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(image_id) REFERENCES images ( id ) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY(user_id,image_id)
);

CREATE TABLE events_types (
	event_id	INTEGER,
	type_id	INTEGER,
	visible	Boolean DEFAULT 1,
	FOREIGN KEY(type_id) REFERENCES types ( id ) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(event_id) REFERENCES events ( id ) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY(event_id,type_id)
);

-- attending_status - 0 if invited, 1 if attending. If user says "Not Going", he is still invited and can change status at anytime! He may choose to remove himself
CREATE TABLE events_users (
	event_id	INTEGER,
	user_id	INTEGER,
	attending_status INTEGER,
	visible	Boolean DEFAULT 1,
	FOREIGN KEY(user_id) REFERENCES users ( id ) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(event_id) REFERENCES events ( id ) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY(event_id,user_id)
);

CREATE TABLE events_images (
	event_id	INTEGER,
	image_id	INTEGER,
	visible	Boolean DEFAULT 1,
	FOREIGN KEY(event_id) REFERENCES events ( id ) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(image_id) REFERENCES image ( id ) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY(event_id,image_id)
);

CREATE TABLE tags_events (
	event_id	INTEGER,
	tag_id	INTEGER,
	visible	Boolean DEFAULT 1,
	FOREIGN KEY(event_id) REFERENCES events ( id ) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(tag_id) REFERENCES tag ( id ) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY(event_id,tag_id)
);

-- When attending status changes to going
CREATE TRIGGER userGoingToEvent
AFTER UPDATE ON EVENTS_USERS
WHEN old.attending_status = 0 AND new.attending_status = 1
BEGIN
UPDATE EVENTS
SET numberUsers = (SELECT numberUsers FROM EVENTS WHERE EVENTS.id = new.event_id) + 1 
WHERE EVENTS.id = new.event_id;
END;

-- When attending status changes to not going
CREATE TRIGGER userNotGoingToEvent
AFTER UPDATE ON EVENTS_USERS
WHEN old.attending_status = 1 AND new.attending_status = 0
BEGIN
UPDATE EVENTS
SET numberUsers = (SELECT numberUsers FROM EVENTS WHERE EVENTS.id = new.event_id) - 1 
WHERE EVENTS.id = new.event_id;
END;

CREATE TRIGGER userAddedToEvent
AFTER INSERT ON EVENTS_USERS
WHEN new.attending_status = 1
BEGIN
UPDATE EVENTS
SET numberUsers = (SELECT numberUsers FROM EVENTS WHERE EVENTS.id = new.event_id) + 1 
WHERE EVENTS.id = new.event_id;
END;

--When user is literally removed, not even invited, to the event
CREATE TRIGGER userRemovedFromEvent
AFTER DELETE ON EVENTS_USERS
WHEN old.attending_status = 1
BEGIN
UPDATE EVENTS
SET numberUsers = (SELECT numberUsers FROM EVENTS WHERE EVENTS.id = old.event_id) - 1 
WHERE EVENTS.id = old.event_id;
END;

CREATE TRIGGER creatorAttendsEvent
AFTER INSERT ON EVENTS
BEGIN
INSERT INTO EVENTS_USERS(event_id, user_id, attending_status)
VALUES(new.id, new.user_id, 1);
END;

CREATE TRIGGER defaultImageOnRegister
AFTER INSERT ON USERS
BEGIN
INSERT INTO USERS_IMAGES(user_id, image_id)
VALUES(new.id ,2);
END;



INSERT INTO users(id,username,password,fullname) VALUES (NULL,'admin', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3','admin'); -- Password is tested hashed with SHA 1
INSERT INTO users(id,username,password,fullname) VALUES(NULL,'Filipe','2e6f9b0d5885b6010f9167787445617f553a735f','Filipe Moreira');
INSERT INTO users(id,username,password,fullname) VALUES(NULL,'Pedro','$2y$10$hnBwkELw6HM45h52jkutYOcRRQfzFJ5q7yUrksEtE1eAkkmAqNHkC','Pedro Costa');
INSERT INTO users(username, password, fullname) VALUES('Mysterion', '$2y$10$hnBwkELw6HM45h52jkutYOcRRQfzFJ5q7yUrksEtE1eAkkmAqNHkC', 'Mysterion' );

INSERT INTO types (name) VALUES ('Party');
INSERT INTO types (name) VALUES ('Concert');
INSERT INTO types (name) VALUES ('Conference');
INSERT INTO types (name) VALUES ('Meeting');
INSERT INTO types (name) VALUES ('Wedding');
INSERT INTO types (name) VALUES ('Birthday');
INSERT INTO types (name) VALUES ('Fundraising');
INSERT INTO types (name) VALUES ('Hangout');

-- VERY IMPORTANT!
INSERT INTO images(title, description, url) VALUES ('default_event_background', 'default_event_background', 'images/backg.jpg');
INSERT INTO images(title, description, url) VALUES ('default_profile_background', 'default_profile_background', 'images/default_profile_pic.jpg');

-- User 3 the first 9 events and the 13
INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 1', 'Sed nibh arcu, euismod elementum commodo ut, auctor id quam. Ut imperdiet diam.',0,'2015-01-01',3,1);
INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 2', 'Sed justo metus, suscipit non fermentum non, sagittis quis arcu. Curabitur tincidunt leo non blandit.',0,'2012-01-01',3,1);
INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 3', 'Maecenas ipsum elit, vestibulum id blandit vel, euismod ut urna. Sed nisi lectus.',0,'2013-01-01',3,1);
INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 4', 'Maecenas quis felis et tortor adipiscing blandit vel ac sem. Sed venenatis justo.',0,'2014-01-01',3,1);
INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 5', 'In vulputate velit nunc. Duis sollicitudin sapien at nulla pellentesque non consequat.',0,'2011-01-01',3,1);
INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 6', 'In vulputate velit nunc. Duis sollicitudin sapien at nulla pellentesque non consequat.',0,'2009-01-01',3,1);
INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 7', 'In vulputate velit nunc. Duis sollicitudin sapien at nulla pellentesque non consequat.',0,'2008-01-01',3,1);
INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 8', 'In vulputate velit nunc. Duis sollicitudin sapien at nulla pellentesque non consequat.',0,'2007-01-01',3,1);
INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 9', 'In vulputate velit nunc. Duis sollicitudin sapien at nulla pellentesque non consequat.',0,'2006-01-01',3,1);
INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 10', 'In vulputate velit nunc. Duis sollicitudin sapien at nulla pellentesque non consequat.',0,'2006-01-01',2,1);
INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 11', 'In vulputate velit nunc. Duis sollicitudin sapien at nulla pellentesque non consequat.',1,'2006-01-01',1,1);
INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 12', 'In vulputate velit nunc. Duis sollicitudin sapien at nulla pellentesque non consequat.',1,'2006-01-01',1,1);
INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 13', 'Passagem de Ano',1,'2016-01-01',3,1);
INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 14', 'Passagem de Ano 2',1,'2017-01-01',3,1);

INSERT INTO events_images(event_id,image_id) VALUES(1,1);
INSERT INTO events_images(event_id,image_id) VALUES(2,1);
INSERT INTO events_images(event_id,image_id) VALUES(3,1);
INSERT INTO events_images(event_id,image_id) VALUES(4,1);
INSERT INTO events_images(event_id,image_id) VALUES(5,1);
INSERT INTO events_images(event_id,image_id) VALUES(6,1);
INSERT INTO events_images(event_id,image_id) VALUES(7,1);
INSERT INTO events_images(event_id,image_id) VALUES(8,1);
INSERT INTO events_images(event_id,image_id) VALUES(9,1);
INSERT INTO events_images(event_id,image_id) VALUES(10,1);
INSERT INTO events_images(event_id,image_id) VALUES(11,1);
INSERT INTO events_images(event_id,image_id) VALUES(12,1);
INSERT INTO events_images(event_id,image_id) VALUES(13,1);
INSERT INTO events_images(event_id,image_id) VALUES(14,1);

-- User 1 and 2 were invited to event 3
INSERT INTO events_users(event_id, user_id, attending_status) VALUES (3, 1, 0);
INSERT INTO events_users(event_id, user_id, attending_status) VALUES (3, 2, 0);

-- User 1 removed himself from event 3
DELETE FROM events_users WHERE event_id=3 AND user_id=1;
 
 -- Creator of event 8 and 9 said he was not going
UPDATE events_users SET attending_status=0 WHERE event_id=9 AND user_id=3;
UPDATE events_users SET attending_status=0 WHERE event_id=8 AND user_id=3;

-- User 2 is going to event 3
UPDATE events_users SET attending_status=1 WHERE event_id=3 AND user_id=2;

-- User 3 was invited to event 12
INSERT INTO events_users(event_id, user_id, attending_status) VALUES (12, 3, 0);

INSERT INTO events_users(event_id, user_id, attending_status) VALUES (14, 4, 0);

DELETE FROM events_users WHERE event_id=3 AND user_id=2;

 -- User 3 commenting on his own event 1
INSERT INTO comments (user_id, event_id, comment, data) VALUES (3, 1, "Comment 1", '2016-01-01');
INSERT INTO comments (user_id, event_id, comment, data) VALUES (3, 1, "Comment 2", '2014-01-01');
INSERT INTO comments (user_id, event_id, comment, data) VALUES (3, 1, "Comment 3", '2016-01-01');
INSERT INTO comments (user_id, event_id, comment, data) VALUES (3, 1, "Comment 4", '2012-01-01');


INSERT INTO events_types (event_id, type_id) VALUES (1,1);
INSERT INTO events_types (event_id, type_id) VALUES (2,2);
INSERT INTO events_types (event_id, type_id) VALUES (3,3);
INSERT INTO events_types (event_id, type_id) VALUES (4,4);
INSERT INTO events_types (event_id, type_id) VALUES (5,5);
INSERT INTO events_types (event_id, type_id) VALUES (6,6);
INSERT INTO events_types (event_id, type_id) VALUES (7,7);
INSERT INTO events_types (event_id, type_id) VALUES (8,8);
INSERT INTO events_types (event_id, type_id) VALUES (9,5);
INSERT INTO events_types (event_id, type_id) VALUES (10,4);
INSERT INTO events_types (event_id, type_id) VALUES (11,7);
INSERT INTO events_types (event_id, type_id) VALUES (12,1);
INSERT INTO events_types (event_id, type_id) VALUES (13,1);
INSERT INTO events_types (event_id, type_id) VALUES (14,1);


INSERT INTO tags (description) VALUES ('concerto');
INSERT INTO tags (description) VALUES ('live');
INSERT INTO tags (description) VALUES ('cinema');
INSERT INTO tags (description) VALUES ('Coliseu');
INSERT INTO tags (description) VALUES ('free');
INSERT INTO tags (description) VALUES ('grátis');

INSERT INTO tags_events VALUES(1,1,1);
INSERT INTO tags_events VALUES(1,2,1);
INSERT INTO tags_events VALUES(2,3,1);
INSERT INTO tags_events VALUES(3,4,1);
INSERT INTO tags_events VALUES(1,5,1);

