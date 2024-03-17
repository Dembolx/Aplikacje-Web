-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2024 at 04:12 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inter-wiedza`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `absolwenci`
--

CREATE TABLE `absolwenci` (
  `id` int(11) NOT NULL,
  `imie` varchar(20) DEFAULT NULL,
  `nazwisko` varchar(40) DEFAULT NULL,
  `ojciec` varchar(20) DEFAULT NULL,
  `data_uro` date DEFAULT NULL,
  `gdzie` varchar(40) DEFAULT NULL,
  `pesel` int(11) DEFAULT NULL,
  `adres` text DEFAULT NULL,
  `numer_k` varchar(9) DEFAULT NULL,
  `kurs` text DEFAULT NULL,
  `rozszerzenie` text DEFAULT NULL,
  `rok` int(11) DEFAULT NULL,
  `oddział` text DEFAULT NULL,
  `rozpoczęcie` date DEFAULT NULL,
  `zakończenie` date DEFAULT NULL,
  `egzamin` date DEFAULT NULL,
  `protokół` text DEFAULT NULL,
  `numer_zaś` int(11) DEFAULT NULL,
  `e_mail` text DEFAULT NULL,
  `index_` text DEFAULT NULL,
  `telefon` int(11) DEFAULT NULL,
  `skierowanie` text DEFAULT NULL,
  `uwagi` text DEFAULT NULL,
  `powiat` varchar(30) DEFAULT NULL,
  `index_kursu` varchar(20) DEFAULT NULL,
  `id_usera` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `nazwa_uzytkownika` varchar(50) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `uprawnienia` set('INSERT','SELECT','UPDATE','DELETE') NOT NULL,
  `stanowisko` varchar(60) DEFAULT NULL,
  `nazwisko` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `absolwenci`
--
ALTER TABLE `absolwenci`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absolwenci`
--
ALTER TABLE `absolwenci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
