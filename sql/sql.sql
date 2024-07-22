-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.32-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Copiando dados para a tabela soccer_system.events: ~4 rows (aproximadamente)
INSERT INTO `events` (`id_event`, `name_event`, `id_location`, `date_event`, `created_at`, `updated_at`) VALUES
	(24, 'Teste', 36, '2024-07-22', '2024-07-22 14:47:01', '2024-07-22 14:47:01'),
	(25, 'Novo Evento', 36, '2024-07-27', '2024-07-22 14:49:00', '2024-07-22 14:49:00'),
	(26, 'Novo Evento', 28, '2024-07-26', '2024-07-22 14:50:34', '2024-07-22 14:50:34'),
	(27, 'Novo Evento', 34, '2024-07-31', '2024-07-22 14:52:11', '2024-07-22 14:52:11');

-- Copiando dados para a tabela soccer_system.locations: ~10 rows (aproximadamente)
INSERT INTO `locations` (`id_location`, `name_location`, `location_location`, `created_at`, `updated_at`) VALUES
	(27, 'Estádio do Maracanã', 'Rio de Janeiro', '2024-07-22 10:33:47', '2024-07-22 10:33:47'),
	(28, 'Arena Corinthians', 'São Paulo', '2024-07-22 10:33:47', '2024-07-22 10:33:47'),
	(29, 'Estádio Beira-Rio', 'Porto Alegre', '2024-07-22 10:33:47', '2024-07-22 10:33:47'),
	(30, 'Estádio Mineirão', 'Belo Horizonte', '2024-07-22 10:33:47', '2024-07-22 10:33:47'),
	(31, 'Estádio Morumbi', 'São Paulo', '2024-07-22 10:33:47', '2024-07-22 10:33:47'),
	(32, 'Arena da Baixada', 'Curitiba', '2024-07-22 10:33:47', '2024-07-22 10:33:47'),
	(33, 'Estádio Palestra Itália', 'São Paulo', '2024-07-22 10:33:47', '2024-07-22 10:33:47'),
	(34, 'Estádio Castelão', 'Fortaleza', '2024-07-22 10:33:47', '2024-07-22 10:33:47'),
	(35, 'Estádio Olímpico', 'Goiânia', '2024-07-22 10:33:47', '2024-07-22 10:33:47'),
	(36, 'Estádio Couto Pereira', 'Curitiba', '2024-07-22 10:33:47', '2024-07-22 10:33:47');

-- Copiando dados para a tabela soccer_system.migrations: ~6 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(2, '2024_07_21_184128_create_locations_table', 1),
	(3, '2024_07_21_192738_create_players_table', 1),
	(4, '2024_07_21_194155_create_events_table', 1),
	(5, '2024_07_21_194238_create_teams_table', 1),
	(6, '2024_07_21_194346_create_players_teams_table', 1);

-- Copiando dados para a tabela soccer_system.players: ~35 rows (aproximadamente)
INSERT INTO `players` (`id_player`, `name_player`, `level_player`, `position_player`, `age_player`, `created_at`, `updated_at`) VALUES
	(25, 'João Silva', 3, 'ATA', 23, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(26, 'Pedro Santos', 2, 'MEI', 29, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(27, 'Lucas Oliveira', 5, 'ATA', 31, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(28, 'Carlos Souza', 4, 'ATA', 25, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(29, 'Miguel Costa', 1, 'MEI', 21, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(30, 'Mateus Almeida', 2, 'ATA', 30, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(31, 'Felipe Fernandes', 3, 'ATA', 28, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(32, 'Rafael Pereira', 4, 'MEI', 24, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(33, 'André Lima', 5, 'ATA', 27, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(34, 'Gustavo Martins', 2, 'MEI', 22, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(35, 'Bruno Rocha', 3, 'MEI', 25, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(36, 'Eduardo Silva', 1, 'ATA', 32, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(37, 'Roberto Oliveira', 4, 'GOL', 26, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(38, 'Daniel Costa', 5, 'MEI', 24, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(39, 'Thiago Santos', 3, 'DEF', 29, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(40, 'Henrique Ferreira', 2, 'ATA', 30, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(41, 'Gabriel Sousa', 1, 'MEI', 22, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(42, 'Leandro Almeida', 4, 'DEF', 25, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(43, 'Vinícius Lima', 5, 'GOL', 27, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(44, 'Marcelo Pereira', 2, 'MEI', 28, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(45, 'Juliano Costa', 3, 'DEF', 31, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(46, 'Fernando Silva', 4, 'MEI', 23, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(47, 'Paulo Santos', 1, 'MEI', 26, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(48, 'Rogério Lima', 2, 'DEF', 24, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(49, 'César Oliveira', 3, 'ATA', 29, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(50, 'Ricardo Almeida', 4, 'MEI', 30, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(51, 'Alan Rocha', 2, 'DEF', 32, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(52, 'José Martins', 5, 'ATA', 25, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(53, 'Elias Ferreira', 1, 'MEI', 27, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(54, 'Vitor Sousa', 3, 'GOL', 28, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(55, 'Sérgio Costa', 2, 'GOL', 24, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(56, 'João Paulo Silva', 4, 'MEI', 29, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(57, 'Mário Pereira', 5, 'DEF', 26, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(58, 'Ricardo Santos', 2, 'GOL', 23, '2024-07-22 10:32:37', '2024-07-22 10:32:37'),
	(59, 'Felipe Lima', 3, 'MEI', 28, '2024-07-22 10:32:37', '2024-07-22 10:32:37');

-- Copiando dados para a tabela soccer_system.players_teams: ~0 rows (aproximadamente)
INSERT INTO `players_teams` (`id_player_team`, `id_team`, `id_player`, `created_at`, `updated_at`) VALUES
	(128, 49, 37, NULL, NULL),
	(129, 49, 29, NULL, NULL),
	(130, 49, 32, NULL, NULL),
	(131, 49, 57, NULL, NULL),
	(132, 49, 39, NULL, NULL),
	(133, 49, 47, NULL, NULL),
	(134, 49, 49, NULL, NULL),
	(135, 49, 51, NULL, NULL),
	(136, 50, 55, NULL, NULL),
	(137, 50, 27, NULL, NULL),
	(138, 50, 44, NULL, NULL),
	(139, 50, 30, NULL, NULL),
	(140, 50, 59, NULL, NULL),
	(141, 50, 38, NULL, NULL),
	(142, 50, 40, NULL, NULL),
	(143, 50, 45, NULL, NULL),
	(144, 51, 54, NULL, NULL),
	(145, 51, 25, NULL, NULL),
	(146, 51, 31, NULL, NULL),
	(147, 51, 33, NULL, NULL),
	(148, 51, 50, NULL, NULL),
	(149, 51, 52, NULL, NULL),
	(150, 51, 41, NULL, NULL),
	(151, 51, 26, NULL, NULL),
	(152, 52, 43, NULL, NULL),
	(153, 52, 56, NULL, NULL),
	(154, 52, 34, NULL, NULL),
	(155, 52, 42, NULL, NULL),
	(156, 52, 35, NULL, NULL),
	(157, 52, 28, NULL, NULL),
	(158, 52, 46, NULL, NULL),
	(159, 52, 36, NULL, NULL),
	(160, 53, 58, NULL, NULL),
	(161, 53, 53, NULL, NULL),
	(162, 53, 48, NULL, NULL),
	(163, 54, 43, NULL, NULL),
	(164, 54, 56, NULL, NULL),
	(165, 54, 26, NULL, NULL),
	(166, 54, 25, NULL, NULL),
	(167, 55, 58, NULL, NULL),
	(168, 55, 59, NULL, NULL),
	(169, 55, 42, NULL, NULL),
	(170, 55, 44, NULL, NULL),
	(171, 56, 54, NULL, NULL),
	(172, 56, 27, NULL, NULL),
	(173, 56, 51, NULL, NULL),
	(174, 56, 57, NULL, NULL),
	(175, 57, 55, NULL, NULL),
	(176, 57, 47, NULL, NULL),
	(177, 57, 46, NULL, NULL),
	(178, 57, 38, NULL, NULL),
	(179, 58, 37, NULL, NULL),
	(180, 58, 30, NULL, NULL),
	(181, 58, 41, NULL, NULL),
	(182, 58, 34, NULL, NULL),
	(183, 59, 35, NULL, NULL),
	(184, 59, 40, NULL, NULL),
	(185, 59, 50, NULL, NULL),
	(186, 59, 36, NULL, NULL),
	(187, 59, 29, NULL, NULL),
	(188, 59, 49, NULL, NULL),
	(189, 59, 39, NULL, NULL),
	(190, 59, 52, NULL, NULL),
	(191, 59, 31, NULL, NULL),
	(192, 59, 45, NULL, NULL),
	(193, 59, 48, NULL, NULL),
	(194, 59, 32, NULL, NULL),
	(195, 59, 53, NULL, NULL),
	(196, 59, 33, NULL, NULL),
	(197, 59, 28, NULL, NULL),
	(198, 60, 55, NULL, NULL),
	(199, 60, 57, NULL, NULL),
	(200, 60, 51, NULL, NULL),
	(201, 60, 52, NULL, NULL),
	(202, 61, 58, NULL, NULL),
	(203, 61, 50, NULL, NULL),
	(204, 61, 56, NULL, NULL),
	(205, 61, 53, NULL, NULL),
	(206, 62, 59, NULL, NULL),
	(207, 63, 55, NULL, NULL),
	(208, 63, 52, NULL, NULL),
	(209, 63, 53, NULL, NULL),
	(210, 63, 57, NULL, NULL),
	(211, 64, 58, NULL, NULL),
	(212, 64, 59, NULL, NULL),
	(213, 64, 51, NULL, NULL),
	(214, 64, 50, NULL, NULL),
	(215, 65, 54, NULL, NULL),
	(216, 65, 56, NULL, NULL);

-- Copiando dados para a tabela soccer_system.teams: ~0 rows (aproximadamente)
INSERT INTO `teams` (`id_team`, `id_event`, `name_team`, `level_team`, `created_at`, `updated_at`) VALUES
	(49, 24, '1', 0, '2024-07-22 14:47:01', '2024-07-22 14:47:01'),
	(50, 24, '2', 0, '2024-07-22 14:47:01', '2024-07-22 14:47:01'),
	(51, 24, '3', 0, '2024-07-22 14:47:01', '2024-07-22 14:47:01'),
	(52, 24, '4', 0, '2024-07-22 14:47:01', '2024-07-22 14:47:01'),
	(53, 24, '1 Reserva', 0, '2024-07-22 14:47:01', '2024-07-22 14:47:01'),
	(54, 25, '1', 14, '2024-07-22 14:49:00', '2024-07-22 14:49:00'),
	(55, 25, '2', 11, '2024-07-22 14:49:00', '2024-07-22 14:49:00'),
	(56, 25, '3', 15, '2024-07-22 14:49:00', '2024-07-22 14:49:00'),
	(57, 25, '4', 12, '2024-07-22 14:49:00', '2024-07-22 14:49:00'),
	(58, 25, '5', 9, '2024-07-22 14:49:00', '2024-07-22 14:49:00'),
	(59, 25, '1 Reserva', 44, '2024-07-22 14:49:00', '2024-07-22 14:49:00'),
	(60, 26, 'Time 1', 14, '2024-07-22 14:50:34', '2024-07-22 14:50:34'),
	(61, 26, 'Time 2', 11, '2024-07-22 14:50:34', '2024-07-22 14:50:34'),
	(62, 26, 'Time 1 Reserva', 3, '2024-07-22 14:50:34', '2024-07-22 14:50:34'),
	(63, 27, 'Time 1', 13, '2024-07-22 14:52:11', '2024-07-22 14:52:11'),
	(64, 27, 'Time 2', 11, '2024-07-22 14:52:11', '2024-07-22 14:52:11'),
	(65, 27, 'Time 1 Reserva', 7, '2024-07-22 14:52:11', '2024-07-22 14:52:11');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
