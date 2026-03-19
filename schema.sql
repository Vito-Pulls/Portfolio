-- ============================================
-- PORTFOLIO — Schema de base de datos
-- ============================================

CREATE DATABASE IF NOT EXISTS portfolio
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE portfolio;

-- Tabla de posts del blog
CREATE TABLE IF NOT EXISTS posts (
  id            INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  titulo        VARCHAR(255)     NOT NULL,
  slug          VARCHAR(255)     NOT NULL UNIQUE,
  resumen       TEXT             NOT NULL,
  contenido     LONGTEXT         NOT NULL,
  imagen_portada VARCHAR(255)    DEFAULT NULL,
  publicado     TINYINT(1)       NOT NULL DEFAULT 0,
  creado_en     DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP
                                 ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX idx_slug      (slug),
  INDEX idx_publicado (publicado),
  INDEX idx_creado_en (creado_en)
) ENGINE=InnoDB;

-- Posts de ejemplo
INSERT INTO posts (titulo, slug, resumen, contenido, publicado) VALUES
(
  'Mi primer post en el blog',
  'mi-primer-post',
  'Una introducción a este espacio donde comparto lo que voy aprendiendo como desarrollador web.',
  '<p>Bienvenido a mi blog. Aquí escribiré sobre desarrollo web, experiencias aprendiendo a programar y todo lo que vaya encontrando en el camino.</p><p>El objetivo es simple: documentar el proceso, compartir lo que aprendo y tener un registro de mi evolución como desarrollador.</p>',
  1
),
(
  'Por qué elegí PHP como primer backend',
  'por-que-php',
  'PHP tiene mala fama injustificada. Te cuento por qué creo que es una excelente elección para empezar.',
  '<p>Yo elegí PHP y no me arrepiento.</p><p>PHP mueve más del 75% de la web. Es estable, tiene documentación brutal y en el mercado local hay mucho trabajo con él.</p>',
  1
),
(
  'Post en borrador',
  'post-borrador',
  'Este post aún no está publicado.',
  '<p>Contenido en progreso...</p>',
  0
);