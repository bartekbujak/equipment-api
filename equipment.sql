-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas generowania: 26 Sie 2018, 22:01
-- Wersja serwera: 5.7.22-0ubuntu0.16.04.1
-- Wersja PHP: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `equipment`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `machines`
--

CREATE TABLE `machines` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `day` varchar(3) NOT NULL,
  `hours` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `machines`
--

INSERT INTO `machines` (`id`, `name`, `day`, `hours`) VALUES
(1, 'Machine 1', 'Tue', '12:00-13:00'),
(2, 'Machine 2', 'Wed', '06:00-14:00'),
(3, 'Machine 3', 'Tue', '09:00-11:00'),
(4, 'Machine 1', 'Thu', '06:00-10:00'),
(5, 'Machine 4', 'Thu', '09:45-12:00'),
(15, 'Machine 5', 'Tue', '03:21-07:30'),
(16, 'Machine 51', 'Tue', '03:21-07:30');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `machines`
--
ALTER TABLE `machines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
