
CREATE TABLE events (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	title VARCHAR,
	fulltext VARCHAR,
	private Boolean,
	data Date,
	user VARCHAR REFERENCES users(username)
	ON UPDATE CASCADE
	ON DELETE CASCADE 
);

--rever conceitos e como iremos aceder
CREATE TABLE image(
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	title VARCHAR,
	description VARCHAR,
	image VARCHAR
);

CREATE TABLE imageEvent(
	event INTEGER  REFERENCES events(id)
	ON UPDATE CASCADE
	ON DELETE CASCADE 
,
	image INTEGER  REFERENCES image(id)
	ON UPDATE CASCADE
	ON DELETE CASCADE 
);

CREATE TABLE tag (
	description VARCHAR PRIMARY KEY
);

CREATE TABLE tagEvent(
	event INTEGER  REFERENCES events(id)	
	ON UPDATE CASCADE
	ON DELETE CASCADE 
	,
	tag   INTEGER  REFERENCES tag(id)
	ON UPDATE CASCADE
	ON DELETE CASCADE 
);

 CREATE TABLE eventsUsers (
	attending INTEGER REFERENCES users(username)
	ON UPDATE CASCADE
	ON DELETE CASCADE 
	,
	event 	  INTEGER REFERENCES events(id)
	ON UPDATE CASCADE
	ON DELETE CASCADE 
);

CREATE TABLE users (
  	username VARCHAR PRIMARY KEY,
  	password VARCHAR
);

INSERT INTO events VALUES (NULL, 'Sed nibh arcu', 'Sed nibh arcu, euismod elementum commodo ut, auctor id quam. Ut imperdiet diam.',0,0,NULL);

INSERT INTO events VALUES (NULL, 'Sed justo metus', 'Sed justo metus, suscipit non fermentum non, sagittis quis arcu. Curabitur tincidunt leo non blandit.',0,0,NULL);

INSERT INTO events VALUES (NULL, 'Maecenas ipsum elit', 'Maecenas ipsum elit, vestibulum id blandit vel, euismod ut urna. Sed nisi lectus.',0,0,NULL);

INSERT INTO events VALUES (NULL, 'Maecenas quis felis', 'Maecenas quis felis et tortor adipiscing blandit vel ac sem. Sed venenatis justo.',0,0,NULL);

INSERT INTO events VALUES (NULL, 'In vulputate velit nunc', 'In vulputate velit nunc. Duis sollicitudin sapien at nulla pellentesque non consequat.',0,0,NULL);

 
INSERT INTO users VALUES ('admin', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3'); -- Password is tested hashed with SHA 1

INSERT INTO users VALUES('Filipe','2e6f9b0d5885b6010f9167787445617f553a735f');

INSERT INTO tag VALUES (NULL,'concerto');
INSERT INTO tag VALUES (NULL,'live');
INSERT INTO tag VALUES (NULL,'música ao vivo');
INSERT INTO tag VALUES (NULL,'cinema');
INSERT INTO tag VALUES (NULL,'Ao ar livre');
INSERT INTO tag VALUES (NULL,'Coliseu');
INSERT INTO tag VALUES (NULL,'free');
INSERT INTO tag VALUES (NULL,'grátis');

INSERT INTO tagEvent VALUES(0,0);
INSERT INTO tagEvent VALUES(1,2);
INSERT INTO tagEvent VALUES(2,3);
INSERT INTO tagEvent VALUES(3,4);
INSERT INTO tagEvent VALUES(0,5);