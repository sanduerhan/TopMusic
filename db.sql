SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(100) NOT NULL,
  `PASSWORD` varchar(150) NOT NULL,
  `ROL` enum('usuario','artisto','administrador') NOT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `genre` (
  `TITLE` varchar(100) NOT NULL,
  `ARTISTA` varchar(150) NOT NULL,
  `gen` enum('rock','rap','pop', 'reggaeton') NOT NULL,
  PRIMARY KEY(TITLE, ARTISTA)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `melodia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(100) NOT NULL,
  `ARTISTA` varchar(150) NOT NULL,
  `NR_VOTOS` int(11) NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (TITLE,ARTISTA) REFERENCES genre(TITLE, ARTISTA)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `comentario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int(11) NOT NULL,
  `ID_MELODIA` int(11) NOT NULL,
  `COMENTARIO` text NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (ID_USUARIO) REFERENCES usuario(id),
  FOREIGN KEY(ID_MELODIA) REFERENCES melodia(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuario` (`id`, `USERNAME`,`PASSWORD`, `ROL`) VALUES
(1, 'admin','$2y$10$gDHF89KV10q.2h54EjvDVuoluXhYV86U/owJFqvF.hMxy0ivNxrwi', 'administrador'),
(2, 'alexandru', '$2y$10$eCi9NI5QjcvJ3Ggi6PebRuXrMIiim/KVolULpwGVrcJl0.Gwld7TC', 'usuario'),
(3, 'Paolo', '$2y$10$1ZzxLuDDWOrWsEXdITDdeeLyt/V8K0/BisVVzjtB94quVbbE3gEV6', 'artisto');

INSERT INTO `genre` (`TITLE`,`ARTISTA`, `gen`) VALUES
('Dakiti','Bad Bunny', 'reggaeton'),
('Prisoner', 'Dua Lipa', 'pop' ),
('Deutschland', 'Rammstein', 'rock'),
('Lose Yourself', 'Eminem', 'rap'),
('Zitti e buoni', 'Maneskin', 'rock'),
('Blinding Lights', 'The Weeknd', 'pop'),
('Lost on you', 'LP', 'pop');

INSERT INTO `melodia` (`id`, `TITLE`,`ARTISTA`, `NR_VOTOS`) VALUES
(1, 'Dakiti','Bad Bunny', 2),
(2, 'Prisoner', 'Dua Lipa', 3 ),
(3, 'Deutschland', 'Rammstein', 4),
(4, 'Lose Yourself', 'Eminem', 1),
(5, 'Zitti e buoni', 'Maneskin', 2),
(6, 'Blinding Lights', 'The Weeknd', 0),
(7, 'Lost on you', 'LP', 1);



INSERT INTO `comentario` (`id`, `ID_USUARIO`,`ID_MELODIA`, `COMENTARIO`) VALUES
(1, 1, 2, 'WOW, what a song!'),
(2, 1, 5, 'Best rock song ever'),
(3, 3, 4, 'King of rap'),
(4, 3, 6, 'Love the weeknd and al of his songs'),
(5, 1, 3, 'Die besten!'),
(6, 3, 2, 'Did not expect such a bop!!');

