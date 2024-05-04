drop table IF EXISTS appuser cascade;
DROP TYPE IF EXISTS game_genres CASCADE;
DROP TYPE IF EXISTS webgames CASCADE;
DROP TABLE IF EXISTS game_liked CASCADE;
DROP TABLE IF EXISTS stats CASCADE;

CREATE TYPE game_genres AS ENUM('action', 'adventure', 'strategy', 'sports', 'puzzle', 'multiplayer_online', 'role_playing', 'simulation');
CREATE TYPE webgames AS ENUM('Guess Game', 'Rock Paper Scissors', 'Frogs Game');

create table IF NOT EXISTS appuser (
	userid varchar(50) primary key,
	password varchar(50) NOT NULL,
	email VARCHAR(50),
	coffee VARCHAR(50),
	weekday VARCHAR(50)
);

create table IF NOT EXISTS game_liked (
	userid VARCHAR(50) REFERENCES appuser(userid) ON DELETE CASCADE ON UPDATE CASCADE,
	game game_genres,
	PRIMARY KEY(userid, game)
);

create table IF NOT EXISTS stats (
	userid VARCHAR(50) REFERENCES appuser(userid) ON DELETE CASCADE ON UPDATE CASCADE,
	webgame webgames,
	best_game INTEGER,
	total_played INTEGER NOT NULL,
	total_won INTEGER NOT NULL,
	loosable_game BOOLEAN NOT NULL,
	PRIMARY KEY(userid, webgame)
);

INSERT INTO appuser (userid, password, email, coffee, weekday) VALUES ('auser', 'apassword', NULL, NULL, NULL);
INSERT INTO stats (userid, webgame, best_game, total_played, total_won, loosable_game) VALUES ('auser', 'Guess Game', NULL, 0, 0, FALSE);
INSERT INTO stats (userid, webgame, best_game, total_played, total_won, loosable_game) VALUES ('auser', 'Rock Paper Scissors', NULL, 0, 0, TRUE);
INSERT INTO stats (userid, webgame, best_game, total_played, total_won, loosable_game) VALUES ('auser', 'Frogs Game', NULL, 0, 0, TRUE);