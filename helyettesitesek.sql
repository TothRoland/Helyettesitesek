-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2024. Feb 05. 17:34
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `helyettesitesek`
--
CREATE DATABASE IF NOT EXISTS `helyettesitesek` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `helyettesitesek`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `id` int(5) NOT NULL,
  `felhasznalonev` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jelszo` varchar(60) NOT NULL,
  `osztalyId` int(11) NOT NULL,
  `tanarId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `helyettesites`
--

CREATE TABLE `helyettesites` (
  `ora` int(11) NOT NULL,
  `osztalyId` int(11) NOT NULL,
  `tanarId1` int(11) NOT NULL,
  `tanarId2` int(11) NOT NULL,
  `tantargy1` varchar(30) NOT NULL,
  `tantargy2` varchar(30) NOT NULL,
  `terem1` varchar(5) NOT NULL,
  `terem2` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `osztalyok`
--

CREATE TABLE `osztalyok` (
  `id` int(11) NOT NULL,
  `osztalynev` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `osztalyok`
--

INSERT INTO `osztalyok` (`id`, `osztalynev`) VALUES
(1, '9.A'),
(2, '9.B'),
(3, '9.C'),
(4, '9.D'),
(5, '9.E'),
(6, '9.G'),
(7, '9.Ny'),
(8, '10.A'),
(9, '10.B'),
(10, '10.C'),
(11, '10.D'),
(12, '10.E'),
(13, '10.G'),
(14, '11.A'),
(15, '11.B'),
(16, '11.C'),
(17, '11.D'),
(18, '11.E'),
(19, '11.F'),
(20, '11.G'),
(21, '12.A'),
(22, '12.B'),
(23, '12.C'),
(24, '12.D'),
(25, '12.E'),
(26, '12.F'),
(27, '12.G'),
(28, '13.A'),
(29, '13.B'),
(30, '13.C'),
(31, '13.D'),
(32, '13.E'),
(33, '13.G');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tanarok`
--

CREATE TABLE `tanarok` (
  `id` int(11) NOT NULL,
  `tanarnev` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `tanarok`
--

INSERT INTO `tanarok` (`id`, `tanarnev`) VALUES
(1, 'Irányi László'),
(2, 'Grezsu Csaba'),
(3, 'Podmaniczki Anna'),
(4, 'Kobán László'),
(5, 'Sárdi Ildikó'),
(6, 'Arany Ferenc'),
(7, 'Asztalos István'),
(8, 'Ács Krisztina'),
(9, 'Babos György'),
(10, 'Baranyai József'),
(11, 'Bácskay-Kiss Judit'),
(12, 'Bagosiné Siska Vera'),
(13, 'Barbainé Bérci Klára'),
(14, 'Bata Veronika'),
(15, 'Bede Mónika'),
(16, 'Biszkótné Csiszár Gyöngyi'),
(17, 'Berzsenyi Mónika'),
(18, 'Bocskay Csabáné'),
(19, 'Bocskay Lívia'),
(20, 'Bodó Alexandra'),
(21, 'Buzás Bálint'),
(22, 'Cseh Balázs'),
(23, 'Csikós Balázs'),
(24, 'Deák Csaba'),
(25, 'Domján László'),
(26, 'Domonkos Milán'),
(27, 'Dudás Erika'),
(28, 'Engel-Angyal Zsolt'),
(29, 'Farkas Gábor'),
(30, 'Fazekas Eszter'),
(31, 'Fenyő Antal'),
(32, 'Ferencziné Rohonyi Judit'),
(33, 'Fodorné Szöllősi Dorottya'),
(34, 'Földesi Csaba'),
(35, 'Freili Katalin'),
(36, 'Fülöp István'),
(37, 'Gerő Ildikó'),
(38, 'Gulyás Mihály'),
(39, 'Gyurik Pál'),
(40, 'Heider Naszer'),
(41, 'Horváth Mónika'),
(42, 'Horváth Mária'),
(43, 'Kalocsai-Nagy Izabella'),
(44, 'Kertész András'),
(45, 'Kis Judit Mária'),
(46, 'Kissné Németh Enikő'),
(47, 'Kondás Ildikó'),
(48, 'Kondor Viktória'),
(49, 'Kovács László'),
(50, 'Kozák Emília'),
(51, 'Köllő Zsófi'),
(52, 'Lipp Zoltán'),
(53, 'Markó Dóra'),
(54, 'Mártony Zsuzsanna'),
(55, 'Medve Krisztina'),
(56, 'Merencsics Tiborné Rigó Ida'),
(57, 'Merhala Mercédesz'),
(58, 'Méri Ákos'),
(59, 'Mikolasek Norbert'),
(60, 'Molnár Balázs Dominik'),
(61, 'Molnár Csaba'),
(62, 'Nádler Balázs'),
(63, 'Nádler-Somogyi Laura'),
(64, 'Nagy Dániel'),
(65, 'Nagy Kinga'),
(66, 'Nagyné Kiss Boglárka'),
(67, 'Nyakas István'),
(68, 'Orgoványi Csaba'),
(69, 'Pap Tünde'),
(70, 'Pribelszki Judit'),
(71, 'Pulai Gáborné'),
(72, 'Sas Tibor'),
(73, 'Simon Emőke'),
(74, 'Simon Katalin'),
(75, 'Simonyi Antónia'),
(76, 'Somogyi Zsuzsanna'),
(77, 'Somogyvári Lajos'),
(78, 'SteinMacher Dóra'),
(79, 'Szabad Ferenc'),
(80, 'Szabó-Bachstädt Ildikó'),
(81, 'Szabó Szilárd'),
(82, 'Szathmáry Edina'),
(83, 'Szekeres Péter'),
(84, 'Széplábi Ferenc'),
(85, 'Szentmiklóssy Éva'),
(86, 'Szigetiné Kerekes Boglárka'),
(87, 'Tamás Andrea'),
(88, 'Tanai Tamás'),
(89, 'Tekes István'),
(90, 'Terray Csilla'),
(91, 'Torma Eszter'),
(92, 'Dr. Tóth Noémi'),
(93, 'Traier Bálint'),
(94, 'Turi Zsuzsanna'),
(95, 'Vajda Szilvia'),
(96, 'Vargáné Wolf Andrea'),
(97, 'Várnai László'),
(98, 'Várnainé Dvorán Krisztina'),
(99, 'Várszegi János'),
(100, 'Veres Enikő Éva'),
(101, 'Vass Bence'),
(102, 'Vojcskóné Juhász Sarolta'),
(103, 'Wéninger Zoárd');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `osztalyId` (`osztalyId`),
  ADD KEY `tanarId` (`tanarId`);

--
-- A tábla indexei `helyettesites`
--
ALTER TABLE `helyettesites`
  ADD KEY `osztalyId` (`osztalyId`),
  ADD KEY `tanarId1` (`tanarId1`),
  ADD KEY `tanarId2` (`tanarId2`);

--
-- A tábla indexei `osztalyok`
--
ALTER TABLE `osztalyok`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `tanarok`
--
ALTER TABLE `tanarok`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `osztalyok`
--
ALTER TABLE `osztalyok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT a táblához `tanarok`
--
ALTER TABLE `tanarok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD CONSTRAINT `felhasznalok_ibfk_1` FOREIGN KEY (`osztalyId`) REFERENCES `osztalyok` (`id`),
  ADD CONSTRAINT `felhasznalok_ibfk_2` FOREIGN KEY (`tanarId`) REFERENCES `tanarok` (`id`);

--
-- Megkötések a táblához `helyettesites`
--
ALTER TABLE `helyettesites`
  ADD CONSTRAINT `helyettesites_ibfk_1` FOREIGN KEY (`osztalyId`) REFERENCES `osztalyok` (`id`),
  ADD CONSTRAINT `helyettesites_ibfk_2` FOREIGN KEY (`tanarId1`) REFERENCES `tanarok` (`id`),
  ADD CONSTRAINT `helyettesites_ibfk_3` FOREIGN KEY (`tanarId2`) REFERENCES `tanarok` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
