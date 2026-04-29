CREATE OR REPLACE VIEW biblioteca_total AS
SELECT id_genero, titulo, 'Película' AS tipo FROM pelis p JOIN peli_generos pg ON p.id_peli = pg.id_peli
UNION ALL
SELECT id_genero, titulo, 'Serie' AS tipo FROM series s JOIN serie_generos sg ON s.id_serie = sg.id_serie
UNION ALL
SELECT id_genero, titulo, 'Anime' AS tipo FROM anime a JOIN anime_generos ag ON a.id_anime = ag.id_anime
UNION ALL
SELECT id_genero, titulo, 'Libro' AS tipo FROM libros l JOIN libro_generos lg ON l.id_libro = lg.id_libro
UNION ALL
SELECT id_genero, titulo, 'Juego' AS tipo FROM juegos j JOIN juego_generos jg ON j.id_juego = jg.id_juego;
