

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
DROP TABLE IF EXISTS tags_events;
DROP TABLE IF EXISTS users_images;
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
	FOREIGN KEY(user_id) REFERENCES users ( username ) ON UPDATE CASCADE ON DELETE CASCADE
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
	FOREIGN KEY(image_id) REFERENCES images ( id ) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE events_users (
	user_id	INTEGER,
	event_id	INTEGER,
	visible	Boolean DEFAULT 1,
	FOREIGN KEY(user_id) REFERENCES users ( id ) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(event_id) REFERENCES events ( id ) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE events_images (
	event_id	INTEGER,
	image_id	INTEGER,
	visible	Boolean DEFAULT 1,
	FOREIGN KEY(event_id) REFERENCES events ( id ) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(image_id) REFERENCES image ( id ) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE tags_events (
	event_id	INTEGER,
	tag_id	INTEGER,
	visible	Boolean DEFAULT 1,
	FOREIGN KEY(event_id) REFERENCES events ( id ) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(tag_id) REFERENCES tag ( id ) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'Sed nibh arcu', 'Sed nibh arcu, euismod elementum commodo ut, auctor id quam. Ut imperdiet diam.',0,NULL,0,1);

INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'Sed justo metus', 'Sed justo metus, suscipit non fermentum non, sagittis quis arcu. Curabitur tincidunt leo non blandit.',0,NULL,0,1);

INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'Maecenas ipsum elit', 'Maecenas ipsum elit, vestibulum id blandit vel, euismod ut urna. Sed nisi lectus.',0,NULL,0,1);

INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'Maecenas quis felis', 'Maecenas quis felis et tortor adipiscing blandit vel ac sem. Sed venenatis justo.',0,NULL,0,1);

INSERT INTO events(title,fulltext,private,data,user_id,visible) VALUES ( 'In vulputate velit nunc', 'In vulputate velit nunc. Duis sollicitudin sapien at nulla pellentesque non consequat.',0,NULL,0,1);

 
INSERT INTO users(id,username,password,fullname,visible) VALUES (NULL,'admin', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3',NULL,1); -- Password is tested hashed with SHA 1

INSERT INTO users(id,username,password,fullname,visible) VALUES(NULL,'Filipe','2e6f9b0d5885b6010f9167787445617f553a735f',NULL,1);

INSERT INTO tags (description,visible) VALUES ('concerto',1);
INSERT INTO tags (description,visible) VALUES ('live',1);
INSERT INTO tags (description,visible) VALUES ('música ao vivo',1);
INSERT INTO tags (description,visible) VALUES ('cinema',1);
INSERT INTO tags (description,visible) VALUES ('Ao ar livre',1);
INSERT INTO tags (description,visible) VALUES ('Coliseu',1);
INSERT INTO tags (description,visible) VALUES ('free',1);
INSERT INTO tags (description,visible) VALUES ('grátis',1);

INSERT INTO tags_events VALUES(1,1,1);
INSERT INTO tags_events VALUES(1,2,1);
INSERT INTO tags_events VALUES(2,3,1);
INSERT INTO tags_events VALUES(3,4,1);
INSERT INTO tags_events VALUES(1,5,1);