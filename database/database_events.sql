

--> Tabelas sempre no plural
--> Nomes das tabelas com underscore
--> Atributos das tabelas com underscore
--> Todas as tabelas devem ter SEMPRE (SEMPRE) atributo ID e esse é sempre a chave primária
--> Chaves estrangeiras devem ser sempre do género: user_id e não "user"
--> O nome da tabela principal deve ser sempre escrito primeiro (ex: events_images e não images_events)

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS images;
DROP TABLE IF EXISTS tags;
DROP TABLE IF EXISTS types;
DROP TABLE IF EXISTS tags_events;
DROP TABLE IF EXISTS users_images;
DROP TABLE IF EXISTS events_types;
DROP TABLE IF EXISTS events_users;
DROP TABLE IF EXISTS events_images;

-- TODO - por os UNIQUE necessarios e/ou os NOT NULL
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
	user_id	VARCHAR,
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

CREATE TABLE events_users (
	event_id	INTEGER,
	user_id	INTEGER,
	invited Boolean,
	attending Boolean,
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

INSERT INTO types (name) VALUES ('Party');
INSERT INTO types (name) VALUES ('Concert');
INSERT INTO types (name) VALUES ('Conference');
INSERT INTO types (name) VALUES ('Meeting');
INSERT INTO types (name) VALUES ('Wedding');
INSERT INTO types (name) VALUES ('Birthday');
INSERT INTO types (name) VALUES ('Fundraising');
INSERT INTO types (name) VALUES ('Hangout');

INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 1', 'Sed nibh arcu, euismod elementum commodo ut, auctor id quam. Ut imperdiet diam.',0,NULL,0,1);

INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 2', 'Sed justo metus, suscipit non fermentum non, sagittis quis arcu. Curabitur tincidunt leo non blandit.',0,NULL,0,1);

INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 3', 'Maecenas ipsum elit, vestibulum id blandit vel, euismod ut urna. Sed nisi lectus.',0,NULL,0,1);

INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 4', 'Maecenas quis felis et tortor adipiscing blandit vel ac sem. Sed venenatis justo.',0,NULL,0,1);

INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'evento 5', 'In vulputate velit nunc. Duis sollicitudin sapien at nulla pellentesque non consequat.',0,NULL,0,1);

INSERT INTO events_users(event_id, user_id, invited, attending) VALUES (3,1, 1, 1);
 
INSERT INTO users(id,username,password,fullname,visible) VALUES (NULL,'admin', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3','admin',1); -- Password is tested hashed with SHA 1

INSERT INTO users(id,username,password,fullname,visible) VALUES(NULL,'Filipe','2e6f9b0d5885b6010f9167787445617f553a735f','Filipe Moreira',1);

INSERT INTO users(id,username,password,fullname,visible) VALUES(NULL,'Pedro','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8','Pedro Costa',1);

INSERT INTO events_types (event_id, type_id) VALUES (1,1);
INSERT INTO events_types (event_id, type_id) VALUES (2,2);
INSERT INTO events_types (event_id, type_id) VALUES (3,3);

INSERT INTO tags (description) VALUES ('concerto');
INSERT INTO tags (description) VALUES ('live');
INSERT INTO tags (description) VALUES ('música ao vivo');
INSERT INTO tags (description) VALUES ('cinema');
INSERT INTO tags (description) VALUES ('Ao ar livre');
INSERT INTO tags (description) VALUES ('Coliseu');
INSERT INTO tags (description) VALUES ('free');
INSERT INTO tags (description) VALUES ('grátis');

INSERT INTO tags_events VALUES(1,1,1);
INSERT INTO tags_events VALUES(1,2,1);
INSERT INTO tags_events VALUES(2,3,1);
INSERT INTO tags_events VALUES(3,4,1);
INSERT INTO tags_events VALUES(1,5,1);