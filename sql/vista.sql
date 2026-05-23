CREATE OR REPLACE VIEW biblioteca_total AS 
              SELECT b.titulo, b.tipo, GROUP_CONCAT(g.nombre_genero SEPARATOR ', ') as nombre_genero
              FROM (
                  SELECT titulo, 'Peli' as tipo, id_peli as id_item FROM pelis
                  UNION ALL SELECT titulo, 'Serie', id_serie FROM series
                  UNION ALL SELECT titulo, 'Anime', id_anime FROM anime
                  UNION ALL SELECT titulo, 'Libro', id_libro FROM libros
                  UNION ALL SELECT titulo, 'Juego', id_juego FROM juegos
              ) b
              LEFT JOIN peli_generos pg ON (b.tipo = 'Peli' AND b.id_item = pg.id_peli)
              LEFT JOIN serie_generos sg ON (b.tipo = 'Serie' AND b.id_item = sg.id_serie)
              LEFT JOIN anime_generos ag ON (b.tipo = 'Anime' AND b.id_item = ag.id_anime)
              LEFT JOIN libro_generos lg ON (b.tipo = 'Libro' AND b.id_item = lg.id_libro)
              LEFT JOIN juego_generos jg ON (b.tipo = 'Juego' AND b.id_item = jg.id_juego)
              LEFT JOIN generos g ON (
                  g.id_genero = pg.id_genero OR 
                  g.id_genero = sg.id_genero OR 
                  g.id_genero = ag.id_genero OR 
                  g.id_genero = lg.id_genero OR 
                  g.id_genero = jg.id_genero
              )
              GROUP BY b.tipo, b.titulo;
