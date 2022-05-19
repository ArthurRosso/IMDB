DROP TABLE IF EXISTS noticia_noticia CASCADE;
DROP TABLE IF EXISTS usuario_programa_lista CASCADE;
DROP TABLE IF EXISTS programa_tag CASCADE;
DROP TABLE IF EXISTS participa_como CASCADE;
DROP TABLE IF EXISTS pessoa_imagem CASCADE;
DROP TABLE IF EXISTS pessoa_programa CASCADE;
DROP TABLE IF EXISTS imagem CASCADE;
DROP TABLE IF EXISTS noticia CASCADE;
DROP TABLE IF EXISTS pessoa CASCADE;
DROP TABLE IF EXISTS cargo CASCADE;
DROP TABLE IF EXISTS usuario CASCADE;
DROP TABLE IF EXISTS tag CASCADE;
DROP TABLE IF EXISTS traducao CASCADE;
DROP TABLE IF EXISTS programa CASCADE;
DROP TABLE IF EXISTS lugar CASCADE;

CREATE TABLE lugar (
    cod SERIAL,
    nome VARCHAR(50),
    PRIMARY KEY(cod)
);

CREATE TABLE programa (
    cod SERIAL,
    tipo VARCHAR (8),
    origem INTEGER REFERENCES lugar,
    ano INTEGER,
    titulo_original VARCHAR(50),
    CHECK (tipo IN ('Série', 'Filme', 'Episódio')),
    PRIMARY KEY(cod)
);

CREATE TABLE traducao (
    cod SERIAL,
    cod_programa INTEGER,
    cod_lugar INTEGER,
    data_lanc DATE,
    titulo VARCHAR(50),
    PRIMARY KEY(cod, cod_programa),
    FOREIGN KEY(cod_programa) REFERENCES programa,
    FOREIGN KEY(cod_lugar) REFERENCES lugar
);

CREATE TABLE tag (
    cod SERIAL,
    nome VARCHAR (50),
    PRIMARY KEY(cod)
);

CREATE TABLE usuario (
    cod SERIAL,
    senha VARCHAR (64),
    nome VARCHAR (50),
    email VARCHAR (50),
    PRIMARY KEY(cod)
);

CREATE TABLE cargo (
    cod SERIAL,
    nome VARCHAR (50),
    PRIMARY KEY(cod)
);

CREATE TABLE pessoa (
    cod SERIAL,
    nome VARCHAR (50),
    data_nasc DATE,
    PRIMARY KEY(cod)
);

CREATE TABLE noticia (
    cod SERIAL,
    conteudo VARCHAR (1024),
    PRIMARY KEY(cod)
);

-- CAMINHO: Caminho relativo do arquivo no disco rígido 
CREATE TABLE imagem (
    cod SERIAL,
    cod_programa INTEGER,
    caminho VARCHAR (256),
    PRIMARY KEY(cod_programa, cod),
    FOREIGN KEY(cod_programa) REFERENCES programa
);

CREATE TABLE pessoa_programa (
    cod_pessoa INTEGER,
    cod_programa INTEGER,
    PRIMARY KEY (cod_pessoa, cod_programa),
    FOREIGN KEY(cod_programa) REFERENCES programa,
    FOREIGN KEY(cod_pessoa) REFERENCES pessoa
);

-- Tabela indicando que pessoas aparecem em que fotos
CREATE TABLE pessoa_imagem (
    cod_pessoa INTEGER,
    cod_programa INTEGER,
    cod_imagem INTEGER,
    PRIMARY KEY(cod_pessoa, cod_programa, cod_imagem),
    FOREIGN KEY(cod_pessoa) REFERENCES pessoa,
    FOREIGN KEY(cod_programa, cod_imagem) REFERENCES imagem
);

-- Quem faz o que onde
CREATE TABLE participa_como (
    cod_pessoa INTEGER, 
    cod_cargo INTEGER,
    cod_programa INTEGER, 
    PRIMARY KEY(cod_programa, cod_pessoa, cod_cargo),
    FOREIGN KEY(cod_programa) REFERENCES programa,
    FOREIGN KEY(cod_pessoa) REFERENCES pessoa,
    FOREIGN KEY(cod_cargo) REFERENCES cargo
);

-- As tags de um PROGRAMA
CREATE TABLE programa_tag (
    cod_programa INTEGER,
    cod_tag INTEGER,
    PRIMARY KEY(cod_programa, cod_tag),
    FOREIGN KEY(cod_tag) REFERENCES tag,
    FOREIGN KEY(cod_programa) REFERENCES programa
);

-- A watchlist dos usuarios
CREATE TABLE usuario_programa_lista (
    cod_usuario INTEGER,
    cod_programa INTEGER,
    nota SMALLINT,
    CHECK (nota >= 0 AND nota <= 10),
    texto VARCHAR(512),
    PRIMARY KEY(cod_programa, cod_usuario),
    FOREIGN KEY(cod_usuario) REFERENCES usuario,
    FOREIGN KEY(cod_programa) REFERENCES programa
);

CREATE TABLE noticia_noticia (
    cod_noticia_src INTEGER,
    cod_noticia_tgt INTEGER,
    PRIMARY KEY(cod_noticia_src, cod_noticia_tgt),
    FOREIGN KEY(cod_noticia_src) REFERENCES noticia,
    FOREIGN KEY(cod_noticia_tgt) REFERENCES noticia
);


INSERT INTO lugar VALUES (1, 'Brasil');
INSERT INTO lugar VALUES (2, 'Alemanha');
INSERT INTO lugar VALUES (3, 'França');
INSERT INTO lugar VALUES (4, 'Japão');
INSERT INTO lugar VALUES (5, 'EUA');
INSERT INTO lugar VALUES (6, 'Coreia do Sul');
INSERT INTO lugar VALUES (7, 'Portugal');

INSERT INTO tag VALUES (1, 'Drama');
INSERT INTO tag VALUES (2, 'Ação');
INSERT INTO tag VALUES (3, 'Terror');
INSERT INTO tag VALUES (4, 'Comédia');
INSERT INTO tag VALUES (5, 'Suspense');
INSERT INTO tag VALUES (6, 'Crime');
INSERT INTO tag VALUES (7, 'Guerra');
INSERT INTO tag VALUES (8, 'Aventura');
INSERT INTO tag VALUES (9, 'Fantasia');
INSERT INTO tag VALUES (10, 'Sci-Fi');

INSERT INTO cargo VALUES (1,'Ator');
INSERT INTO cargo VALUES (2,'Diretor');
INSERT INTO cargo VALUES (3,'Roteirista');
INSERT INTO cargo VALUES (4,'Escritor');

-- popular o banco de dados para as consultas
-- inserir drive my car e pessoas relevantes
INSERT INTO programa VALUES (1, 'Filme', 4, 2021, 'Doraibu Mai Kaa');
INSERT INTO traducao VALUES (1, 1, 4, '2021-08-20', 'Doraibu Mai Kaa');
INSERT INTO traducao VALUES (2, 1, 5, '2021-10-03', 'Drive My Car');
INSERT INTO pessoa VALUES (1, 'Ryusuke Hamaguchi', '1978-12-16');
INSERT INTO pessoa VALUES (2, 'Hidetoshi Nishijima', '1971-03-29');
INSERT INTO pessoa VALUES (3, 'Haruki Murakami', '1949-01-12');
        -- (pessoa, programa)
INSERT INTO pessoa_programa VALUES (1, 1);
INSERT INTO pessoa_programa VALUES (2, 1);
INSERT INTO pessoa_programa VALUES (3, 1);
        -- (pessoa, cargo, programa)
INSERT INTO participa_como VALUES (1, 2, 1);
INSERT INTO participa_como VALUES (2, 1, 1);
INSERT INTO participa_como VALUES (3, 4, 1);
INSERT INTO programa_tag VALUES (1, 1);

-- inserir parasite e pessoas relevantes
INSERT INTO programa VALUES (2, 'Filme', 6, 2019, 'Gisaengchung');
INSERT INTO traducao VALUES (3, 2, 5, '2019-05-21', 'Parasite');
INSERT INTO traducao VALUES (4, 2, 6, '2019-05-21', 'Gisaengchung');
INSERT INTO traducao VALUES (5, 2, 1, '2019-11-07', 'Parasita');
INSERT INTO traducao VALUES (6, 2, 7, '2019-09-26', 'Parasitas');
INSERT INTO pessoa VALUES (4, 'Bong Joon-ho', '1969-09-14');
INSERT INTO pessoa_programa VALUES (4, 2);
INSERT INTO participa_como VALUES (4, 2, 2);
INSERT INTO programa_tag VALUES (2, 1);
INSERT INTO programa_tag VALUES (2, 4);
INSERT INTO programa_tag VALUES (2, 5);

-- inserir breaking bad e pessoas relevantes
INSERT INTO programa VALUES (3, 'Série', 5, 2008, 'Breaking Bad');
INSERT INTO traducao VALUES (7, 3, 5, '2008-01-20', 'Breaking Bad');
INSERT INTO pessoa VALUES (5, 'Vince Gilligan', '1967-02-10');
INSERT INTO pessoa_programa VALUES (5, 3);
INSERT INTO participa_como VALUES (5, 2, 3);
INSERT INTO programa_tag VALUES (3, 6);
INSERT INTO programa_tag VALUES (3, 1);
INSERT INTO programa_tag VALUES (3, 5);

-- inserir alguns filmes do kurosawa
INSERT INTO pessoa VALUES (6, 'Akira Kurosawa', '1910-03-23');
-- seven samurai
INSERT INTO programa VALUES (4, 'Filme', 4, 1954, 'Shichinin no samurai');
INSERT INTO traducao VALUES (8, 4, 5, '1956-11-19', 'Seven Samurai');
INSERT INTO traducao VALUES (9, 4, 1, '1956-11-19', 'Os Sete Samurais');
INSERT INTO programa_tag VALUES (4, 2);
INSERT INTO programa_tag VALUES (4, 1);
INSERT INTO pessoa_programa VALUES (6, 4);
INSERT INTO participa_como VALUES (6, 2, 4);
INSERT INTO participa_como VALUES (6, 3, 4);
-- yojimbo
INSERT INTO programa VALUES (5, 'Filme', 4, 1961, 'Yoojinboo');
INSERT INTO traducao VALUES (10, 5, 5, '1961-09-13', 'Yojimbo');
INSERT INTO programa_tag VALUES (5, 2);
INSERT INTO programa_tag VALUES (5, 1);
INSERT INTO programa_tag VALUES (5, 5);
INSERT INTO pessoa_programa VALUES (6, 5);
INSERT INTO participa_como VALUES (6, 2, 5);
-- ran
INSERT INTO programa VALUES (6, 'Filme', 4, 1985, 'Ran');
INSERT INTO programa_tag VALUES (6, 2);
INSERT INTO programa_tag VALUES (6, 1);
INSERT INTO programa_tag VALUES (6, 7);
INSERT INTO pessoa_programa VALUES (6, 6);
INSERT INTO participa_como VALUES (6, 2, 6);
INSERT INTO participa_como VALUES (6, 3, 6);

-- inserir alguns filmes de 2022
INSERT INTO programa VALUES (7, 'Filme', 5, 2022, 'Sonic the Hedgehog 2');
INSERT INTO traducao VALUES (11, 7, 1, '2022-04-07', 'Sonic 2 - O Filme');
INSERT INTO traducao VALUES (12, 7, 5, '2022-04-07', 'Sonic the Hedgehog 2');
INSERT INTO programa_tag VALUES (7, 2);
INSERT INTO programa_tag VALUES (7, 8);
INSERT INTO programa_tag VALUES (7, 4);

INSERT INTO programa VALUES (8, 'Filme', 5, 2022, 'Doctor Strange in the Multiverse of Madness');
INSERT INTO traducao VALUES (13, 8, 1, '2022-05-05', 'Doutor Estranho no Multiverso da Loucura');
INSERT INTO traducao VALUES (14, 8, 5, '2022-05-05', 'Doctor Strange in the Multiverse of Madness');
INSERT INTO programa_tag VALUES (8, 2);
INSERT INTO programa_tag VALUES (8, 8);
INSERT INTO programa_tag VALUES (8, 9);

INSERT INTO programa VALUES (9, 'Filme', 5, 2022, 'Avatar: The Way of Water');
INSERT INTO traducao VALUES (15, 9, 1, '2022-12-15', 'Avatar: O Caminho da Água');
INSERT INTO traducao VALUES (16, 9, 5, '2022-12-15', 'Avatar: The Way of Water');
INSERT INTO programa_tag VALUES (9, 2);
INSERT INTO programa_tag VALUES (9, 8);
INSERT INTO programa_tag VALUES (9, 10);
INSERT INTO pessoa VALUES (7, 'James Cameron', '1954-10-16');
INSERT INTO pessoa_programa VALUES (7, 9);
INSERT INTO participa_como VALUES (7, 2, 9);

-- inserir algumas outras series
INSERT INTO programa VALUES (10, 'Série', 5, 2004, 'Lost');
INSERT INTO traducao VALUES (17, 10, 5, '2004-09-22', 'Lost');
INSERT INTO programa_tag VALUES (10, 8);
INSERT INTO programa_tag VALUES (10, 1);
INSERT INTO programa_tag VALUES (10, 9);

INSERT INTO programa VALUES (11, 'Série', 5, 2011, 'Game of Thrones');
INSERT INTO traducao VALUES (18, 11, 5, '2011-04-17', 'Game of Thrones');
INSERT INTO traducao VALUES (19, 11, 1, '2011-04-17', 'A Guerra dos Tronos');
INSERT INTO programa_tag VALUES (11, 2);
INSERT INTO programa_tag VALUES (11, 8);
INSERT INTO programa_tag VALUES (11, 1);

-- inserir episodios avulsos
INSERT INTO programa VALUES (12, 'Episódio', 5, 2004, 'Lost S1E1 - Pilot (Part 1)');
INSERT INTO traducao VALUES (20, 12, 5, '2004-09-22', 'Lost S1E1 - Pilot (Part 1)');
INSERT INTO programa VALUES (13, 'Episódio', 5, 2004, 'Lost S1E2 - Pilot (Part 2)');
INSERT INTO traducao VALUES (21, 13, 5, '2004-09-29', 'Lost S1E2 - Pilot (Part 2)'); 

-- criar usuarios e adicionar filmes à lista
INSERT INTO usuario VALUES (1, 'pa$$word', 'User drop table', 'user@tabledropping.com');
INSERT INTO usuario_programa_lista VALUES (1, 1, 10, 'Muito bom');
INSERT INTO usuario_programa_lista VALUES (1, 3, 8, 'Bom');
INSERT INTO usuario_programa_lista VALUES (1, 7, 3, 'Não gostei');

INSERT INTO usuario VALUES (2, 'joaozinho123', 'João da review do youtube', 'joaao@gmail.com');
INSERT INTO usuario_programa_lista VALUES (2, 1, 7, 'Bom');
INSERT INTO usuario_programa_lista VALUES (2, 2, 6, 'OK');
INSERT INTO usuario_programa_lista VALUES (2, 4, 9, 'Um clássico');
INSERT INTO usuario_programa_lista VALUES (2, 5, 8, 'Muito bom');
INSERT INTO usuario_programa_lista VALUES (2, 9, 10, 'Ainda nem vi');

INSERT INTO usuario VALUES (3, '0934tuietg894h34343j4ju', 'Crítico do Oscar', 'criticas@oscar.com');
INSERT INTO usuario_programa_lista VALUES (3, 7, 5, 'Ruim');
INSERT INTO usuario_programa_lista VALUES (3, 8, 4, 'Muito ruim');
INSERT INTO usuario_programa_lista VALUES (3, 9, 9, 'Muito bom');

INSERT INTO usuario VALUES (4, 'senha123', 'sovejoseries', 'sovejoseries@hotmail.com');
INSERT INTO usuario_programa_lista VALUES (4, 3, 10, 'Gostei bastante');
INSERT INTO usuario_programa_lista VALUES (4, 10, 4, 'O final foi ruim');
INSERT INTO usuario_programa_lista VALUES (4, 11, 7, 'O inicio foi muito bom');

-- criar noticias e suas relacoes
INSERT INTO noticia VALUES (1,'Celebridade é vista no supermercado de chinelo');
INSERT INTO noticia VALUES (2,'O filme era bom, pena que foi lançado no meio da pandemia');
INSERT INTO noticia VALUES (3,'A série deixou todo mundo viciado, aí foi cancelada sem ter um final');

INSERT INTO noticia_noticia VALUES (1, 2);
INSERT INTO noticia_noticia VALUES (2, 1);
INSERT INTO noticia_noticia VALUES (2, 3);
--

INSERT INTO imagem VALUES (1,1, '/path/to/image.jpg');
INSERT INTO imagem VALUES (2,2, '/foo/bar/image.jpg');
INSERT INTO imagem VALUES (3,3, '/images/image.jpg');

INSERT INTO pessoa_imagem VALUES (1, 2, 2);
INSERT INTO pessoa_imagem VALUES (2, 3, 3);
INSERT INTO pessoa_imagem VALUES (3, 1, 1);

-- visao util: ver todos filmes lançados nos EUA
CREATE VIEW lancados_EUA
AS
  SELECT
    programa.cod,
    traducao.titulo,
    traducao.data_lanc
  FROM programa
    INNER JOIN traducao ON programa.cod = cod_programa
    INNER JOIN lugar ON lugar.cod = cod_lugar
  WHERE lugar.nome = 'EUA'
    AND programa.tipo = 'Filme';

-- GROUP BY: ver quantos programas cada usuario assistiu e qual sua media de notas 
SELECT
  usuario.nome,
  AVG(nota) AS avg_nota,
  COUNT(titulo_original) AS num_programas
FROM usuario
  INNER JOIN usuario_programa_lista ON usuario.cod = usuario_programa_lista.cod_usuario
  INNER JOIN programa ON programa.cod = usuario_programa_lista.cod_programa
GROUP BY usuario.nome;

-- GROUP BY com HAVING: selecionar programas lançados no brasil com media de avaliacao de usuarios maior que 7
SELECT
  AVG(nota) AS avg_nota,
  traducao.titulo
FROM programa
  INNER JOIN usuario_programa_lista ON programa.cod = usuario_programa_lista.cod_programa
  INNER JOIN traducao ON programa.cod = traducao.cod_programa
  INNER JOIN lugar ON lugar.cod = traducao.cod_lugar
WHERE lugar.nome = 'Brasil'
GROUP BY traducao.titulo
HAVING AVG(nota) >= 7
ORDER BY avg_nota DESC;

-- 1a usando subconsulta: ver nome de usuários que assistiram programas que não lançaram no Brasil
SELECT
  DISTINCT usuario.nome
FROM usuario
  INNER JOIN usuario_programa_lista ON usuario.cod = cod_usuario
WHERE cod_programa NOT IN (
  SELECT programa.cod
  FROM programa
    INNER JOIN traducao ON programa.cod = cod_programa
    INNER JOIN lugar ON lugar.cod = cod_lugar
  WHERE lugar.nome = 'Brasil'
);

-- 2a usando subconsulta: selecionar os diretores que não tiveram nenhum programa lançado no brasil
SELECT pessoa.nome
FROM pessoa
  INNER JOIN participa_como ON pessoa.cod = cod_pessoa
  INNER JOIN cargo ON cargo.cod = cod_cargo
WHERE cargo.nome = 'Diretor' AND pessoa.cod NOT IN (
  SELECT cod_pessoa
  FROM programa
    INNER JOIN traducao ON programa.cod = cod_programa
    INNER JOIN lugar ON lugar.cod = cod_lugar
    LEFT JOIN participa_como ON programa.cod = participa_como.cod_programa
    INNER JOIN cargo ON cargo.cod = cod_cargo
  WHERE lugar.nome = 'Brasil'
    AND cargo.nome = 'Diretor'
);

-- usando NOT EXISTS: TODO

-- 1a usando visão definida: selecionar o nome e data de lancamento de todos filmes dirigidos por kurosawa que foram lançados nos EUA
SELECT
  titulo,
  data_lanc
FROM lancados_EUA
  INNER JOIN participa_como ON lancados_EUA.cod = cod_programa
  INNER JOIN pessoa ON pessoa.cod = cod_pessoa
  INNER JOIN cargo ON cargo.cod = cod_cargo
WHERE pessoa.nome = 'Akira Kurosawa'
  AND cargo.nome = 'Diretor';

-- 2a usando visão definida: selecionar filmes que lançaram nos EUA mas não foram produzidos nos EUA
SELECT
  titulo,
  ano,
  lugar.nome AS pais_origem
FROM lancados_EUA
  INNER JOIN programa ON lancados_EUA.cod = programa.cod
  INNER JOIN lugar ON origem = lugar.cod
WHERE lugar.nome != 'EUA';

-- outras 3 consultas úteis:
-- ver programas avaliados pelo usuario 'Crítico do Oscar'
SELECT
  ano,
  titulo_original,
  nota,
  texto
FROM programa
  INNER JOIN usuario_programa_lista ON cod_programa = programa.cod
  INNER JOIN usuario ON usuario.cod = cod_usuario
WHERE usuario.nome = 'Crítico do Oscar';

-- ver usuarios que assistiram apenas series e quais series ele assistiu
SELECT
  nome,
  titulo_original
FROM usuario
  INNER JOIN usuario_programa_lista ON usuario.cod = cod_usuario
  INNER JOIN programa ON programa.cod = cod_programa
WHERE usuario.cod NOT IN (
  SELECT usuario.cod
  FROM usuario
    INNER JOIN usuario_programa_lista ON usuario.cod = cod_usuario
    INNER JOIN programa ON programa.cod = cod_programa
  WHERE programa.tipo != 'Série');
  -- ver usuarios que assistiram apenas series e quais series ele assistiu apagar d em dtipo

-- ver programas de drama que não são de ação
SELECT
  tipo,
  ano,
  titulo_original
FROM programa
  INNER JOIN programa_tag ON programa.cod = cod_programa
  INNER JOIN tag ON cod_tag = tag.cod
WHERE tag.nome = 'Drama'
  AND programa.cod NOT IN (
    SELECT programa.cod
    FROM programa
      INNER JOIN programa_tag ON programa.cod = cod_programa
      INNER JOIN tag ON cod_tag = tag.cod
    WHERE tag.nome = 'Ação');



DROP TABLE USUARIO_PROGRAMA_LISTA;
DROP TABLE PROGRAMA_TAG;
DROP TABLE PARTICIPA_COMO;
DROP TABLE PESSOA_IMAGEM;
DROP TABLE PESSOA_PROGRAMA;
DROP TABLE IMAGEM;
DROP TABLE TRADUCAO;
DROP TABLE PROGRAMA;
DROP TABLE NOTICIA_NOTICIA;
DROP TABLE NOTICIA;
DROP TABLE PESSOA;
DROP TABLE CARGO;
DROP TABLE USUARIO;
DROP TABLE TAG;
DROP TABLE LUGAR;


