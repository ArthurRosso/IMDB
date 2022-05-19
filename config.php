<?php

// Error handling
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Attempt to connect to PostgreSQL database */
$host = "127.0.0.1";
$port = "5432";
$dbname = "imdb";
$user = "arthur";
$passwd = "";
$con_string = "host=$host port=$port dbname=$dbname user=$user password=$passwd sslmode=require";
$link = pg_connect($con_string);
 
// Check connection
if($link === false){
    echo ("Could not connect");
}

// Aqui são criadas todas as tabelas
$create_lugar = "CREATE TABLE IF NOT EXISTS LUGAR (
                    COD SERIAL,
                    NOME VARCHAR(50),
                    PRIMARY KEY(COD)
                );";
pg_query($link, $create_lugar);
$sql = "SELECT * FROM LUGAR";
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result);
if ($linhas <= 0) {
    $sql = "INSERT INTO LUGAR VALUES (1, 'Brasil');";
    pg_query($link, $sql);
    $sql = "INSERT INTO LUGAR VALUES (2, 'Alemanha');";
    pg_query($link, $sql);
    $sql = "INSERT INTO LUGAR VALUES (3, 'França');";
    pg_query($link, $sql);
    $sql = "INSERT INTO LUGAR VALUES (4, 'Japão');";
    pg_query($link, $sql);
    $sql = "INSERT INTO LUGAR VALUES (5, 'EUA');";
    pg_query($link, $sql);
    $sql = "INSERT INTO LUGAR VALUES (6, 'Coreia do Sul');";
    pg_query($link, $sql);
    $sql = "INSERT INTO LUGAR VALUES (7, 'Portugal');";
    pg_query($link, $sql);
}

$create_prog = "CREATE TABLE IF NOT EXISTS PROGRAMA (
                    cod SERIAL,
                    tipo VARCHAR (8),
                    origem INTEGER REFERENCES lugar,
                    ano INTEGER,
                    titulo_original VARCHAR(50),
                    sinopse VARCHAR(512),
                    CHECK (tipo IN ('Série', 'Filme', 'Episódio')),
                    PRIMARY KEY(cod)
                );";
pg_query($link, $create_prog);
$sql = "SELECT * FROM PROGRAMA";
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result);
if ($linhas <= 0) {
    $sql = "INSERT INTO programa VALUES (1, 'Filme', 4, 2021, 'Doraibu Mai Kaa', 'A renowned stage actor and director learns to cope with his wifes unexpected passing when he receives an offer to direct a production of Uncle Vanya in Hiroshima.');";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa VALUES (2, 'Filme', 6, 2019, 'Gisaengchung', 'Greed and class discrimination threaten the newly formed symbiotic relationship between the wealthy Park family and the destitute Kim clan.');";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa VALUES (3, 'Série', 5, 2008, 'Breaking Bad', 'A high school chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine in order to secure his familys future.');";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa VALUES (4, 'Filme', 4, 1954, 'Shichinin no samurai', 'A poor village under attack by bandits recruits seven unemployed samurai to help them defend themselves.');";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa VALUES (5, 'Filme', 4, 1961, 'Yoojinboo', 'A crafty ronin comes to a town divided by two criminal gangs and decides to play them against each other to free the town.');";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa VALUES (6, 'Filme', 4, 1985, 'Ran', 'In Medieval Japan, an elderly warlord retires, handing over his empire to his three sons. However, he vastly underestimates how the new-found power will corrupt them and cause them to turn on each other...and him.');";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa VALUES (7, 'Filme', 5, 2022, 'Sonic the Hedgehog 2', 'When the manic Dr Robotnik returns to Earth with a new ally, Knuckles the Echidna, Sonic and his new friend Tails is all that stands in their way.');";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa VALUES (8, 'Filme', 5, 2022, 'Doctor Strange in the Multiverse of Madness', 'Dr. Stephen Strange casts a forbidden spell that opens the doorway to the multiverse, including alternate versions of himself, whose threat to humanity is too great for the combined forces of Strange, Wong, and Wanda Maximoff.');";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa VALUES (9, 'Filme', 5, 2022, 'Avatar: The Way of Water', 'Jake Sully lives with his newfound family formed on the planet of Pandora. Once a familiar threat returns to finish what was previously started, Jake must work with Neytiri and the army of the Navi race to protect their planet.');";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa VALUES (10, 'Série', 5, 2004, 'Lost', 'The survivors of a plane crash are forced to work together in order to survive on a seemingly deserted tropical island.');";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa VALUES (11, 'Série', 5, 2011, 'Game of Thrones', 'Nine noble families fight for control over the lands of Westeros, while an ancient enemy returns after being dormant for millennia.');";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa VALUES (12, 'Episódio', 5, 2004, 'Lost S1E1 - Pilot (Part 1)', 'The survivors of a plane crash are forced to work together in order to survive on a seemingly deserted tropical island.');";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa VALUES (13, 'Episódio', 5, 2004, 'Lost S1E2 - Pilot (Part 2)', 'The survivors of a plane crash are forced to work together in order to survive on a seemingly deserted tropical island.');";
    pg_query($link, $sql);
    $sql = "INSERT INTO PROGRAMA VALUES (14, 'Filme', 4, 2003, 'Sen to Chihiro no Kamikakushi', 'During her family's move to the suburbs, a sullen 10-year-old girl wanders into a world ruled by gods, witches, and spirits, and where humans are changed into beasts.');";
    pg_query($link, $sql);
    $sql = "INSERT INTO PROGRAMA VALUES (15, 'Filme', 5, 2010, 'Inception', 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O., but his tragic past may doom the project and his team to disaster.');";
    pg_query($link, $sql);
    $sql = "INSERT INTO PROGRAMA VALUES (16, 'Filme', 5, 1999, 'Star Wars I - The Phantom Menace', 'Two Jedi escape a hostile blockade to find allies and come across a young boy who may bring balance to the Force, but the long dormant Sith resurface to claim their original glory.');";
    pg_query($link, $sql);
    $sql = "INSERT INTO PROGRAMA VALUES (17, 'Filme', 5, 2006, 'Cars', 'A hot-shot race-car named Lightning McQueen gets waylaid in Radiator Springs, where he finds the true meaning of friendship and family.');";
}

$create_trad = "CREATE TABLE IF NOT EXISTS TRADUCAO (
                    COD SERIAL,
                    COD_PROGRAMA INTEGER,
                    COD_LUGAR INTEGER,
                    DATA_LANC DATE,
                    TITULO VARCHAR(50),
                    PRIMARY KEY(COD, COD_PROGRAMA),
                    FOREIGN KEY(COD_PROGRAMA) REFERENCES PROGRAMA,
                    FOREIGN KEY(COD_LUGAR) REFERENCES LUGAR
                );";
pg_query($link, $create_trad);
$sql = "SELECT * FROM TRADUCAO";
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result);
if ($linhas <= 0) {
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (1, 1, 4, '2021-08-20', 'Doraibu Mai Kaa');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (2, 1, 5, '2021-10-03', 'Drive My Car');";
    pg_query($link, $sql);  
    $sql = "INSERT INTO traducao VALUES (3, 2, 5, '2019-05-21', 'Parasite');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (4, 2, 6, '2019-05-21', 'Gisaengchung');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (5, 2, 1, '2019-11-07', 'Parasita');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (6, 2, 7, '2019-09-26', 'Parasitas');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (7, 3, 5, '2008-01-20', 'Breaking Bad');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (8, 4, 5, '1956-11-19', 'Seven Samurai');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (9, 4, 1, '1956-11-19', 'Os Sete Samurais');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (10, 5, 5, '1961-09-13', 'Yojimbo');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (11, 7, 1, '2022-04-07', 'Sonic 2 - O Filme');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (12, 7, 5, '2022-04-07', 'Sonic the Hedgehog 2');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (13, 8, 1, '2022-05-05', 'Doutor Estranho no Multiverso da Loucura');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (14, 8, 5, '2022-05-05', 'Doctor Strange in the Multiverse of Madness');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (15, 9, 1, '2022-12-15', 'Avatar: O Caminho da Água');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (16, 9, 5, '2022-12-15', 'Avatar: The Way of Water');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (17, 10, 5, '2004-09-22', 'Lost');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (18, 11, 5, '2011-04-17', 'Game of Thrones');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (19, 11, 1, '2011-04-17', 'A Guerra dos Tronos');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (20, 12, 5, '2004-09-22', 'Lost S1E1 - Pilot (Part 1)');";
    pg_query($link, $sql);
    $sql = "INSERT INTO traducao VALUES (21, 13, 5, '2004-09-29', 'Lost S1E2 - Pilot (Part 2)');";
    pg_query($link, $sql);
    $sql = "INSERT INTO TRADUCAO VALUES (22, 14, 1, '2003-07-18', 'A Viagem de Chihiro');";
    pg_query($link, $sql);
    $sql = "INSERT INTO TRADUCAO VALUES (23, 15, 1, '2010-08-06', 'A Origem');";
    pg_query($link, $sql);
    $sql = "INSERT INTO TRADUCAO VALUES (24, 16, 1, '1999-06-24', 'Star Wars I - A Ameaça Fantasma');";
    pg_query($link, $sql);
    $sql = "INSERT INTO TRADUCAO VALUES (25, 17, 1, '2006-06-30', 'Carros');";
}

$create_tag = "CREATE TABLE IF NOT EXISTS TAG (
                    COD SERIAL,
                    NOME VARCHAR (50),
                    PRIMARY KEY(COD)
                );";
pg_query($link, $create_tag);
$sql = "SELECT * FROM TAG";
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result);
if ($linhas <= 0) {
    $sql = "INSERT INTO TAG VALUES (1,'Drama');";
    pg_query($link, $sql);
    $sql = "INSERT INTO TAG VALUES (2,'Ação');";
    pg_query($link, $sql);
    $sql = "INSERT INTO TAG VALUES (3,'Terror');";
    pg_query($link, $sql);
    $sql = "INSERT INTO TAG VALUES (4,'Comédia');";
    pg_query($link, $sql);
    $sql = "INSERT INTO TAG VALUES (5,'Suspense');";
    pg_query($link, $sql);
    $sql = "INSERT INTO TAG VALUES (6,'Crime');";
    pg_query($link, $sql);
    $sql = "INSERT INTO TAG VALUES (7,'Guerra');";
    pg_query($link, $sql);
    $sql = "INSERT INTO TAG VALUES (8,'Aventura');";
    pg_query($link, $sql);
    $sql = "INSERT INTO TAG VALUES (9,'Sci-Fi');";
    pg_query($link, $sql);
    $sql = "INSERT INTO TAG VALUES (10,'Animação');";
    pg_query($link, $sql);
}

$create_user = "CREATE TABLE IF NOT EXISTS USUARIO (
                    COD SERIAL,
                    SENHA VARCHAR (64),
                    NOME VARCHAR (50),
                    EMAIL VARCHAR (50),
                    PRIMARY KEY(COD)
                );";
pg_query($link, $create_user);
$sql = "SELECT * FROM USUARIO";
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result);
if ($linhas <= 0) {
    $sql = "INSERT INTO usuario VALUES (1, 'pa$$word', 'User drop table', 'user@tabledropping.com');";
    pg_query($link, $sql);
    $sql = "INSERT INTO usuario VALUES (2, 'joaozinho123', 'João da review do youtube', 'joaao@gmail.com');";
    pg_query($link, $sql);
    $sql = "INSERT INTO usuario VALUES (3, '0934tuietg894h34343j4ju', 'Crítico do Oscar', 'criticas@oscar.com');";
    pg_query($link, $sql);
    $sql = "INSERT INTO usuario VALUES (4, 'senha123', 'sovejoseries', 'sovejoseries@hotmail.com');";
    pg_query($link, $sql);
}


$create_cargo = "CREATE TABLE IF NOT EXISTS CARGO (
                    COD SERIAL,
                    NOME VARCHAR (50),
                    PRIMARY KEY(COD)
                );";
pg_query($link, $create_cargo);
$sql = "SELECT * FROM CARGO";
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result);
if ($linhas <= 0) {
    $sql = "INSERT INTO CARGO VALUES (1,'Ator');";
    pg_query($link, $sql);
    $sql = "INSERT INTO CARGO VALUES (2,'Diretor');";
    pg_query($link, $sql);
    $sql = "INSERT INTO CARGO VALUES (3,'Escritor');";
    pg_query($link, $sql);
    $sql = "INSERT INTO CARGO VALUES (4,'Roteirista');";
    pg_query($link, $sql);
    $sql = "INSERT INTO CARGO VALUES (5,'Atriz');";
    pg_query($link, $sql);
}

$create_pes = "CREATE TABLE IF NOT EXISTS PESSOA (
                    COD SERIAL,
                    NOME VARCHAR (50),
                    DATA_NASC DATE,
                    PRIMARY KEY(COD)
                );";
pg_query($link, $create_pes);
$sql = "SELECT * FROM PESSOA";
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result);
if ($linhas <= 0) {
    $sql = "INSERT INTO pessoa VALUES (1, 'Ryusuke Hamaguchi', '1978-12-16');";
    pg_query($link, $sql);
    $sql = "INSERT INTO pessoa VALUES (2, 'Hidetoshi Nishijima', '1971-03-29');";
    pg_query($link, $sql);
    $sql = "INSERT INTO pessoa VALUES (3, 'Haruki Murakami', '1949-01-12');";
    pg_query($link, $sql);
    $sql = "INSERT INTO pessoa VALUES (4, 'Bong Joon-ho', '1969-09-14');";
    pg_query($link, $sql);
    $sql = "INSERT INTO pessoa VALUES (5, 'Vince Gilligan', '1967-02-10');";
    pg_query($link, $sql);
    $sql = "INSERT INTO pessoa VALUES (6, 'Akira Kurosawa', '1910-03-23');";
    pg_query($link, $sql);
    $sql = "INSERT INTO pessoa VALUES (7, 'James Cameron', '1954-10-16');";
    pg_query($link, $sql);
    $sql = "INSERT INTO PESSOA VALUES (8,'Owen Wilson', '1968-11-18');";
    pg_query($link, $sql);
    $sql = "INSERT INTO PESSOA VALUES (9,'Leonardo DiCaprio', '1974-11-11');";
    pg_query($link, $sql);
    $sql = "INSERT INTO PESSOA VALUES (10,'Ewan McGregor', '1971-03-31');";
    pg_query($link, $sql);
    $sql = "INSERT INTO PESSOA VALUES (11,'Rumi Hiiragi', '1987-08-01');";
    pg_query($link, $sql);
}

$create_not = "CREATE TABLE IF NOT EXISTS NOTICIA (
                    COD SERIAL,
                    CONTEUDO VARCHAR (1024),
                    PRIMARY KEY(COD)
                );";
pg_query($link, $create_not);
$sql = "SELECT * FROM NOTICIA";
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result);
if ($linhas <= 0) {
    $sql = "INSERT INTO NOTICIA VALUES (1,'Celebridade é vista no supermercado de chinelo');";
    pg_query($link, $sql);
    $sql = "INSERT INTO NOTICIA VALUES (2,'O filme era bom, pena que foi lançado no meio da pandemia');";
    pg_query($link, $sql);
    $sql = "INSERT INTO NOTICIA VALUES (3,'A série deixou todo mundo viciado, aí foi cancelada sem ter um final');";
    pg_query($link, $sql);
}

$create_img = "CREATE TABLE IF NOT EXISTS IMAGEM (
                    COD SERIAL,
                    COD_PROGRAMA INTEGER,
                    CAMINHO VARCHAR (256),
                    PRIMARY KEY(COD_PROGRAMA, COD),
                    FOREIGN KEY(COD_PROGRAMA) REFERENCES PROGRAMA
                );";
pg_query($link, $create_img);
$sql = "SELECT * FROM IMAGEM";
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result);
if ($linhas <= 0) {
    $sql = "INSERT INTO IMAGEM VALUES (1, 1, '/imdb/images/1.jpeg');";
    pg_query($link, $sql);
    $sql = "INSERT INTO IMAGEM VALUES (2, 2, '/imdb/images/2.jpeg');";
    pg_query($link, $sql);
    $sql = "INSERT INTO IMAGEM VALUES (3, 3, '/imdb/images/3.jpeg');";
    pg_query($link, $sql);
    $sql = "INSERT INTO IMAGEM VALUES (4, 4, '/imdb/images/4.jpeg');";
    pg_query($link, $sql);
    $sql = "INSERT INTO IMAGEM VALUES (5, 5, '/imdb/images/5.jpeg');";
    pg_query($link, $sql);
    $sql = "INSERT INTO IMAGEM VALUES (6, 6, '/imdb/images/6.jpeg');";
    pg_query($link, $sql);
    $sql = "INSERT INTO IMAGEM VALUES (7, 7, '/imdb/images/7.jpeg');";
    pg_query($link, $sql);
    $sql = "INSERT INTO IMAGEM VALUES (8, 8, '/imdb/images/8.jpeg');";
    pg_query($link, $sql);
    $sql = "INSERT INTO IMAGEM VALUES (9, 9, '/imdb/images/9.jpeg');";
    pg_query($link, $sql);
    $sql = "INSERT INTO IMAGEM VALUES (10, 10, '/imdb/images/10.jpeg');";
    pg_query($link, $sql);
    $sql = "INSERT INTO IMAGEM VALUES (11, 11, '/imdb/images/11.jpeg');";
    pg_query($link, $sql);
    $sql = "INSERT INTO IMAGEM VALUES (12, 12, '/imdb/images/10.jpeg');";
    pg_query($link, $sql);
    $sql = "INSERT INTO IMAGEM VALUES (13, 13, '/imdb/images/10.jpeg');";
    pg_query($link, $sql);
    $sql = "INSERT INTO IMAGEM VALUES (14, 14, '/imdb/images/12.jpeg');";
    pg_query($link, $sql);
    $sql = "INSERT INTO IMAGEM VALUES (15, 15, '/imdb/images/13.jpeg');";
    pg_query($link, $sql);
    $sql = "INSERT INTO IMAGEM VALUES (16, 16, '/imdb/images/14.jpeg');";
    pg_query($link, $sql);
    $sql = "INSERT INTO IMAGEM VALUES (17, 17, '/imdb/images/15.jpeg');";
    pg_query($link, $sql);
}

$create_pp = "CREATE TABLE IF NOT EXISTS PESSOA_PROGRAMA(
                    COD_PROGRAMA INTEGER,
                    COD_PESSOA INTEGER,
                    PRIMARY KEY (COD_PESSOA, COD_PROGRAMA),
                    FOREIGN KEY(COD_PROGRAMA) REFERENCES PROGRAMA,
                    FOREIGN KEY(COD_PESSOA) REFERENCES PESSOA
                );";
pg_query($link, $create_pp);
$sql = "SELECT * FROM PESSOA_PROGRAMA";
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result);
if ($linhas <= 0) {
    $sql = "INSERT INTO pessoa_programa VALUES (1, 1);";
    pg_query($link, $sql);
    $sql = "INSERT INTO pessoa_programa VALUES (2, 1);";
    pg_query($link, $sql);
    $sql = "INSERT INTO pessoa_programa VALUES (3, 1);";
    pg_query($link, $sql);
    $sql = "INSERT INTO pessoa_programa VALUES (4, 2);";
    pg_query($link, $sql);
    $sql = "INSERT INTO pessoa_programa VALUES (5, 3);";
    pg_query($link, $sql);
    $sql = "INSERT INTO pessoa_programa VALUES (6, 4);";
    pg_query($link, $sql);
    $sql = "INSERT INTO pessoa_programa VALUES (6, 5);";
    pg_query($link, $sql);
    $sql = "INSERT INTO pessoa_programa VALUES (6, 6);";
    pg_query($link, $sql);
}

$create_pi = "CREATE TABLE IF NOT EXISTS PESSOA_IMAGEM (
                    COD_PESSOA INTEGER,
                    COD_PROGRAMA INTEGER,
                    COD_IMAGEM INTEGER,
                    PRIMARY KEY(COD_PESSOA, COD_PROGRAMA, COD_IMAGEM),
                    FOREIGN KEY(COD_PESSOA) REFERENCES PESSOA,
                    FOREIGN KEY( COD_PROGRAMA, COD_IMAGEM) REFERENCES IMAGEM
                );";
pg_query($link, $create_pi);
$sql = "SELECT * FROM PESSOA_IMAGEM";
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result);
if ($linhas <= 0) {
    // $sql = "INSERT INTO PESSOA_IMAGEM VALUES (1, 4, 4);";
    // pg_query($link, $sql);
    // $sql = "INSERT INTO PESSOA_IMAGEM VALUES (2, 2, 2);";
    // pg_query($link, $sql);
    // $sql = "INSERT INTO PESSOA_IMAGEM VALUES (3, 3, 3);";
    // pg_query($link, $sql);
    // $sql = "INSERT INTO PESSOA_IMAGEM VALUES (4, 1, 1);";
    // pg_query($link, $sql);
}

$create_como = "CREATE TABLE IF NOT EXISTS PARTICIPA_COMO(
                    COD_PESSOA INTEGER, 
                    COD_CARGO INTEGER,
                    COD_PROGRAMA INTEGER, 
                    PRIMARY KEY(COD_PROGRAMA, COD_PESSOA, COD_CARGO),
                    FOREIGN KEY(COD_PROGRAMA) REFERENCES PROGRAMA,
                    FOREIGN KEY(COD_PESSOA) REFERENCES PESSOA,
                    FOREIGN KEY(COD_CARGO) REFERENCES CARGO
                );";
pg_query($link, $create_como);
$sql = "SELECT * FROM PARTICIPA_COMO";
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result);
if ($linhas <= 0) {
    $sql = "INSERT INTO participa_como VALUES (1, 2, 1);";
    pg_query($link, $sql);
    $sql = "INSERT INTO participa_como VALUES (2, 1, 1);";
    pg_query($link, $sql);
    $sql = "INSERT INTO participa_como VALUES (3, 4, 1);";
    pg_query($link, $sql);
    $sql = "INSERT INTO participa_como VALUES (4, 2, 2);";
    pg_query($link, $sql);
    $sql = "INSERT INTO participa_como VALUES (5, 2, 3);";
    pg_query($link, $sql);
    $sql = "INSERT INTO participa_como VALUES (6, 2, 4);";
    pg_query($link, $sql);
    $sql = "INSERT INTO participa_como VALUES (6, 3, 4);";
    pg_query($link, $sql);
    $sql = "INSERT INTO participa_como VALUES (6, 2, 5);";
    pg_query($link, $sql);
    $sql = "INSERT INTO participa_como VALUES (6, 2, 6);";
    pg_query($link, $sql);
    $sql = "INSERT INTO participa_como VALUES (6, 3, 6);";
    pg_query($link, $sql);
    $sql = "INSERT INTO participa_como VALUES (7, 2, 9);";
    pg_query($link, $sql);
    $sql = "INSERT INTO PARTICIPA_COMO VALUES (8, 1, 17);";
    pg_query($link, $sql);
    $sql = "INSERT INTO PARTICIPA_COMO VALUES (9, 1, 15);";
    pg_query($link, $sql);
    $sql = "INSERT INTO PARTICIPA_COMO VALUES (10, 1, 16);";
    pg_query($link, $sql);
    $sql = "INSERT INTO PARTICIPA_COMO VALUES (11, 5, 14);";
    pg_query($link, $sql);
}

$create_pt = "CREATE TABLE IF NOT EXISTS PROGRAMA_TAG(
                    COD_PROGRAMA INTEGER,
                    COD_TAG INTEGER,
                    PRIMARY KEY(COD_PROGRAMA, COD_TAG),
                    FOREIGN KEY(COD_TAG) REFERENCES TAG,
                    FOREIGN KEY(COD_PROGRAMA) REFERENCES PROGRAMA
                );";
pg_query($link, $create_pt);
$sql = "SELECT * FROM PROGRAMA_TAG";
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result);
if ($linhas <= 0) {
    $sql = "INSERT INTO programa_tag VALUES (1, 1);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (2, 1);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (2, 4);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (2, 5);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (3, 6);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (3, 1);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (3, 5);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (4, 2);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (4, 1);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (5, 2);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (5, 1);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (5, 5);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (6, 2);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (6, 1);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (6, 7);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (7, 2);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (7, 8);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (7, 4);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (8, 2);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (8, 8);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (8, 9);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (9, 2);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (9, 8);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (9, 10);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (10, 8);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (10, 1);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (10, 9);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (11, 2);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (11, 8);";
    pg_query($link, $sql);
    $sql = "INSERT INTO programa_tag VALUES (11, 1);";
    pg_query($link, $sql);
    $sql = "INSERT INTO PROGRAMA_TAG VALUES (14, 2);";
    pg_query($link, $sql);
    $sql = "INSERT INTO PROGRAMA_TAG VALUES (14, 10);";
    pg_query($link, $sql);
    $sql = "INSERT INTO PROGRAMA_TAG VALUES (15, 1);";
    pg_query($link, $sql);
    $sql = "INSERT INTO PROGRAMA_TAG VALUES (15, 2);";
    pg_query($link, $sql);
    $sql = "INSERT INTO PROGRAMA_TAG VALUES (16, 9);";
    pg_query($link, $sql);
    $sql = "INSERT INTO PROGRAMA_TAG VALUES (17, 10);";
    pg_query($link, $sql);
}

$create_list = "CREATE TABLE IF NOT EXISTS USUARIO_PROGRAMA_LISTA(
                    COD_USUARIO INTEGER,
                    COD_PROGRAMA INTEGER,
                    NOTA SMALLINT,
                    CHECK (NOTA>=0 AND NOTA<=10),
                    TEXTO VARCHAR(512),
                    PRIMARY KEY(COD_PROGRAMA, COD_USUARIO),
                    FOREIGN KEY(COD_USUARIO) REFERENCES USUARIO,
                    FOREIGN KEY(COD_PROGRAMA) REFERENCES PROGRAMA
                );";
pg_query($link, $create_list);
$sql = "SELECT * FROM USUARIO_PROGRAMA_LISTA";
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result);
if ($linhas <= 0) {
    $sql = "INSERT INTO usuario_programa_lista VALUES (1, 1, 10, 'Muito bom');";
    pg_query($link, $sql);
    $sql = "INSERT INTO usuario_programa_lista VALUES (1, 3, 8, 'Bom');";
    pg_query($link, $sql);
    $sql = "INSERT INTO usuario_programa_lista VALUES (1, 7, 3, 'Não gostei');";
    pg_query($link, $sql);
    $sql = "INSERT INTO usuario_programa_lista VALUES (2, 1, 7, 'Bom');";
    pg_query($link, $sql);
    $sql = "INSERT INTO usuario_programa_lista VALUES (2, 2, 6, 'OK');";
    pg_query($link, $sql);
    $sql = "INSERT INTO usuario_programa_lista VALUES (2, 4, 9, 'Um clássico');";
    pg_query($link, $sql);
    $sql = "INSERT INTO usuario_programa_lista VALUES (2, 5, 8, 'Muito bom');";
    pg_query($link, $sql);
    $sql = "INSERT INTO usuario_programa_lista VALUES (2, 9, 10, 'Ainda nem vi');";
    pg_query($link, $sql);
    $sql = "INSERT INTO usuario_programa_lista VALUES (3, 7, 5, 'Ruim');";
    pg_query($link, $sql);
    $sql = "INSERT INTO usuario_programa_lista VALUES (3, 8, 4, 'Muito ruim');";
    pg_query($link, $sql);
    $sql = "INSERT INTO usuario_programa_lista VALUES (3, 9, 9, 'Muito bom');";
    pg_query($link, $sql);
    $sql = "INSERT INTO usuario_programa_lista VALUES (4, 3, 10, 'Gostei bastante');";
    pg_query($link, $sql);
    $sql = "INSERT INTO usuario_programa_lista VALUES (4, 10, 4, 'O final foi ruim');";
    pg_query($link, $sql);
    $sql = "INSERT INTO usuario_programa_lista VALUES (4, 11, 7, 'O inicio foi muito bom');";
    pg_query($link, $sql);
}

$create_nn = "CREATE TABLE IF NOT EXISTS NOTICIA_NOTICIA(
                    COD_NOTICIA_SRC INTEGER,
                    COD_NOTICIA_TGT INTEGER,
                    PRIMARY KEY(COD_NOTICIA_SRC, COD_NOTICIA_TGT),
                    FOREIGN KEY(COD_NOTICIA_SRC) REFERENCES NOTICIA,
                    FOREIGN KEY(COD_NOTICIA_TGT) REFERENCES NOTICIA
                );";
pg_query($link, $create_nn);
$sql = "SELECT * FROM NOTICIA_NOTICIA";
$result = pg_query($link, $sql) or die(pg_last_error($link));
$linhas = pg_num_rows($result);
if ($linhas <= 0) {
    $sql = "INSERT INTO NOTICIA_NOTICIA VALUES (1, 2);";
    pg_query($link, $sql);
    $sql = "INSERT INTO NOTICIA_NOTICIA VALUES (2, 1);";
    pg_query($link, $sql);
    $sql = "INSERT INTO NOTICIA_NOTICIA VALUES (2, 3);";
    pg_query($link, $sql);
}

?>