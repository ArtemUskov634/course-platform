-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 23 2026 г., 15:44
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `project`
--

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_text` varchar(500) NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer_text`, `is_correct`) VALUES
(8, 3, 'Odpowiedź 1 – prawidłowa', 1),
(9, 3, 'Odpowiedź 2', 0),
(10, 3, 'Odpowiedź 3', 0),
(11, 3, 'Odpowiedź 4', 0),
(12, 4, 'Odpowiedź 1 – prawidłowa', 1),
(13, 4, 'Odpowiedź 2', 0),
(14, 4, 'Odpowiedź 3', 0),
(15, 4, 'Odpowiedź 4', 0),
(16, 5, 'Odpowiedź 1 – prawidłowa', 1),
(17, 5, 'Odpowiedź 2', 0),
(18, 5, 'Odpowiedź 3', 0),
(19, 5, 'Odpowiedź 4', 0),
(20, 6, 'Odpowiedź 1 – prawidłowa', 1),
(21, 6, 'Odpowiedź 2', 0),
(22, 6, 'Odpowiedź 3', 0),
(23, 6, 'Odpowiedź 4', 0),
(24, 7, 'Odpowiedź 1 – prawidłowa', 1),
(25, 7, 'Odpowiedź 2', 0),
(26, 7, 'Odpowiedź 3', 0),
(27, 7, 'Odpowiedź 4', 0),
(28, 8, 'Odpowiedź 1 – prawidłowa', 1),
(29, 8, 'Odpowiedź 2', 0),
(30, 8, 'Odpowiedź 3', 0),
(31, 8, 'Odpowiedź 4', 0),
(32, 9, 'Odpowiedź 1 – prawidłowa', 1),
(33, 9, 'Odpowiedź 2', 0),
(34, 9, 'Odpowiedź 3', 0),
(35, 9, 'Odpowiedź 4', 0),
(36, 10, 'Odpowiedź 1 – prawidłowa', 1),
(37, 10, 'Odpowiedź 2', 0),
(38, 10, 'Odpowiedź 3', 0),
(39, 10, 'Odpowiedź 4', 0),
(40, 11, 'Odpowiedź 1 – prawidłowa', 1),
(41, 11, 'Odpowiedź 2', 0),
(42, 11, 'Odpowiedź 3', 0),
(43, 11, 'Odpowiedź 4', 0),
(44, 12, 'Odpowiedź 1 – prawidłowa', 1),
(45, 12, 'Odpowiedź 2', 0),
(46, 12, 'Odpowiedź 3', 0),
(47, 12, 'Odpowiedź 4', 0),
(48, 13, 'Odpowiedź 1 – prawidłowa', 1),
(49, 13, 'Odpowiedź 2', 0),
(50, 13, 'Odpowiedź 3', 0),
(51, 13, 'Odpowiedź 4', 0),
(52, 14, 'Odpowiedź 1 – prawidłowa', 1),
(53, 14, 'Odpowiedź 2', 0),
(54, 14, 'Odpowiedź 3', 0),
(55, 14, 'Odpowiedź 4', 0),
(56, 15, 'Odpowiedź 1 – prawidłowa', 1),
(57, 15, 'Odpowiedź 2', 0),
(58, 15, 'Odpowiedź 3', 0),
(59, 15, 'Odpowiedź 4', 0),
(60, 16, 'Odpowiedź 1 – prawidłowa', 1),
(61, 16, 'Odpowiedź 2', 0),
(62, 16, 'Odpowiedź 3', 0),
(63, 16, 'Odpowiedź 4', 0),
(64, 17, 'Odpowiedź 1 – prawidłowa', 1),
(65, 17, 'Odpowiedź 2', 0),
(66, 17, 'Odpowiedź 3', 0),
(67, 17, 'Odpowiedź 4', 0),
(68, 18, 'Odpowiedź 1 – prawidłowa', 1),
(69, 18, 'Odpowiedź 2', 0),
(70, 18, 'Odpowiedź 3', 0),
(71, 18, 'Odpowiedź 4', 0),
(72, 19, 'Odpowiedź 1 – prawidłowa', 1),
(73, 19, 'Odpowiedź 2', 0),
(74, 19, 'Odpowiedź 3', 0),
(75, 19, 'Odpowiedź 4', 0),
(76, 20, 'Odpowiedź 1 – prawidłowa', 1),
(77, 20, 'Odpowiedź 2', 0),
(78, 20, 'Odpowiedź 3', 0),
(79, 20, 'Odpowiedź 4', 0),
(80, 21, 'Odpowiedź 1 – prawidłowa', 1),
(81, 21, 'Odpowiedź 2', 0),
(82, 21, 'Odpowiedź 3', 0),
(83, 21, 'Odpowiedź 4', 0),
(84, 22, 'Odpowiedź 1 – prawidłowa', 1),
(85, 22, 'Odpowiedź 2', 0),
(86, 22, 'Odpowiedź 3', 0),
(87, 22, 'Odpowiedź 4', 0),
(88, 23, 'Odpowiedź 1 – prawidłowa', 1),
(89, 23, 'Odpowiedź 2', 0),
(90, 23, 'Odpowiedź 3', 0),
(91, 23, 'Odpowiedź 4', 0),
(92, 24, 'Odpowiedź 1 – prawidłowa', 1),
(93, 24, 'Odpowiedź 2', 0),
(94, 24, 'Odpowiedź 3', 0),
(95, 24, 'Odpowiedź 4', 0),
(96, 25, 'Odpowiedź 1 – prawidłowa', 1),
(97, 25, 'Odpowiedź 2', 0),
(98, 25, 'Odpowiedź 3', 0),
(99, 25, 'Odpowiedź 4', 0),
(100, 26, 'Odpowiedź 1 – prawidłowa', 1),
(101, 26, 'Odpowiedź 2', 0),
(102, 26, 'Odpowiedź 3', 0),
(103, 26, 'Odpowiedź 4', 0),
(104, 27, 'Odpowiedź 1 – prawidłowa', 1),
(105, 27, 'Odpowiedź 2', 0),
(106, 27, 'Odpowiedź 3', 0),
(107, 27, 'Odpowiedź 4', 0),
(108, 28, 'Odpowiedź 1 – prawidłowa', 1),
(109, 28, 'Odpowiedź 2', 0),
(110, 28, 'Odpowiedź 3', 0),
(111, 28, 'Odpowiedź 4', 0),
(112, 29, 'Odpowiedź 1 – prawidłowa', 1),
(113, 29, 'Odpowiedź 2', 0),
(114, 29, 'Odpowiedź 3', 0),
(115, 29, 'Odpowiedź 4', 0),
(116, 30, 'Odpowiedź 1 – prawidłowa', 1),
(117, 30, 'Odpowiedź 2', 0),
(118, 30, 'Odpowiedź 3', 0),
(119, 30, 'Odpowiedź 4', 0),
(120, 31, 'Odpowiedź 1 – prawidłowa', 1),
(121, 31, 'Odpowiedź 2', 0),
(122, 31, 'Odpowiedź 3', 0),
(123, 31, 'Odpowiedź 4', 0),
(124, 32, 'Odpowiedź 1 – prawidłowa', 1),
(125, 32, 'Odpowiedź 2', 0),
(126, 32, 'Odpowiedź 3', 0),
(127, 32, 'Odpowiedź 4', 0),
(128, 33, 'Odpowiedź 1 – prawidłowa', 1),
(129, 33, 'Odpowiedź 2', 0),
(130, 33, 'Odpowiedź 3', 0),
(131, 33, 'Odpowiedź 4', 0),
(132, 34, 'Odpowiedź 1 – prawidłowa', 1),
(133, 34, 'Odpowiedź 2', 0),
(134, 34, 'Odpowiedź 3', 0),
(135, 34, 'Odpowiedź 4', 0),
(136, 35, 'Odpowiedź 1 – prawidłowa', 1),
(137, 35, 'Odpowiedź 2', 0),
(138, 35, 'Odpowiedź 3', 0),
(139, 35, 'Odpowiedź 4', 0),
(140, 36, 'Odpowiedź 1 – prawidłowa', 1),
(141, 36, 'Odpowiedź 2', 0),
(142, 36, 'Odpowiedź 3', 0),
(143, 36, 'Odpowiedź 4', 0),
(144, 37, 'Odpowiedź 1 – prawidłowa', 1),
(145, 37, 'Odpowiedź 2', 0),
(146, 37, 'Odpowiedź 3', 0),
(147, 37, 'Odpowiedź 4', 0),
(148, 38, 'Odpowiedź 1 – prawidłowa', 1),
(149, 38, 'Odpowiedź 2', 0),
(150, 38, 'Odpowiedź 3', 0),
(151, 38, 'Odpowiedź 4', 0),
(152, 39, 'Odpowiedź 1 – prawidłowa', 1),
(153, 39, 'Odpowiedź 2', 0),
(154, 39, 'Odpowiedź 3', 0),
(155, 39, 'Odpowiedź 4', 0),
(156, 40, 'Odpowiedź 1 – prawidłowa', 1),
(157, 40, 'Odpowiedź 2', 0),
(158, 40, 'Odpowiedź 3', 0),
(159, 40, 'Odpowiedź 4', 0),
(160, 41, 'Odpowiedź 1 – prawidłowa', 1),
(161, 41, 'Odpowiedź 2', 0),
(162, 41, 'Odpowiedź 3', 0),
(163, 41, 'Odpowiedź 4', 0),
(164, 42, 'Odpowiedź 1 – prawidłowa', 1),
(165, 42, 'Odpowiedź 2', 0),
(166, 42, 'Odpowiedź 3', 0),
(167, 42, 'Odpowiedź 4', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `issued_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `certificates`
--

INSERT INTO `certificates` (`id`, `user_id`, `course_id`, `code`, `issued_at`) VALUES
(3, 6, 20, 'CERT-995805AE', '2026-11-23 14:41:10');

-- --------------------------------------------------------

--
-- Структура таблицы `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `topic` enum('bhp','rodo','sygnalisci','ochrona_maloletnich') NOT NULL DEFAULT 'bhp',
  `specialization` enum('ogolne','medyczna','hotele','szkoly','firmy') NOT NULL DEFAULT 'ogolne',
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `topic`, `specialization`, `price`, `is_published`, `created_at`) VALUES
(5, 'Szkolenie BHP – ogólne', 'Podstawowe szkolenie z bezpieczeństwa i higieny pracy.', 'bhp', 'ogolne', 99.00, 1, '2026-11-23 14:15:50'),
(6, 'Szkolenie BHP – branża medyczna', 'Szkolenie BHP dostosowane do placówek medycznych i ochrony zdrowia.', 'bhp', 'medyczna', 99.00, 1, '2026-11-23 14:15:50'),
(7, 'Szkolenie BHP – hotele', 'Szkolenie BHP dla pracowników branży hotelarskiej i gastronomicznej.', 'bhp', 'hotele', 99.00, 1, '2026-11-23 14:15:50'),
(8, 'Szkolenie BHP – szkoły', 'Szkolenie BHP dla nauczycieli i pracowników placówek oświatowych.', 'bhp', 'szkoly', 99.00, 1, '2026-11-23 14:15:50'),
(9, 'Szkolenie BHP – firmy prywatne', 'Szkolenie BHP dla pracowników firm prywatnych.', 'bhp', 'firmy', 99.00, 1, '2026-11-23 14:15:50'),
(10, 'Szkolenie RODO – ogólne', 'Podstawy ochrony danych osobowych i obowiązki wynikające z RODO.', 'rodo', 'ogolne', 99.00, 1, '2026-11-23 14:15:50'),
(11, 'Szkolenie RODO – branża medyczna', 'Ochrona danych osobowych pacjentów i dokumentacji medycznej.', 'rodo', 'medyczna', 99.00, 1, '2026-11-23 14:15:50'),
(12, 'Szkolenie RODO – hotele', 'Ochrona danych gości i pracowników w branży hotelarskiej.', 'rodo', 'hotele', 99.00, 1, '2026-11-23 14:15:50'),
(13, 'Szkolenie RODO – szkoły', 'Ochrona danych uczniów, rodziców i pracowników placówek oświatowych.', 'rodo', 'szkoly', 99.00, 1, '2026-11-23 14:15:50'),
(14, 'Szkolenie RODO – firmy prywatne', 'Ochrona danych klientów i pracowników w firmach prywatnych.', 'rodo', 'firmy', 99.00, 1, '2026-11-23 14:15:50'),
(15, 'Szkolenie dla sygnalistów – ogólne', 'Zasady zgłaszania naruszeń prawa i ochrony sygnalistów.', 'sygnalisci', 'ogolne', 99.00, 1, '2026-11-23 14:15:50'),
(16, 'Szkolenie dla sygnalistów – branża medyczna', 'Zgłaszanie naruszeń i ochrona sygnalistów w placówkach medycznych.', 'sygnalisci', 'medyczna', 99.00, 1, '2026-11-23 14:15:50'),
(17, 'Szkolenie dla sygnalistów – hotele', 'Zgłaszanie naruszeń i ochrona sygnalistów w branży hotelarskiej.', 'sygnalisci', 'hotele', 99.00, 1, '2026-11-23 14:15:50'),
(18, 'Szkolenie dla sygnalistów – szkoły', 'Zgłaszanie naruszeń i ochrona sygnalistów w placówkach oświatowych.', 'sygnalisci', 'szkoly', 99.00, 1, '2026-11-23 14:15:50'),
(19, 'Szkolenie dla sygnalistów – firmy prywatne', 'Zgłaszanie naruszeń i ochrona sygnalistów w firmach prywatnych.', 'sygnalisci', 'firmy', 99.00, 1, '2026-11-23 14:15:50'),
(20, 'Ochrona małoletnich – ogólne', 'Podstawowe zasady ochrony dzieci i młodzieży przed krzywdzeniem.', 'ochrona_maloletnich', 'ogolne', 99.00, 1, '2026-11-23 14:15:50'),
(21, 'Ochrona małoletnich – branża medyczna', 'Standardy ochrony małoletnich w placówkach medycznych.', 'ochrona_maloletnich', 'medyczna', 99.00, 1, '2026-11-23 14:15:50'),
(22, 'Ochrona małoletnich – hotele', 'Standardy ochrony małoletnich w branży hotelarskiej.', 'ochrona_maloletnich', 'hotele', 99.00, 1, '2026-11-23 14:15:50'),
(23, 'Ochrona małoletnich – szkoły', 'Standardy ochrony małoletnich w placówkach oświatowych.', 'ochrona_maloletnich', 'szkoly', 99.00, 1, '2026-11-23 14:15:50'),
(24, 'Ochrona małoletnich – firmy prywatne', 'Standardy ochrony małoletnich w firmach prywatnych.', 'ochrona_maloletnich', 'firmy', 99.00, 1, '2026-11-23 14:15:50');

-- --------------------------------------------------------

--
-- Структура таблицы `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `enrollments`
--

INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `enrolled_at`) VALUES
(6, 6, 24, '2026-11-23 14:18:00'),
(7, 6, 20, '2026-11-23 14:30:30');

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `type` enum('text','video','presentation') NOT NULL DEFAULT 'text',
  `content` text DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `materials`
--

INSERT INTO `materials` (`id`, `course_id`, `title`, `type`, `content`, `position`) VALUES
(5, 24, 'Ochrona małoletnich – firmy prywatne', 'presentation', '41de90591c907b13.pdf', 1),
(6, 23, 'Ochrona małoletnich – szkoły', 'presentation', 'd37a86ad8fc72878.pdf', 1),
(7, 22, 'Ochrona małoletnich – hotele', 'presentation', 'f4bf68310f44bfa1.pdf', 1),
(8, 21, 'Ochrona małoletnich – branża medyczna', 'presentation', '8f3e62a10932ade7.pdf', 1),
(9, 20, 'Ochrona małoletnich – ogólne', 'presentation', 'd96a060d6a386972.pdf', 1),
(10, 19, 'Szkolenie dla sygnalistów – firmy prywatne', 'presentation', 'b73b9ce8d3b1bba6.pdf', 1),
(11, 18, 'Szkolenie dla sygnalistów – szkoły', 'presentation', 'a16e1c0cbf19a514.pdf', 1),
(12, 17, 'Szkolenie dla sygnalistów – hotele', 'presentation', '340843929f1185db.pdf', 1),
(13, 16, 'Szkolenie dla sygnalistów – branża medyczna', 'presentation', '7ef09675712033e7.pdf', 1),
(14, 15, 'Szkolenie dla sygnalistów – ogólne', 'presentation', '8a6133b4a97a7d82.pdf', 1),
(15, 14, 'Szkolenie RODO – firmy prywatne', 'presentation', 'd62ec053a6ad833c.pdf', 1),
(16, 13, 'Szkolenie RODO – szkoły', 'presentation', '082aefd685582be9.pdf', 1),
(17, 12, 'Szkolenie RODO – hotele', 'presentation', '28e664dddfe434f4.pdf', 1),
(18, 11, 'Szkolenie RODO – branża medyczna', 'presentation', '9d2aaffb481ca6eb.pdf', 1),
(19, 10, 'Szkolenie RODO – ogólne', 'presentation', '275ed41ccc44d2ac.pdf', 1),
(20, 9, 'Szkolenie BHP – firmy prywatne', 'presentation', 'bd92645fa084c4e3.pdf', 1),
(21, 8, 'Szkolenie BHP – szkoły', 'presentation', '527956e72afc5cb9.pdf', 1),
(22, 7, 'Szkolenie BHP – hotele', 'presentation', '6f439880ddc813ec.pdf', 1),
(23, 6, 'Szkolenie BHP – branża medyczna', 'presentation', '48989770f6f59863.pdf', 1),
(24, 5, 'Szkolenie BHP – ogólne', 'presentation', '0b7d2e1ff71957ca.pdf', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `status` enum('paid') NOT NULL DEFAULT 'paid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `course_id`, `amount`, `status`, `created_at`) VALUES
(6, 6, 24, 99.00, 'paid', '2026-11-23 14:18:00'),
(7, 6, 20, 99.00, 'paid', '2026-11-23 14:30:30');

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `question_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`id`, `test_id`, `question_text`) VALUES
(3, 2, 'Pytanie 1'),
(4, 2, 'Pytanie 2'),
(5, 3, 'Pytanie 1'),
(6, 3, 'Pytanie 2'),
(7, 4, 'Pytanie 1'),
(8, 4, 'Pytanie 2'),
(9, 5, 'Pytanie 1'),
(10, 5, 'Pytanie 2'),
(11, 6, 'Pytanie 1'),
(12, 6, 'Pytanie 2'),
(13, 7, 'Pytanie 1'),
(14, 7, 'Pytanie 2'),
(15, 8, 'Pytanie 1'),
(16, 8, 'Pytanie 2'),
(17, 9, 'Pytanie 1'),
(18, 9, 'Pytanie 2'),
(19, 10, 'Pytanie 1'),
(20, 10, 'Pytanie 2'),
(21, 11, 'Pytanie 1'),
(22, 11, 'Pytanie 2'),
(23, 12, 'Pytanie 1'),
(24, 12, 'Pytanie 2'),
(25, 13, 'Pytanie 1'),
(26, 13, 'Pytanie 2'),
(27, 14, 'Pytanie 1'),
(28, 14, 'Pytanie 2'),
(29, 15, 'Pytanie 1'),
(30, 15, 'Pytanie 2'),
(31, 16, 'Pytanie 1'),
(32, 16, 'Pytanie 2'),
(33, 17, 'Pytanie 1'),
(34, 17, 'Pytanie 2'),
(35, 18, 'Pytanie 1'),
(36, 18, 'Pytanie 2'),
(37, 19, 'Pytanie 1'),
(38, 19, 'Pytanie 2'),
(39, 20, 'Pytanie 1'),
(40, 20, 'Pytanie 2'),
(41, 21, 'Pytanie 1'),
(42, 21, 'Pytanie 2');

-- --------------------------------------------------------

--
-- Структура таблицы `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `pass_percent` int(11) NOT NULL DEFAULT 60
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `tests`
--

INSERT INTO `tests` (`id`, `course_id`, `title`, `pass_percent`) VALUES
(2, 5, 'Test BHP – ogólne', 70),
(3, 6, 'Test BHP – branża medyczna', 70),
(4, 7, 'Test BHP – hotele', 70),
(5, 8, 'Test BHP – szkoły', 70),
(6, 9, 'Test BHP – firmy prywatne', 70),
(7, 10, 'Test RODO – ogólne', 70),
(8, 11, 'Test RODO – branża medyczna', 70),
(9, 12, 'Test RODO – hotele', 70),
(10, 13, 'Test RODO – szkoły', 70),
(11, 14, 'Test RODO – firmy prywatne', 70),
(12, 15, 'Test Sygnaliści – ogólne', 70),
(13, 16, 'Test Sygnaliści – branża medyczna', 70),
(14, 17, 'Test Sygnaliści – hotele', 70),
(15, 18, 'Test Sygnaliści – szkoły', 70),
(16, 19, 'Test Sygnaliści – firmy prywatne', 70),
(17, 20, 'Test Ochrona małoletnich – ogólne', 70),
(18, 21, 'Test Ochrona małoletnich – branża medyczna', 70),
(19, 22, 'Test Ochrona małoletnich – hotele', 70),
(20, 23, 'Test Ochrona małoletnich – szkoły', 70),
(21, 24, 'Test Ochrona małoletnich – firmy prywatne', 70);

-- --------------------------------------------------------

--
-- Структура таблицы `test_attempts`
--

CREATE TABLE `test_attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `score_percent` int(11) NOT NULL,
  `passed` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `test_attempts`
--

INSERT INTO `test_attempts` (`id`, `user_id`, `test_id`, `score_percent`, `passed`, `created_at`) VALUES
(7, 6, 17, 50, 0, '2026-11-23 14:40:55'),
(8, 6, 17, 100, 1, '2026-11-23 14:41:08');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `full_name`, `role`, `created_at`) VALUES
(5, 'admin@admin', '$2y$10$K2gyfMGvPorpP.3D2TPK4eKhGUHP59cyoBD76dC8rI3sQG06SlfKy', 'admin', 'admin', '2026-11-23 14:11:28'),
(6, 'uskov.artem.v@gmail.com', '$2y$10$0RcYMBUkErZjbQOn11685Oqo2sUIUNGfIfjVuU6jmbuJ6KhUDqLz2', 'Artem_ Hard', 'user', '2026-11-23 14:17:46');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Индексы таблицы `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `user_course` (`user_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Индексы таблицы `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_course` (`user_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Индексы таблицы `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`);

--
-- Индексы таблицы `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_id` (`course_id`);

--
-- Индексы таблицы `test_attempts`
--
ALTER TABLE `test_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `test_id` (`test_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT для таблицы `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT для таблицы `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `test_attempts`
--
ALTER TABLE `test_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `test_attempts`
--
ALTER TABLE `test_attempts`
  ADD CONSTRAINT `test_attempts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_attempts_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
