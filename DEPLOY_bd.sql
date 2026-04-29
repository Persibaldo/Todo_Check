-- ======================================================
-- 1. ELIMINACIÓN DE TABLAS
-- ======================================================
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS juego_generos;
DROP TABLE IF EXISTS libro_generos;
DROP TABLE IF EXISTS anime_generos;
DROP TABLE IF EXISTS serie_generos;
DROP TABLE IF EXISTS peli_generos;
DROP TABLE IF EXISTS juegos;
DROP TABLE IF EXISTS libros;
DROP TABLE IF EXISTS anime;
DROP TABLE IF EXISTS series;
DROP TABLE IF EXISTS pelis;
DROP TABLE IF EXISTS generos;
DROP TABLE IF EXISTS usuarios;
SET FOREIGN_KEY_CHECKS = 1;

-- ======================================================
-- 2. CREACIÓN DE TABLAS 
-- ======================================================

CREATE TABLE usuarios (
    id_usuario INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    contraseña varchar (20),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_usuario)
);

CREATE TABLE generos (
    id_genero INT NOT NULL AUTO_INCREMENT,
    nombre_genero VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (id_genero)
);

CREATE TABLE pelis (
    id_peli INT NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    director VARCHAR(100),
    duracion_min INT,
    PRIMARY KEY (id_peli)
);

CREATE TABLE series (
    id_serie INT NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    temporadas INT,
    en_emision BOOLEAN,
    PRIMARY KEY (id_serie)
);

CREATE TABLE anime (
    id_anime INT NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    estudio VARCHAR(100),
    episodios INT,
    PRIMARY KEY (id_anime)
);

CREATE TABLE libros (
    id_libro INT NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(100),
    paginas INT,
    PRIMARY KEY (id_libro)
);

CREATE TABLE juegos (
    id_juego INT NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    plataforma VARCHAR(100),
    desarrollador VARCHAR(100),
    PRIMARY KEY (id_juego)
);

-- Tablas Puente
CREATE TABLE peli_generos (
    id_peli INT NOT NULL, id_genero INT NOT NULL,
    PRIMARY KEY (id_peli, id_genero),
    FOREIGN KEY (id_peli) REFERENCES pelis(id_peli) ON DELETE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero) ON DELETE CASCADE
);

CREATE TABLE serie_generos (
    id_serie INT NOT NULL, id_genero INT NOT NULL,
    PRIMARY KEY (id_serie, id_genero),
    FOREIGN KEY (id_serie) REFERENCES series(id_serie) ON DELETE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero) ON DELETE CASCADE
);

CREATE TABLE anime_generos (
    id_anime INT NOT NULL, id_genero INT NOT NULL,
    PRIMARY KEY (id_anime, id_genero),
    FOREIGN KEY (id_anime) REFERENCES anime(id_anime) ON DELETE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero) ON DELETE CASCADE
);

CREATE TABLE libro_generos (
    id_libro INT NOT NULL, id_genero INT NOT NULL,
    PRIMARY KEY (id_libro, id_genero),
    FOREIGN KEY (id_libro) REFERENCES libros(id_libro) ON DELETE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero) ON DELETE CASCADE
);

CREATE TABLE juego_generos (
    id_juego INT NOT NULL, id_genero INT NOT NULL,
    PRIMARY KEY (id_juego, id_genero),
    FOREIGN KEY (id_juego) REFERENCES juegos(id_juego) ON DELETE CASCADE,
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero) ON DELETE CASCADE
);

-- ======================================================
-- 3. INSERCIÓN DE DATOS
-- ======================================================

--USUS

INSERT INTO usuarios (nombre, email, contraseña) VALUES 
('Alex Marin', 'alex@mail.com', 'admin1234'),
('Maria Lopez', 'maria@mail.com', 'peli_fan_99'),
('Carlos Ruiz', 'cruiz@mail.com', 'dragon_ball_z'),
('Lucia Sanz', 'lucia@mail.com', 'libro_secreto'),
('Elena Gomez', 'elena@mail.com', 'gamer_girl_2024');


--GENEROS

INSERT INTO generos (nombre_genero) VALUES 
('Acción'), ('Aventura'), ('Ciencia Ficción'), ('Fantasía'), ('Terror'), 
('Drama'), ('Comedia'), ('Romance'), ('Thriller'), ('Misterio'), 
('Suspenso'), ('Histórico'), ('Bélico'), ('Western'), ('Musical'), 
('Documental'), ('Animación'), ('Cyberpunk'), ('Post-apocalíptico'), ('Space Opera'),
('Shonen'), ('Seinen'), ('Shojo'), ('Mecha'), ('Slice of Life'),
('RPG'), ('FPS'), ('Plataformas'), ('Estrategia'), ('Terror Psicológico');

--PELIS

INSERT INTO pelis (titulo, director, duracion_min) VALUES 
('Inception','Christopher Nolan',148),('The Matrix','Lana Wachowski',136),('Interstellar','Christopher Nolan',169),('Pulp Fiction','Quentin Tarantino',154),('The Godfather','Francis Coppola',175),('Seven','David Fincher',127),('Parasite','Bong Joon-ho',132),('Blade Runner 2049','Denis Villeneuve',164),('Mad Max: Fury Road','George Miller',120),('The Dark Knight','Christopher Nolan',152),('Your Name','Makoto Shinkai',106),('Spirited Away','Hayao Miyazaki',125),('Gladiator','Ridley Scott',155),('The Departed','Martin Scorsese',151),('Whiplash','Damien Chazelle',106),('The Prestige','Christopher Nolan',130),('Alien','Ridley Scott',117),('The Thing','John Carpenter',109),('Joker','Todd Phillips',122),('Arrival','Denis Villeneuve',116),('Dune','Denis Villeneuve',155),('Oldboy','Park Chan-wook',120),('Heat','Michael Mann',170),('The Shining','Stanley Kubrick',146),('Inglourious Basterds','Quentin Tarantino',153),('John Wick','Chad Stahelski',101),('Everything Everywhere All At Once','The Daniels',139),('Logan','James Mangold',137),('Children of Men','Alfonso Cuarón',109),('Memento','Christopher Nolan',113);

--SERIES

INSERT INTO series (titulo, temporadas, en_emision) VALUES 
('Breaking Bad',5,0),('Game of Thrones',8,0),('The Wire',5,0),('The Sopranos',6,0),('Stranger Things',4,1),('The Mandalorian',3,1),('Succession',4,0),('The Bear',2,1),('Better Call Saul',6,0),('Dark',3,0),('The Boys',3,1),('Black Mirror',6,1),('Chernobyl',1,0),('Mindhunter',2,0),('The Crown',6,0),('Severance',1,1),('The Last of Us',1,1),('Ted Lasso',3,0),('The Office (US)',9,0),('Fargo',5,1),('True Detective',4,1),('Peaky Blinders',6,0),('House of the Dragon',1,1),('Mad Men',7,0),('Twin Peaks',3,0),('The Expanse',6,0),('Battlestar Galactica',4,0),('Andor',1,1),('The White Lotus',2,1),('Sherlock',4,0);

--ANIMU

INSERT INTO anime (titulo, estudio, episodios) VALUES 
('Fullmetal Alchemist: B','Bones',64),('Attack on Titan','MAPPA',87),('Death Note','Madhouse',37),('Cowboy Bebop','Sunrise',26),('One Piece','Toei',1080),('Naruto Shippuden','Pierrot',500),('Hunter x Hunter','Madhouse',148),('Steins;Gate','White Fox',24),('Neon Genesis Evangelion','Gainax',26),('Vinland Saga','MAPPA',48),('Jujutsu Kaisen','MAPPA',47),('Demon Slayer','Ufotable',55),('Monster','Madhouse',74),('Code Geass','Sunrise',50),('Mob Psycho 100','Bones',37),('Haikyuu!!','Production I.G',85),('My Hero Academia','Bones',138),('Spy x Family','Wit Studio',37),('Chainsaw Man','MAPPA',12),('Berserk','OLM',25),('Samurai Champloo','Manglobe',26),('Made in Abyss','Kinema Citrus',25),('Psycho-Pass','Production I.G',41),('Ghost in the Shell','Production I.G',52),('Cyberpunk: Edgerunners','Trigger',10),('Bleach','Pierrot',366),('Frieren','Madhouse',28),('Blue Lock','Eight Bit',24),('Gurren Lagann','Gainax',27),('Erased','A-1 Pictures',12);

--LIBROS

INSERT INTO libros (titulo, autor, paginas) VALUES 
('Cien años de soledad','García Márquez',471),('1984','George Orwell',328),('Un mundo feliz','Aldous Huxley',256),('El Señor de los Anillos','J.R.R. Tolkien',1216),('Fundación','Isaac Asimov',255),('Neuromante','William Gibson',320),('El nombre del viento','Patrick Rothfuss',880),('El resplandor','Stephen King',447),('Drácula','Bram Stoker',418),('Frankenstein','Mary Shelley',280),('Fahrenheit 451','Ray Bradbury',176),('Crímenes ilustrados','Modesto García',100),('El problema de los 3 cuerpos','Cixin Liu',416),('Sapiens','Harari',496),('Meditaciones','Marco Aurelio',256),('El código Da Vinci','Dan Brown',608),('Dune','Frank Herbert',612),('Hyperion','Dan Simmons',482),('Guerra y Paz','Lev Tolstói',1224),('Crimen y castigo','Dostoyevski',672),('El retrato de Dorian Gray','Oscar Wilde',254),('Los pilares de la Tierra','Ken Follett',1068),('El cuento de la criada','Margaret Atwood',311),('La carretera','Cormac McCarthy',210),('Crónicas Marcianas','Ray Bradbury',256),('Solaris','Stanislaw Lem',224),('El alquimista','Paulo Coelho',192),('La sombra del viento','Zafón',576),('Rebelión en la granja','George Orwell',112),('El Hobbit','J.R.R. Tolkien',310);

--JUEGOS

INSERT INTO juegos (titulo, plataforma, desarrollador) VALUES 
('Zelda: BOTW','Switch','Nintendo'),('Elden Ring','Multi','FromSoftware'),('The Witcher 3','Multi','CD Projekt'),('God of War Ragnarok','PS5','Santa Monica'),('Red Dead 2','Multi','Rockstar'),('TLOU Part II','PS4','Naughty Dog'),('Cyberpunk 2077','Multi','CD Projekt'),('Halo Infinite','Xbox/PC','343 Ind.'),('Hades','Multi','Supergiant'),('Stardew Valley','Multi','ConcernedApe'),('Baldur''s Gate 3','Multi','Larian'),('RE4 Remake','Multi','Capcom'),('Ghost of Tsushima','PS5','Sucker Punch'),('Sekiro','Multi','FromSoftware'),('Bloodborne','PS4','FromSoftware'),('Horizon Forbidden West','PS5','Guerrilla'),('Mario Odyssey','Switch','Nintendo'),('Doom Eternal','Multi','id Software'),('FFVII Rebirth','PS5','Square Enix'),('Persona 5 Royal','Multi','Atlus'),('Mass Effect LE','Multi','BioWare'),('Half-Life: Alyx','PC VR','Valve'),('Portal 2','Multi','Valve'),('Bioshock Infinite','Multi','Irrational'),('Dark Souls III','Multi','FromSoftware'),('Spider-Man 2','PS5','Insomniac'),('Minecraft','Multi','Mojing'),('Overwatch 2','Multi','Blizzard'),('Street Fighter 6','Multi','Capcom'),('Hollow Knight','Multi','Team Cherry');

-- GENEROS y otros

INSERT INTO peli_generos (id_peli, id_genero) VALUES (1,3),(1,9),(2,3),(3,3),(4,9),(5,6),(6,9),(7,6),(8,3),(9,1),(10,1),(11,17),(12,17),(13,1),(14,9),(15,6),(16,10),(17,5),(18,5),(19,6),(20,3),(21,3),(22,9),(23,1),(24,5),(25,13),(26,1),(27,3),(28,1),(29,19),(30,10);
INSERT INTO serie_generos (id_serie, id_genero) VALUES (1,6),(2,4),(3,6),(4,6),(5,4),(6,20),(7,6),(8,6),(9,6),(10,3),(11,1),(12,3),(13,6),(14,9),(15,6),(16,3),(17,6),(18,7),(19,7),(20,9),(21,10),(22,6),(23,4),(24,6),(25,10),(26,20),(27,20),(28,20),(29,6),(30,10);
INSERT INTO anime_generos (id_anime, id_genero) VALUES (1,21),(2,21),(3,22),(4,20),(5,21),(6,21),(7,21),(8,3),(9,24),(10,22),(11,21),(12,21),(13,22),(14,24),(15,21),(16,21),(17,21),(18,21),(19,1),(20,22),(21,2),(22,4),(23,18),(24,18),(25,18),(26,21),(27,4),(28,21),(29,24),(30,10);
INSERT INTO libro_generos (id_libro, id_genero) VALUES (1,6),(2,3),(3,3),(4,4),(5,3),(6,18),(7,4),(8,5),(9,5),(10,5),(11,3),(12,10),(13,3),(14,16),(15,6),(16,10),(17,3),(18,3),(19,12),(20,6),(21,6),(22,12),(23,19),(24,19),(25,3),(26,3),(27,4),(28,10),(29,6),(30,4);
INSERT INTO juego_generos (id_juego, id_genero) VALUES (1,2),(2,26),(3,26),(4,1),(5,2),(6,1),(7,18),(8,27),(9,26),(10,25),(11,26),(12,5),(13,1),(14,1),(15,26),(16,1),(17,28),(18,27),(19,26),(20,26),(21,20),(22,3),(23,28),(24,27),(25,26),(26,1),(27,2),(28,27),(29,1),(30,28);
