-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 11 Cze 2021, 10:58
-- Wersja serwera: 10.4.19-MariaDB
-- Wersja PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `bookhall`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `id` int(11) NOT NULL,
  `imie` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `nazwisko` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `haslo` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `dzial` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `czyPracuje` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `pracownicy`
--

INSERT INTO `pracownicy` (`id`, `imie`, `nazwisko`, `haslo`, `email`, `dzial`, `czyPracuje`) VALUES
(1, 'Helena', 'Bonnet', '$2y$10$FSE3ETmogne1JSt.9yjbk.mDKEMx6dtVh8gpZn2hLI3lvBF.dEkaG', 'hela@azd.pl', 'HR', 1),
(2, 'Łukasz', 'Łukaszewski', '$2y$10$JWcRR/lIxCzjStfJpFUz5.TvUyBhitFDZXOu67he5GKfHRhvK7euy', 'lukaszlukaszewski@azd.pl', 'HR', 1),
(3, 'Eliza', 'Pindor', '$2y$10$ndcI.K9rx.ld9x2p760yY.UG3sN3wuhuyyypYeixIE6pftAin07Me', 'eliza.pindor@azd.pl', 'administracja', 1),
(4, 'Natalia', 'Iwanienko', '$2y$10$6eCiZ6OQvbDe/xc3nIiCFeTtaND4dmlG.53xeaddGfA8ROhOxWPbe', 'iwanienko.natalia@azd.pl', 'realizacja inwestycji', 1),
(7, 'Paulina', 'Kwiatkowska', '$2y$10$gAAVxLRtODQ9FDvlHv7Ime6FnG/El5SngVqmDz65ffr2XqA8A3ELe', 'paulina.kwiatkowska@azd.pl', 'ksiegowosc', 1),
(8, 'Marek', 'Drzewiecki', '$2y$10$q20DelcwTbj1pKwray8vAuS/rrhy.D5fNXbeLCWBmjxWxwFdHf7pW', 'marek.drzewiecki@azd.pl', 'HR', 1),
(10, 'Maciej', 'Musiał', '$2y$10$66W8iWLVPdyiEZDacEScyOdoGMtHakPnIIDchhGp/vDx/9v3XJ6Z2', 'maciej.musial@azd.pl', 'realizacja inwestycji', 1),
(12, 'Tomasz', 'Strzelczyk', '$2y$10$b7wJUEJJAGsK7TPCw/AoCOnR9g8VDDZvPbUkj65QOHSUgSlNBM4XC', 'tomasz.strzelczyk@azd.pl', 'HR', 1),
(13, 'Alina', 'B?ckiewicz', '$2y$10$2ubbIudKOFgUXv6A01aLg.NTMHw3mAWAglV4FXWu3kKrB7cRvzMfu', 'alina.beckiewicz@azd.pl', 'administracja', 1),
(14, 'Iwona', 'Nasiadek', '$2y$10$vSCydX0mj5yLWvLlYFI03.kmc8TQs4c9Fpo8Bx8yVUAN1oI6ZbkCq', 'iwona.nasiadek@azd.pl', 'IT', 1),
(19, 'Micha?', 'Wi?ckiewicz', '$2y$10$DKTZ9knjl14D3U.KldGZZepZBEuZvmsBYGUr0LohAQtCMcwNW7Kjq', 'michal.wieckiewicz@azd.pl', 'ksiegowosc', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rezerwacje`
--

CREATE TABLE `rezerwacje` (
  `id` int(11) NOT NULL,
  `poczatekRezerwacji` datetime NOT NULL,
  `koniecRezerwacji` datetime NOT NULL,
  `id_sali` int(11) NOT NULL,
  `id_pracownika` int(11) NOT NULL,
  `czyPotwierdzona` tinyint(1) NOT NULL,
  `tematSpotkania` varchar(255) NOT NULL,
  `uwagi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `rezerwacje`
--

INSERT INTO `rezerwacje` (`id`, `poczatekRezerwacji`, `koniecRezerwacji`, `id_sali`, `id_pracownika`, `czyPotwierdzona`, `tematSpotkania`, `uwagi`) VALUES
(47, '2021-06-14 08:00:00', '2021-06-14 10:10:00', 1, 10, 1, 'Zarządzanie ryzykiem', 'Dla każdego uczestnika spotkania potrzebne: notatnik, długopis, linijka.+catering1+kawa'),
(48, '2021-06-14 10:15:00', '2021-06-14 11:35:00', 1, 10, 1, 'Narada koordynacyjna', 'Dla każdego uczestnika narady proszę zapewnić: wodę, tablet, długopis + notatnik+kawa'),
(49, '2021-06-14 12:50:00', '2021-06-14 14:45:00', 1, 10, 1, 'Problemy w projektowaniu stron responsywnych', 'Każdy uczestnik proszony jest o przyjście z laptopem+kawa'),
(50, '2021-07-05 09:15:00', '2021-07-05 16:00:00', 4, 10, 0, 'Wyzwania współczesnej edukacji informatycznej', 'Każdy uczestnik powinien otrzymać: 1 egzemplarz poradnika szkoleniowego, notatnik, długopis, butelkę wody.+kawa'),
(51, '2021-06-14 08:00:00', '2021-06-14 11:10:00', 3, 10, 1, 'I Ogólnopolska Neurobiologiczna Konferencja Naukowa „Neuron” ', 'Wymagany dobry sprzęt do nagłośnienia sali, prosimy o przyniesienie ze sobą laptop&oacute;w. Dla każdego uczestnika butelka wody+kawa'),
(52, '2021-07-05 10:00:00', '2021-07-05 14:55:00', 2, 10, 0, 'Światowy dzień społeczeństwa informacyjnego - webinar', 'Prosimy uczestnik&oacute;w o przyniesienie laptop&oacute;w. Dla każdego uczestnika zapewniamy butelkę wody i kanapki.+kawa'),
(53, '2021-07-05 09:00:00', '2021-07-05 11:25:00', 6, 10, 1, 'Informatyka w edukacji', 'Zapraszamy nauczycieli, rodzic&oacute;w, uczni&oacute;w.+catering2'),
(54, '2021-07-05 09:00:00', '2021-07-05 14:10:00', 5, 10, 0, 'Warsztaty mikrokomputerowe Politechniki Lubelskiej', 'Zapewniamy 10 zestaw&oacute;w komputer&oacute;w, dostęp do internetu, dostęp do automat&oacute;w ze słodyczami+catering2'),
(55, '2021-07-05 12:00:00', '2021-07-05 13:10:00', 3, 3, 1, 'Metody Komputerowe w Ekonomii Eksperymentalnej', 'Typ: konferencja naukowa/krajowaOrganizatorzy: Oddział Zachodniopomorski PTI (wsp&oacute;łorganizator)'),
(56, '2021-07-05 11:00:00', '2021-07-05 13:25:00', 1, 3, 1, 'InfoTrendy - Szczecińskie Dni Informatyki', 'Typ: pakiet konferencji, spotkań branżowych i konkurs&oacute;w Organizator: Oddział Zachodniopomorski PTI (wsp&oacute;łorganizator)+kawa'),
(57, '2021-07-05 13:20:00', '2021-07-05 14:35:00', 3, 3, 1, 'Sztuczna Inteligencja', 'Wszystkich zainteresowanych zagadnieniami z pogranicza filozofii, kognitywistyki i nowoczesnych technologii serdecznie zapraszamy na spotkanie popularno-naukowe poświęcone sztucznej inteligencji.+catering1+kawa'),
(58, '2021-07-05 08:00:00', '2021-07-05 11:00:00', 1, 3, 1, 'Studencka Konferencja Zastosowań Matematyki DwuMIan', 'Referaty zostały przygotowane w ramach Studenckiego Koła Naukowego Algebry (Patrycja Odyniec i Katarzyna Pawelczyk), Studenckiego Koła Naukowego &bdquo;Math4You&rdquo; (Jan Gromko) oraz grantu 2016/21/B/HS4/02004 &bdquo;Badania komparatywne wsp&oacute;lności w płynności na rynkach giełdowych Europy Środkowo &ndash; Wschodniej&rdquo;, finansowanego przez Narodowe Centrum Nauki +kawa'),
(59, '2021-07-05 08:00:00', '2021-07-05 09:10:00', 4, 12, 1, 'XXIII Międzynarodowe Warsztaty dla Młodych Matematyków', 'Pragniemy, by wzięli w nim udział najzdolniejsi, zainteresowani matematyką uczniowie lice&oacute;w i technik&oacute;w z całej Polski. Podczas warsztat&oacute;w będą oni mieli okazję zetknąć się z wybitnymi matematykami, usłyszeć specjalnie dla nich przygotowane znakomite wykłady, a niekt&oacute;rzy z nich wygłoszą własne referaty.+catering2');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sale`
--

CREATE TABLE `sale` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(50) NOT NULL,
  `liczbaOsob` int(11) NOT NULL,
  `ostatniaRezerwacja` int(11) DEFAULT NULL,
  `opis` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `sale`
--

INSERT INTO `sale` (`id`, `nazwa`, `liczbaOsob`, `ostatniaRezerwacja`, `opis`) VALUES
(1, 'Bankietowa', 400, NULL, 'Sala o powierzchni 790 m² z bezpośrednim dostępem do szatni, kilkunastu toalet, niezależne wejście reprezentacyjne do Kompleksu. Idealna powierzchnia pod zorganizowanie imprezy firmowej dla 100-400 osób lub pokazu mody/gali biznesowej. Sala klimatyzowana, z dostępem do Wi-Fi, wyposażona: w rzutnik, system nagłaśniający, flipchart, monitorowana. Możliwość dowolnej charakteryzacji przestrzeni.'),
(2, 'Basenowa', 30, NULL, 'Sala o powierzchni 64 m² z widokiem na strefę basenów sportowych oraz trybuny przy basenach. Sala w pełni klimatyzowana, z dostępem do Wi-Fi. Wyposażona: rzutnik, flipchart. Idealna na kameralne spotkania biznesowe, szkolenia do 30 osób, z możliwością wydzielenia strefy chillout/catering.'),
(3, 'Lustrzana', 100, NULL, 'Sala o powierzchni 112 m² z lustrami, podłoga w płytkach. Idealna przestrzeń do prowadzenia warsztatów tanecznych, szkoleń dla firm z branży medycznych, szkoleń finansowych. Sala wyposażona: w klimatyzację , z światłem dziennym, z możliwością zaciemnienia, z dostępem do Wi-Fi, flipchart, rzutnik. Sala mieszcząca do 100 osób w układzie teatralnym.'),
(4, 'Ciemna', 50, NULL, 'Sala o powierzchni 80 m², multimedialna, wyposażona w system nagłośnieniowy, podwieszany rzutnik, flipchart, klimatyzowana, z dostępem do Wi-Fi. Idealna pod szkolenia dla 20-50 osób. Możliwość ułożenia wszelkich konfiguracji krzeseł. Sala bardzo dobrze zaciemniona z uwagi na brak okien.'),
(5, 'Kameralna', 10, NULL, 'Oferujemy kameralne, wygodne i nowocześnie urządzone miejsce dla 10 osób. Wyposażenie sali to między innymi: wysokiej klasy projektor o rozdzielczości FULL HD, wskaźnik laserowy, flipchart, kącik kawowy wraz z ekspresem, każde stanowisko z dostępem do zasilania 230V i portem USB.'),
(6, 'Szkoleniowa', 40, NULL, 'Położona na 5 piętrze sala jest bardzo przestrzenna i dobrze oświetlona. Przestronna sala konferencyjna o powierzchni 45,2 m2 pozwala na organizację szkoleń i wystąpień dla nawet 40 osób. Ustawienie sali jest dostosowywane do indywidualnych potrzeb klientów. Sala wyposażona jest w wysokiej klasy sprzęt multimedialny, który jest zawieszony na suficie, niezbędny do przeprowadzenia dużych konferencji czy szkoleń, flipchart oraz WiFi.');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rezerwacje_fk_pracownicy` (`id_pracownika`),
  ADD KEY `rezerwacje_fk_sale` (`id_sali`);

--
-- Indeksy dla tabeli `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `sale_fk_rezerwacje` (`ostatniaRezerwacja`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT dla tabeli `rezerwacje`
--
ALTER TABLE `rezerwacje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT dla tabeli `sale`
--
ALTER TABLE `sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD CONSTRAINT `rezerwacje_fk_pracownicy` FOREIGN KEY (`id_pracownika`) REFERENCES `pracownicy` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rezerwacje_fk_sale` FOREIGN KEY (`id_sali`) REFERENCES `sale` (`id`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `sale_fk_rezerwacje` FOREIGN KEY (`ostatniaRezerwacja`) REFERENCES `rezerwacje` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
