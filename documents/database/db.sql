-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 03 mrt 2022 om 11:20
-- Serverversie: 10.4.22-MariaDB
-- PHP-versie: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `naam` text NOT NULL,
  `omschrijving` text NOT NULL,
  `prijs` decimal(10,0) NOT NULL,
  `eenheid` text NOT NULL,
  `verpakking` int(50) NOT NULL,
  `calorieën (KCAL)` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `artikel`
--

INSERT INTO `artikel` (`id`, `naam`, `omschrijving`, `prijs`, `eenheid`, `verpakking`, `calorieën (KCAL)`) VALUES
(2, 'Hamburger', 'Hamburger van rundvlees', '350', 'stuks', 2, 500),
(3, 'gehaktballen', 'gehaktballen', '400', 'stuks', 12, 450),
(4, 'tomatensaus', 'kruidige tomatensaus', '325', 'ml', 300, 150),
(5, 'cheddar', 'cheddar kaas', '275', 'stuks', 10, 80),
(6, 'sla', 'zakje gesneden ijsbergsla', '100', 'gram', 100, 5),
(7, 'cashewnoten', 'zakje cashewnoten', '375', 'gram', 200, 140),
(8, 'broccolirijst', 'pak broccolirijst', '300', 'gram', 400, 25),
(9, 'groentecurry', 'boemboe rode curry', '250', 'gram', 50, 35),
(10, 'aubergine', 'aubergine', '100', 'stuks', 1, 10),
(11, 'mosterd', 'potje mosterd grof gemalen', '120', 'ml', 200, 30);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerecht`
--

CREATE TABLE `gerecht` (
  `id` int(11) NOT NULL,
  `keuken_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datum_toegevoegd` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `titel` text NOT NULL,
  `korte_omschrijving` text NOT NULL,
  `lange_omschrijving` text NOT NULL,
  `afbeelding` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `gerecht`
--

INSERT INTO `gerecht` (`id`, `keuken_id`, `type_id`, `user_id`, `datum_toegevoegd`, `titel`, `korte_omschrijving`, `lange_omschrijving`, `afbeelding`) VALUES
(2, 1, 5, 1, '2022-02-24 08:56:13', 'Gehaktballetjes in tomatensaus.', 'Heerlijke gehaktballetjes in kruidige tomatensaus.', 'Heerlijke gehaktballetjes in kruidige tomatensaus.\r\nOnze topfavoriet en snel en makkelijk te bereiden.', 'https://static.ah.nl/static/recepten/img_RAM_PRD157982_890x594_JPG.jpg'),
(3, 2, 6, 1, '2022-02-24 08:57:26', 'Cheeseburger van de bbq', 'Goedgevulde burger van rund, cheddar en verder alle combinaties mogelijk qua sla.', 'Goedgevulde burger van rund, cheddar en verder alle combinaties mogelijk qua sla.\r\n\r\nFantastisch dat het voorjaar eraan komt en we weer buiten kunnen gaan genieten met zijn allen!', 'https://static.ah.nl/static/recepten/img_RAM_PRD147626_890x594_JPG.jpg'),
(4, 3, 7, 1, '2022-02-24 08:58:10', 'Groentecurry met broccolirijst en cashewnoten', 'Heerlijke groentecurry met broccolirijst en cashewnoten.', 'Heerlijke groentecurry met broccolirijst en cashewnoten.\r\n\r\nDoor geen gebruik te maken van \'gewone\' rijst maar van groenten, heb je te maken met een \'carbless\' maal met flinke groente-boost!', 'https://static.ah.nl/static/recepten/img_RAM_PRD142999_890x594_JPG.jpg'),
(5, 4, 8, 1, '2022-02-24 08:58:31', 'Aubergineschnitzels met mosterdsaus', 'Schnitzel gemaakt van aubergine, met mosterdsaus.', 'Schnitzel gemaakt van aubergine, met mosterdsaus. \r\n\r\nVleesarm, groenterijk!', 'https://static.ah.nl/static/recepten/img_RAM_PRD131885_1224x900_JPG.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerecht_info`
--

CREATE TABLE `gerecht_info` (
  `id` int(11) NOT NULL,
  `record_type` varchar(1) NOT NULL,
  `gerecht_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `nummeriekveld` int(11) NOT NULL,
  `tekstveld` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `gerecht_info`
--

INSERT INTO `gerecht_info` (`id`, `record_type`, `gerecht_id`, `user_id`, `datum`, `nummeriekveld`, `tekstveld`) VALUES
(2, 'B', 2, 1, '2022-02-24', 1, 'Verhit olie in de pan en bak de balletjes in 8 - 10 minuten gaar.'),
(3, 'B', 2, 1, '2022-02-24', 2, 'Voeg de tomatensaus toe en laat het geheel nog 2 minuutjes garen op laag vuur.'),
(4, 'B', 3, 1, '2022-02-24', 1, 'Bak de hamburger in 10 - 12 minuten gaar.'),
(5, 'B', 3, 1, '2022-02-24', 2, 'Plaats de gebakken hamburger op een broodje en voeg naar eigen smaak de cheddar en de sla toe.'),
(6, 'B', 4, 1, '2022-02-24', 1, 'Kook de rijst in 10 -12 minuten gaar.'),
(7, 'B', 4, 1, '2022-02-24', 2, 'Schenk het water af.'),
(8, 'B', 4, 1, '2022-02-24', 3, 'Voeg de groentecurry en de cashewnoten toe aan de rijst.'),
(9, 'B', 5, 1, '2022-02-24', 1, 'Snijd de aubergines in de lengte in plakken.'),
(10, 'B', 5, 1, '2022-02-24', 2, 'Bak de aubergineschnitzels in twee delen 5 min. rondom goudbruin. Keer halverwege.'),
(11, 'O', 2, 1, '2022-02-24', 0, 'Lekker, maar wel erg beperkt qua ingrediënten...'),
(12, 'O', 3, 1, '2022-02-24', 0, 'Heerlijk! Vlees zoals het gegeten behoort te worden; vanaf de BBQ!'),
(13, 'O', 4, 1, '2022-02-24', 0, 'Erg lekker alternatief voor gewone rijst! \r\nLekker en gezond (...op de cashews na, dan)!'),
(14, 'O', 5, 1, '2022-02-24', 0, 'Wauw, geweldig! Ik proef bijna geen verschil met gewone schnitzel en dit is zo veel beter voor het milieu!'),
(15, 'W', 2, 1, '2022-02-24', 3, ''),
(16, 'W', 3, 1, '2022-02-24', 4, ''),
(17, 'W', 4, 1, '2022-02-24', 4, ''),
(18, 'W', 5, 1, '2022-02-24', 5, ''),
(44, 'F', 2, 1, '0000-00-00', 0, ''),
(359, 'W', 2, 2, '0000-00-00', 5, ''),
(396, 'F', 5, 1, '0000-00-00', 0, '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ingredient`
--

CREATE TABLE `ingredient` (
  `id` int(11) NOT NULL,
  `gerecht_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `aantal` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `ingredient`
--

INSERT INTO `ingredient` (`id`, `gerecht_id`, `artikel_id`, `aantal`) VALUES
(1, 2, 3, 16),
(2, 2, 4, 400),
(3, 3, 2, 4),
(4, 3, 5, 4),
(5, 3, 6, 200),
(6, 4, 8, 400),
(7, 4, 7, 100),
(8, 4, 9, 100),
(9, 5, 10, 2),
(10, 5, 11, 100);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `keuken_type`
--

CREATE TABLE `keuken_type` (
  `id` int(11) NOT NULL,
  `record_type` varchar(1) NOT NULL,
  `omschrijving` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `keuken_type`
--

INSERT INTO `keuken_type` (`id`, `record_type`, `omschrijving`) VALUES
(1, 'K', 'Hollandse keuken'),
(2, 'K', 'Amerikaanse keuken'),
(3, 'K', 'Oosterse keuken'),
(4, 'K', 'Duitse keuken'),
(5, 'T', 'vlees'),
(6, 'T', 'vlees'),
(7, 'T', 'Vega'),
(8, 'T', 'Vega');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `afbeelding` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `user_name`, `password`, `email`, `afbeelding`) VALUES
(1, 'vabu84', 'password', 'valbuise@hotmail.com', ''),
(2, 'fs', 'password2', 'fs@inet.nl', '');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `gerecht`
--
ALTER TABLE `gerecht`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keuken_id` (`keuken_id`,`type_id`,`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexen voor tabel `gerecht_info`
--
ALTER TABLE `gerecht_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gerecht_id` (`gerecht_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gerecht_id` (`gerecht_id`),
  ADD KEY `artikel_id` (`artikel_id`);

--
-- Indexen voor tabel `keuken_type`
--
ALTER TABLE `keuken_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT voor een tabel `gerecht`
--
ALTER TABLE `gerecht`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `gerecht_info`
--
ALTER TABLE `gerecht_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=397;

--
-- AUTO_INCREMENT voor een tabel `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `keuken_type`
--
ALTER TABLE `keuken_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `gerecht`
--
ALTER TABLE `gerecht`
  ADD CONSTRAINT `gerecht_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `gerecht_ibfk_2` FOREIGN KEY (`keuken_id`) REFERENCES `keuken_type` (`id`),
  ADD CONSTRAINT `gerecht_ibfk_3` FOREIGN KEY (`type_id`) REFERENCES `keuken_type` (`id`);

--
-- Beperkingen voor tabel `gerecht_info`
--
ALTER TABLE `gerecht_info`
  ADD CONSTRAINT `gerecht_info_ibfk_1` FOREIGN KEY (`gerecht_id`) REFERENCES `gerecht` (`id`),
  ADD CONSTRAINT `gerecht_info_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Beperkingen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `ingredient_ibfk_1` FOREIGN KEY (`gerecht_id`) REFERENCES `gerecht` (`id`),
  ADD CONSTRAINT `ingredient_ibfk_2` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
