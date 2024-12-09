CREATE DATABASE dbAlgoZ;

USE dbAlgoZ;

CREATE TABLE usuario (
	codUsuario SMALLINT AUTO_INCREMENT,
	nomeUsuario VARCHAR (100) NOT NULL,
	email VARCHAR (100) NOT NULL,
	senha VARCHAR (100) NOT NULL,
	personagem SMALLINT,
	mestre BOOLEAN,
	PRIMARY KEY (codUsuario)
);
	

CREATE TABLE item (
	codItem SMALLINT AUTO_INCREMENT,
	nomeItem VARCHAR (30) NOT NULL,
	forca MEDIUMINT NOT NULL,
	inteligencia MEDIUMINT NOT NULL,
	destreza TINYINT NOT NULL,
	vida INT NOT NULL,
	PRIMARY KEY (codItem)
);

CREATE TABLE habilidade (
	codHabilidade SMALLINT AUTO_INCREMENT,
	nomeHabilidade VARCHAR (30) NOT NULL,
	forca TINYINT NOT NULL,
	inteligencia TINYINT NOT NULL,
	destreza TINYINT NOT NULL,
	vida TINYINT NOT NULL,
	PRIMARY KEY (codHabilidade)
);


CREATE TABLE persona (
	codPersona SMALLINT AUTO_INCREMENT,
	nomePersona VARCHAR (100) NOT NULL,
	classe VARCHAR (30) NOT NULL,
	forca TINYINT NOT NULL,
	inteligencia TINYINT NOT NULL,
	destreza TINYINT NOT NULL,
	vida INT NOT NULL,
	usuario SMALLINT NOT NULL,
	item SMALLINT, 
	skill SMALLINT,
	PRIMARY KEY (codPersona),
	FOREIGN KEY (usuario) REFERENCES usuario (codUsuario),
	FOREIGN KEY (item) REFERENCES item (codItem),
	FOREIGN KEY (skill) REFERENCES habilidade (codHabilidade)
);

ALTER TABLE usuario ADD FOREIGN KEY (personagem) REFERENCES persona (codPersona);


CREATE TABLE jogo (
	codJogo SMALLINT AUTO_INCREMENT,
	cenario VARCHAR (30) NOT NULL,
	ladosDado SMALLINT NOT NULL,
	numDado SMALLINT,
	mestre SMALLINT NOT NULL,
	player1 SMALLINT,
	player2 SMALLINT,
	player3 SMALLINT,
	oponente SMALLINT,
	PRIMARY KEY (codJogo),
	FOREIGN KEY (mestre) REFERENCES usuario (codUsuario),
	FOREIGN KEY (player1) REFERENCES usuario (codUsuario),
	FOREIGN KEY (player2) REFERENCES usuario (codUsuario),
	FOREIGN KEY (player3) REFERENCES usuario (codUsuario),
	FOREIGN KEY (oponente) REFERENCES persona (codPersona)
);
