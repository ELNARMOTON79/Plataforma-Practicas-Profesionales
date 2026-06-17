-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2026 at 06:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `practicas`
--

-- --------------------------------------------------------

--
-- Table structure for table `bitacora`
--

CREATE TABLE `bitacora` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `level` varchar(20) NOT NULL DEFAULT 'info',
  `level_name` varchar(50) NOT NULL DEFAULT 'Info',
  `user` varchar(255) NOT NULL DEFAULT 'Sistema',
  `user_role` varchar(100) NOT NULL DEFAULT 'Sistema',
  `user_email` varchar(255) DEFAULT NULL,
  `module` varchar(100) NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bitacora`
--

INSERT INTO `bitacora` (`id`, `timestamp`, `level`, `level_name`, `user`, `user_role`, `user_email`, `module`, `action`, `description`, `ip`, `user_agent`, `payload`, `created_at`, `updated_at`) VALUES
(1, '2026-05-26 01:55:20', 'warning', 'Advertencia', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Sistema', 'Limpieza de Bitácora', 'El administrador vació todos los registros de la bitácora del sistema.', '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', NULL, '2026-05-26 01:55:20', '2026-05-26 01:55:20'),
(2, '2026-05-26 01:55:38', 'warning', 'Advertencia', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Usuarios', 'Usuario Habilitado', 'Se cambió el estado del usuario \'coordinador@ucol.mx\' a \'Habilitado\'.', '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '{\n    \"correo\": \"coordinador@ucol.mx\",\n    \"nuevo_estado\": \"Habilitado\"\n}', '2026-05-26 01:55:38', '2026-05-26 01:55:38'),
(3, '2026-05-26 01:55:41', 'warning', 'Advertencia', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Usuarios', 'Usuario Deshabilitado', 'Se cambió el estado del usuario \'coordinador@ucol.mx\' a \'Deshabilitado\'.', '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '{\n    \"correo\": \"coordinador@ucol.mx\",\n    \"nuevo_estado\": \"Deshabilitado\"\n}', '2026-05-26 01:55:41', '2026-05-26 01:55:41'),
(4, '2026-05-26 01:55:42', 'warning', 'Advertencia', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Usuarios', 'Usuario Habilitado', 'Se cambió el estado del usuario \'coordinador@ucol.mx\' a \'Habilitado\'.', '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '{\n    \"correo\": \"coordinador@ucol.mx\",\n    \"nuevo_estado\": \"Habilitado\"\n}', '2026-05-26 01:55:42', '2026-05-26 01:55:42'),
(5, '2026-05-26 01:55:49', 'info', 'Info', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Usuarios', 'Usuario Modificado', 'Se actualizaron los datos del usuario \'Rafael Alexandro Vuelva\' (Alumno) con correo \'rvuelvas@ucol.mx\'.', '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '{\n    \"correo\": \"rvuelvas@ucol.mx\",\n    \"nombre\": \"Rafael Alexandro Vuelva\",\n    \"rol\": \"Alumno\"\n}', '2026-05-26 01:55:49', '2026-05-26 01:55:49'),
(6, '2026-05-26 01:56:44', 'danger', 'Error', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Inicio de Sesión Fallido', 'Intento de inicio de sesión fallido para la cuenta: rvuelvas@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-05-26 01:56:44', '2026-05-26 01:56:44'),
(7, '2026-05-26 02:04:19', 'info', 'Info', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 02:04:19', '2026-05-26 02:04:19'),
(8, '2026-05-26 02:08:58', 'info', 'Info', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Solicitud de Recuperación', 'Se envió un correo de restablecimiento de contraseña a la dirección: rvuelvas@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 02:08:58', '2026-05-26 02:08:58'),
(9, '2026-05-26 02:09:15', 'info', 'Info', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Solicitud de Recuperación', 'Se envió un correo de restablecimiento de contraseña a la dirección: alumno@ucol.mx.', '127.0.0.1', 'Symfony', NULL, '2026-05-26 02:09:15', '2026-05-26 02:09:15'),
(10, '2026-05-26 02:10:12', 'success', 'Éxito', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Restablecimiento de Contraseña', 'El usuario restableció con éxito su contraseña para la cuenta: rvuelvas@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 02:10:12', '2026-05-26 02:10:12'),
(11, '2026-05-26 02:10:18', 'success', 'Éxito', 'Rafael Alexandro Vuelva', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 02:10:18', '2026-05-26 02:10:18'),
(12, '2026-05-26 02:10:31', 'success', 'Éxito', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Restablecimiento de Contraseña', 'El usuario restableció con éxito su contraseña para la cuenta: alumno@ucol.mx.', '127.0.0.1', 'Symfony', NULL, '2026-05-26 02:10:31', '2026-05-26 02:10:31'),
(13, '2026-05-26 02:10:33', 'info', 'Info', 'Rafael Alexandro Vuelva', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 02:10:33', '2026-05-26 02:10:33'),
(14, '2026-05-26 02:10:56', 'info', 'Info', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Solicitud de Recuperación', 'Se envió un correo de restablecimiento de contraseña a la dirección: rvuelvas@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 02:10:56', '2026-05-26 02:10:56'),
(15, '2026-05-26 02:11:10', 'success', 'Éxito', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Restablecimiento de Contraseña', 'El usuario restableció con éxito su contraseña para la cuenta: rvuelvas@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 02:11:10', '2026-05-26 02:11:10'),
(16, '2026-05-26 02:11:20', 'success', 'Éxito', 'Rafael Alexandro Vuelva', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 02:11:20', '2026-05-26 02:11:20'),
(17, '2026-05-26 02:11:22', 'info', 'Info', 'Rafael Alexandro Vuelva', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 02:11:22', '2026-05-26 02:11:22'),
(18, '2026-05-26 02:11:28', 'success', 'Éxito', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 02:11:28', '2026-05-26 02:11:28'),
(19, '2026-05-26 03:04:13', 'info', 'Info', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 03:04:13', '2026-05-26 03:04:13'),
(20, '2026-05-26 03:04:25', 'success', 'Éxito', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 03:04:25', '2026-05-26 03:04:25'),
(21, '2026-05-26 14:09:39', 'success', 'Éxito', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 14:09:39', '2026-05-26 14:09:39'),
(22, '2026-05-26 17:12:19', 'success', 'Éxito', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 17:12:19', '2026-05-26 17:12:19'),
(23, '2026-05-26 17:45:18', 'success', 'Éxito', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Usuarios', 'Importación Masiva', 'Se registraron exitosamente 3 estudiantes mediante importación masiva.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', '{\n    \"cantidad_importada\": 3\n}', '2026-05-26 17:45:18', '2026-05-26 17:45:18'),
(24, '2026-05-26 17:50:46', 'success', 'Éxito', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Usuarios', 'Importación Masiva', 'Se registraron exitosamente 4 estudiantes mediante importación masiva.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', '{\n    \"cantidad_importada\": 4\n}', '2026-05-26 17:50:46', '2026-05-26 17:50:46'),
(25, '2026-05-26 17:58:46', 'info', 'Info', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 17:58:46', '2026-05-26 17:58:46'),
(26, '2026-05-26 17:59:17', 'info', 'Info', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Solicitud de Recuperación', 'Se envió un correo de restablecimiento de contraseña a la dirección: rvuelvas@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 17:59:17', '2026-05-26 17:59:17'),
(27, '2026-05-26 17:59:56', 'success', 'Éxito', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Restablecimiento de Contraseña', 'El usuario restableció con éxito su contraseña para la cuenta: rvuelvas@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 17:59:56', '2026-05-26 17:59:56'),
(28, '2026-05-26 18:00:05', 'success', 'Éxito', 'VUELVAS PEREZ RAFAEL ALEXANDRO', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 18:00:05', '2026-05-26 18:00:05'),
(29, '2026-05-26 18:00:21', 'info', 'Info', 'VUELVAS PEREZ RAFAEL ALEXANDRO', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 18:00:21', '2026-05-26 18:00:21'),
(30, '2026-05-26 18:00:37', 'success', 'Éxito', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 18:00:37', '2026-05-26 18:00:37'),
(31, '2026-05-26 18:05:20', 'success', 'Éxito', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Usuarios', 'Importación Masiva', 'Se registraron exitosamente 21 estudiantes mediante importación masiva.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', '{\n    \"cantidad_importada\": 21\n}', '2026-05-26 18:05:20', '2026-05-26 18:05:20'),
(32, '2026-05-26 18:18:15', 'success', 'Éxito', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Usuarios', 'Usuario Creado', 'Se creó el usuario \'Rafael Alexandro Vuelvas\' con el rol \'Alumno\' y correo \'rvuelvas@ucol.mx\'.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', '{\n    \"correo\": \"rvuelvas@ucol.mx\",\n    \"nombre\": \"Rafael Alexandro Vuelvas\",\n    \"rol\": \"Alumno\"\n}', '2026-05-26 18:18:15', '2026-05-26 18:18:15'),
(33, '2026-05-26 18:20:38', 'info', 'Info', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 18:20:38', '2026-05-26 18:20:38'),
(34, '2026-05-26 18:20:44', 'info', 'Info', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Solicitud de Recuperación', 'Se envió un correo de restablecimiento de contraseña a la dirección: rvuelvas@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 18:20:44', '2026-05-26 18:20:44'),
(35, '2026-05-26 18:22:58', 'success', 'Éxito', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 18:22:58', '2026-05-26 18:22:58'),
(36, '2026-05-26 18:29:53', 'info', 'Info', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 18:29:53', '2026-05-26 18:29:53'),
(37, '2026-05-26 18:36:41', 'success', 'Éxito', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 18:36:41', '2026-05-26 18:36:41'),
(38, '2026-05-26 19:04:49', 'warning', 'Advertencia', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Usuarios', 'Usuario Deshabilitado', 'Se cambió el estado del usuario \'ggutierrez0@ucol.mx\' a \'Deshabilitado\'.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', '{\n    \"correo\": \"ggutierrez0@ucol.mx\",\n    \"nuevo_estado\": \"Deshabilitado\"\n}', '2026-05-26 19:04:49', '2026-05-26 19:04:49'),
(39, '2026-05-26 19:05:03', 'warning', 'Advertencia', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Usuarios', 'Usuario Habilitado', 'Se cambió el estado del usuario \'ggutierrez0@ucol.mx\' a \'Habilitado\'.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', '{\n    \"correo\": \"ggutierrez0@ucol.mx\",\n    \"nuevo_estado\": \"Habilitado\"\n}', '2026-05-26 19:05:03', '2026-05-26 19:05:03'),
(40, '2026-05-26 19:05:04', 'warning', 'Advertencia', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Usuarios', 'Usuario Deshabilitado', 'Se cambió el estado del usuario \'ggutierrez0@ucol.mx\' a \'Deshabilitado\'.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', '{\n    \"correo\": \"ggutierrez0@ucol.mx\",\n    \"nuevo_estado\": \"Deshabilitado\"\n}', '2026-05-26 19:05:04', '2026-05-26 19:05:04'),
(41, '2026-05-26 19:36:08', 'warning', 'Advertencia', 'Usuario Administrador General', 'Administrador', 'admin@ucol.mx', 'Usuarios', 'Usuario Habilitado', 'Se cambió el estado del usuario \'ggutierrez0@ucol.mx\' a \'Habilitado\'.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', '{\n    \"correo\": \"ggutierrez0@ucol.mx\",\n    \"nuevo_estado\": \"Habilitado\"\n}', '2026-05-26 19:36:08', '2026-05-26 19:36:08'),
(42, '2026-05-26 19:48:07', 'success', 'Éxito', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Configuración', 'Perfil Actualizado', 'El administrador actualizó sus datos de perfil: Nombre a \'Administrador General\' y Correo a \'admin@ucol.mx\'.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 19:48:07', '2026-05-26 19:48:07'),
(43, '2026-05-26 19:48:22', 'success', 'Éxito', 'Administrador Generals', 'Administrador', 'admin@ucol.mx', 'Configuración', 'Perfil Actualizado', 'El administrador actualizó sus datos de perfil: Nombre a \'Administrador Generals\' y Correo a \'admin@ucol.mx\'.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 19:48:22', '2026-05-26 19:48:22'),
(44, '2026-05-26 21:56:06', 'success', 'Éxito', 'Administrador Generals', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 21:56:06', '2026-05-26 21:56:06'),
(45, '2026-05-26 22:01:06', 'success', 'Éxito', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Configuración', 'Perfil Actualizado', 'El administrador actualizó sus datos de perfil: Nombre a \'Administrador General\' y Correo a \'admin@ucol.mx\'.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:01:06', '2026-05-26 22:01:06'),
(46, '2026-05-26 22:02:55', 'warning', 'Advertencia', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Configuración', 'Contraseña Cambiada', 'El administrador cambió su contraseña de acceso.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:02:55', '2026-05-26 22:02:55'),
(47, '2026-05-26 22:02:59', 'info', 'Info', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:02:59', '2026-05-26 22:02:59'),
(48, '2026-05-26 22:03:08', 'success', 'Éxito', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:03:08', '2026-05-26 22:03:08'),
(49, '2026-05-26 22:03:22', 'warning', 'Advertencia', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Configuración', 'Contraseña Cambiada', 'El administrador cambió su contraseña de acceso.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:03:22', '2026-05-26 22:03:22'),
(50, '2026-05-26 22:05:06', 'danger', 'Error', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Inicio de Sesión Fallido', 'Intento de inicio de sesión fallido para la cuenta: alumno@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-05-26 22:05:06', '2026-05-26 22:05:06'),
(51, '2026-05-26 22:05:15', 'danger', 'Error', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Inicio de Sesión Fallido', 'Intento de inicio de sesión fallido para la cuenta: alumno@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-05-26 22:05:15', '2026-05-26 22:05:15'),
(52, '2026-05-26 22:05:29', 'danger', 'Error', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Inicio de Sesión Fallido', 'Intento de inicio de sesión fallido para la cuenta: alumno@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-05-26 22:05:29', '2026-05-26 22:05:29'),
(53, '2026-05-26 22:05:33', 'info', 'Info', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:05:33', '2026-05-26 22:05:33'),
(54, '2026-05-26 22:05:40', 'danger', 'Error', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Inicio de Sesión Fallido', 'Intento de inicio de sesión fallido para la cuenta: alumno@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:05:40', '2026-05-26 22:05:40'),
(55, '2026-05-26 22:05:44', 'danger', 'Error', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Inicio de Sesión Fallido', 'Intento de inicio de sesión fallido para la cuenta: alumno@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:05:44', '2026-05-26 22:05:44'),
(56, '2026-05-26 22:09:25', 'danger', 'Error', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Inicio de Sesión Fallido', 'Intento de inicio de sesión fallido para la cuenta: admin@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:09:25', '2026-05-26 22:09:25'),
(57, '2026-05-26 22:09:37', 'danger', 'Error', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Inicio de Sesión Fallido', 'Intento de inicio de sesión fallido para la cuenta: rvuelvas@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:09:37', '2026-05-26 22:09:37'),
(58, '2026-05-26 22:09:41', 'danger', 'Error', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Inicio de Sesión Fallido', 'Intento de inicio de sesión fallido para la cuenta: rvuelvas@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:09:41', '2026-05-26 22:09:41'),
(59, '2026-05-26 22:09:52', 'info', 'Info', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Solicitud de Recuperación', 'Se envió un correo de restablecimiento de contraseña a la dirección: rvuelvas@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:09:52', '2026-05-26 22:09:52'),
(60, '2026-05-26 22:10:26', 'success', 'Éxito', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Restablecimiento de Contraseña', 'El usuario restableció con éxito su contraseña para la cuenta: rvuelvas@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:10:26', '2026-05-26 22:10:26'),
(61, '2026-05-26 22:10:40', 'success', 'Éxito', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:10:40', '2026-05-26 22:10:40'),
(62, '2026-05-26 22:10:53', 'success', 'Éxito', 'Rafael Alexandro Vuelvas', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-05-26 22:10:53', '2026-05-26 22:10:53'),
(63, '2026-05-26 22:12:01', 'info', 'Info', 'Rafael Alexandro Vuelvas', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-05-26 22:12:01', '2026-05-26 22:12:01'),
(64, '2026-05-26 22:12:05', 'warning', 'Advertencia', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Configuración', 'Parámetros del Sistema Actualizados', 'El administrador cambió la configuración del sistema: Modo de Mantenimiento: Activado, Retención de Logs: 180 días.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:12:05', '2026-05-26 22:12:05'),
(65, '2026-05-26 22:12:14', 'danger', 'Error', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Inicio de Sesión Fallido', 'Intento de inicio de sesión fallido para la cuenta: rvuelvas@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-05-26 22:12:14', '2026-05-26 22:12:14'),
(66, '2026-05-26 22:12:23', 'warning', 'Advertencia', 'Rafael Alexandro Vuelvas', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Inicio de Sesión Bloqueado', 'Intento de inicio de sesión fallido para rvuelvas@ucol.mx debido a mantenimiento del sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-05-26 22:12:23', '2026-05-26 22:12:23'),
(67, '2026-05-26 22:12:27', 'warning', 'Advertencia', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Configuración', 'Parámetros del Sistema Actualizados', 'El administrador cambió la configuración del sistema: Modo de Mantenimiento: Desactivado.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:12:27', '2026-05-26 22:12:27'),
(68, '2026-05-26 22:12:32', 'success', 'Éxito', 'Rafael Alexandro Vuelvas', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-05-26 22:12:32', '2026-05-26 22:12:32'),
(69, '2026-05-26 22:22:22', 'warning', 'Advertencia', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Configuración', 'Parámetros del Sistema Actualizados', 'El administrador cambió la configuración del sistema: Modo de Mantenimiento: Activado.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:22:22', '2026-05-26 22:22:22'),
(70, '2026-05-26 22:24:26', 'warning', 'Advertencia', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Configuración', 'Parámetros del Sistema Actualizados', 'El administrador cambió la configuración del sistema: Modo de Mantenimiento: Desactivado.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:24:26', '2026-05-26 22:24:26'),
(71, '2026-05-26 22:24:40', 'warning', 'Advertencia', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Configuración', 'Parámetros del Sistema Actualizados', 'El administrador cambió la configuración del sistema: Modo de Mantenimiento: Activado.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:24:40', '2026-05-26 22:24:40'),
(72, '2026-05-26 22:24:51', 'warning', 'Advertencia', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Configuración', 'Parámetros del Sistema Actualizados', 'El administrador cambió la configuración del sistema: Modo de Mantenimiento: Desactivado.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-26 22:24:51', '2026-05-26 22:24:51'),
(73, '2026-05-27 00:21:58', 'warning', 'Advertencia', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Configuración', 'Parámetros del Sistema Actualizados', 'El administrador cambió la configuración del sistema: Modo de Mantenimiento: Activado.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-27 00:21:58', '2026-05-27 00:21:58'),
(74, '2026-05-27 00:22:09', 'warning', 'Advertencia', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Configuración', 'Parámetros del Sistema Actualizados', 'El administrador cambió la configuración del sistema: Modo de Mantenimiento: Desactivado.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-27 00:22:09', '2026-05-27 00:22:09'),
(75, '2026-05-27 00:22:23', 'info', 'Info', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-27 00:22:23', '2026-05-27 00:22:23'),
(76, '2026-05-27 00:22:34', 'success', 'Éxito', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-27 00:22:34', '2026-05-27 00:22:34'),
(77, '2026-05-27 00:22:55', 'info', 'Info', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-27 00:22:55', '2026-05-27 00:22:55'),
(78, '2026-05-27 00:23:04', 'success', 'Éxito', 'Tech Solutions S.A. de C.V.', 'Empresa', 'empresa@tech.com', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-27 00:23:04', '2026-05-27 00:23:04'),
(79, '2026-05-28 00:59:36', 'success', 'Éxito', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 00:59:36', '2026-05-28 00:59:36'),
(80, '2026-05-28 01:00:02', 'info', 'Info', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 01:00:02', '2026-05-28 01:00:02'),
(81, '2026-05-28 01:00:12', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 01:00:12', '2026-05-28 01:00:12'),
(82, '2026-05-28 01:49:43', 'info', 'Info', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 01:49:43', '2026-05-28 01:49:43'),
(83, '2026-05-28 04:51:40', 'info', 'Info', 'rvuelvas@ucol.mx', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 04:51:40', '2026-05-28 04:51:40'),
(84, '2026-05-28 04:51:48', 'success', 'Éxito', 'admin@ucol.mx', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 04:51:48', '2026-05-28 04:51:48'),
(85, '2026-05-28 04:51:51', 'success', 'Éxito', 'admin@ucol.mx', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 04:51:51', '2026-05-28 04:51:51'),
(86, '2026-05-28 04:51:57', 'success', 'Éxito', 'admin@ucol.mx', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 04:51:57', '2026-05-28 04:51:57'),
(87, '2026-05-28 04:51:59', 'success', 'Éxito', 'admin@ucol.mx', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 04:51:59', '2026-05-28 04:51:59'),
(88, '2026-05-28 04:52:17', 'success', 'Éxito', 'admin@ucol.mx', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 04:52:17', '2026-05-28 04:52:17'),
(89, '2026-05-28 04:52:19', 'success', 'Éxito', 'admin@ucol.mx', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 04:52:19', '2026-05-28 04:52:19'),
(90, '2026-05-28 04:52:21', 'success', 'Éxito', 'admin@ucol.mx', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 04:52:21', '2026-05-28 04:52:21'),
(91, '2026-05-28 04:52:55', 'info', 'Info', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 04:52:55', '2026-05-28 04:52:55'),
(92, '2026-05-28 04:53:02', 'danger', 'Error', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Inicio de Sesión Fallido', 'Intento de inicio de sesión fallido para la cuenta: rvuelvas@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 04:53:02', '2026-05-28 04:53:02'),
(93, '2026-05-28 04:53:06', 'success', 'Éxito', 'Rafael Alexandro Vuelvas', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 04:53:06', '2026-05-28 04:53:06'),
(94, '2026-05-28 05:05:11', 'info', 'Info', 'Rafael Alexandro Vuelvas', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 05:05:11', '2026-05-28 05:05:11'),
(95, '2026-05-28 05:05:19', 'success', 'Éxito', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 05:05:19', '2026-05-28 05:05:19'),
(96, '2026-05-28 05:06:25', 'info', 'Info', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 05:06:25', '2026-05-28 05:06:25'),
(97, '2026-05-28 05:06:39', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 05:06:39', '2026-05-28 05:06:39'),
(98, '2026-05-28 13:32:35', 'success', 'Éxito', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 13:32:35', '2026-05-28 13:32:35'),
(99, '2026-05-28 13:39:19', 'success', 'Éxito', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Usuarios', 'Usuario Creado', 'Se creó el usuario \'Fernando\' con el rol \'Alumno\' y correo \'fbenitez2@ucol.mx\'.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', '{\n    \"correo\": \"fbenitez2@ucol.mx\",\n    \"nombre\": \"Fernando\",\n    \"rol\": \"Alumno\"\n}', '2026-05-28 13:39:19', '2026-05-28 13:39:19'),
(100, '2026-05-28 13:40:28', 'info', 'Info', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 13:40:28', '2026-05-28 13:40:28'),
(101, '2026-05-28 13:41:09', 'danger', 'Error', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Inicio de Sesión Fallido', 'Intento de inicio de sesión fallido para la cuenta: fbenitez2@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 13:41:09', '2026-05-28 13:41:09'),
(102, '2026-05-28 13:41:56', 'success', 'Éxito', 'Fernando', 'Alumno', 'fbenitez2@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 13:41:56', '2026-05-28 13:41:56'),
(103, '2026-05-28 13:42:33', 'info', 'Info', 'Fernando', 'Alumno', 'fbenitez2@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 13:42:33', '2026-05-28 13:42:33'),
(104, '2026-05-28 13:43:50', 'success', 'Éxito', 'Fernando', 'Alumno', 'fbenitez2@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', NULL, '2026-05-28 13:43:50', '2026-05-28 13:43:50'),
(105, '2026-05-28 13:43:55', 'info', 'Info', 'Fernando', 'Alumno', 'fbenitez2@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', NULL, '2026-05-28 13:43:55', '2026-05-28 13:43:55'),
(106, '2026-05-28 13:44:18', 'success', 'Éxito', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', NULL, '2026-05-28 13:44:18', '2026-05-28 13:44:18'),
(107, '2026-05-28 13:49:01', 'info', 'Info', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Usuarios', 'Usuario Modificado', 'Se actualizaron los datos del usuario \'Fernando\' (Alumno) con correo \'fbenitez2@ucol.mx\'.', '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '{\n    \"correo\": \"fbenitez2@ucol.mx\",\n    \"nombre\": \"Fernando\",\n    \"rol\": \"Alumno\"\n}', '2026-05-28 13:49:01', '2026-05-28 13:49:01'),
(108, '2026-05-28 13:50:12', 'warning', 'Advertencia', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Usuarios', 'Usuario Deshabilitado', 'Se cambió el estado del usuario \'fbenitez2@ucol.mx\' a \'Deshabilitado\'.', '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '{\n    \"correo\": \"fbenitez2@ucol.mx\",\n    \"nuevo_estado\": \"Deshabilitado\"\n}', '2026-05-28 13:50:12', '2026-05-28 13:50:12'),
(109, '2026-05-28 13:50:38', 'warning', 'Advertencia', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Usuarios', 'Usuario Habilitado', 'Se cambió el estado del usuario \'fbenitez2@ucol.mx\' a \'Habilitado\'.', '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '{\n    \"correo\": \"fbenitez2@ucol.mx\",\n    \"nuevo_estado\": \"Habilitado\"\n}', '2026-05-28 13:50:38', '2026-05-28 13:50:38'),
(110, '2026-05-28 15:00:19', 'info', 'Info', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 15:00:19', '2026-05-28 15:00:19'),
(111, '2026-05-28 15:00:32', 'success', 'Éxito', 'Rafael Alexandro Vuelvas', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 15:00:32', '2026-05-28 15:00:32'),
(112, '2026-05-28 15:36:08', 'info', 'Info', 'Rafael Alexandro Vuelvas', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 15:36:08', '2026-05-28 15:36:08'),
(113, '2026-05-28 15:36:15', 'success', 'Éxito', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 15:36:15', '2026-05-28 15:36:15'),
(114, '2026-05-28 15:42:26', 'warning', 'Advertencia', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Configuración', 'Parámetros del Sistema Actualizados', 'El administrador cambió la configuración del sistema: Modo de Mantenimiento: Activado.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 15:42:26', '2026-05-28 15:42:26'),
(115, '2026-05-28 15:42:43', 'warning', 'Advertencia', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Configuración', 'Parámetros del Sistema Actualizados', 'El administrador cambió la configuración del sistema: Modo de Mantenimiento: Desactivado.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 15:42:43', '2026-05-28 15:42:43'),
(116, '2026-05-28 19:15:32', 'success', 'Éxito', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 19:15:32', '2026-05-28 19:15:32'),
(117, '2026-05-28 19:22:02', 'info', 'Info', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 19:22:02', '2026-05-28 19:22:02');
INSERT INTO `bitacora` (`id`, `timestamp`, `level`, `level_name`, `user`, `user_role`, `user_email`, `module`, `action`, `description`, `ip`, `user_agent`, `payload`, `created_at`, `updated_at`) VALUES
(118, '2026-05-28 19:22:12', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 19:22:12', '2026-05-28 19:22:12'),
(119, '2026-05-28 19:40:25', 'info', 'Info', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 19:40:25', '2026-05-28 19:40:25'),
(120, '2026-05-28 19:40:31', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 19:40:31', '2026-05-28 19:40:31'),
(121, '2026-05-28 19:46:11', 'info', 'Info', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 19:46:11', '2026-05-28 19:46:11'),
(122, '2026-05-28 19:46:18', 'success', 'Éxito', 'Rafael Alexandro Vuelvas', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 19:46:18', '2026-05-28 19:46:18'),
(123, '2026-05-28 19:56:29', 'info', 'Info', 'Rafael Alexandro Vuelvas', 'Alumno', 'rvuelvas@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 19:56:29', '2026-05-28 19:56:29'),
(124, '2026-05-28 19:56:38', 'success', 'Éxito', 'Tech Solutions S.A. de C.V.', 'Empresa', 'empresa@tech.com', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-05-28 19:56:38', '2026-05-28 19:56:38'),
(125, '2026-06-09 04:38:50', 'success', 'Éxito', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-06-09 04:38:50', '2026-06-09 04:38:50'),
(126, '2026-06-09 05:08:17', 'info', 'Info', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Cierre de Sesión', 'El usuario cerró su sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-06-09 05:08:17', '2026-06-09 05:08:17'),
(127, '2026-06-09 05:08:25', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-06-09 05:08:25', '2026-06-09 05:08:25'),
(128, '2026-06-09 05:13:39', 'danger', 'Error', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Inicio de Sesión Fallido', 'Intento de inicio de sesión fallido para la cuenta: alumno@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 05:13:39', '2026-06-09 05:13:39'),
(129, '2026-06-09 05:13:43', 'danger', 'Error', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Inicio de Sesión Fallido', 'Intento de inicio de sesión fallido para la cuenta: alumno@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 05:13:43', '2026-06-09 05:13:43'),
(130, '2026-06-09 05:13:51', 'danger', 'Error', 'Sistema', 'Sistema', 'system@ucol.mx', 'Autenticación', 'Inicio de Sesión Fallido', 'Intento de inicio de sesión fallido para la cuenta: admin@ucol.mx.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 05:13:51', '2026-06-09 05:13:51'),
(131, '2026-06-09 05:13:56', 'success', 'Éxito', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 05:13:56', '2026-06-09 05:13:56'),
(132, '2026-06-09 05:52:07', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Instituciones', 'Importación Masiva', 'Se registraron exitosamente 2 instituciones mediante importación masiva.', '127.0.0.1', 'Symfony', '{\n    \"cantidad_importada\": 2\n}', '2026-06-09 05:52:07', '2026-06-09 05:52:07'),
(133, '2026-06-09 05:58:09', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Instituciones', 'Importación Masiva', 'Se registraron exitosamente 2 instituciones mediante importación masiva.', '127.0.0.1', 'Symfony', '{\n    \"cantidad_importada\": 2\n}', '2026-06-09 05:58:09', '2026-06-09 05:58:09'),
(134, '2026-06-09 06:09:56', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Instituciones', 'Importación Masiva', 'Se registraron exitosamente 2 instituciones mediante importación masiva.', '127.0.0.1', 'Symfony', '{\n    \"cantidad_importada\": 2\n}', '2026-06-09 06:09:56', '2026-06-09 06:09:56'),
(135, '2026-06-09 06:10:07', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Instituciones', 'Importación Masiva', 'Se registraron exitosamente 2 instituciones mediante importación masiva.', '127.0.0.1', 'Symfony', '{\n    \"cantidad_importada\": 2\n}', '2026-06-09 06:10:07', '2026-06-09 06:10:07'),
(136, '2026-06-09 06:10:08', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Instituciones', 'Importación Masiva', 'Se registraron exitosamente 2 instituciones mediante importación masiva.', '127.0.0.1', 'Symfony', '{\n    \"cantidad_importada\": 2\n}', '2026-06-09 06:10:08', '2026-06-09 06:10:08'),
(137, '2026-06-09 06:27:17', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Instituciones', 'Importación Masiva', 'Se registraron exitosamente 2 instituciones mediante importación masiva.', '127.0.0.1', 'Symfony', '{\n    \"cantidad_importada\": 2\n}', '2026-06-09 06:27:17', '2026-06-09 06:27:17'),
(138, '2026-06-09 06:27:18', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Instituciones', 'Importación Masiva', 'Se registraron exitosamente 2 instituciones mediante importación masiva.', '127.0.0.1', 'Symfony', '{\n    \"cantidad_importada\": 2\n}', '2026-06-09 06:27:18', '2026-06-09 06:27:18'),
(139, '2026-06-09 06:30:01', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Instituciones', 'Importación Masiva', 'Se registraron exitosamente 5 instituciones mediante importación masiva.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', '{\n    \"cantidad_importada\": 5\n}', '2026-06-09 06:30:01', '2026-06-09 06:30:01'),
(140, '2026-06-09 18:10:39', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', NULL, '2026-06-09 18:10:39', '2026-06-09 18:10:39'),
(141, '2026-06-09 18:12:03', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Instituciones', 'Importación Masiva', 'Se registraron exitosamente 5 instituciones mediante importación masiva.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', '{\n    \"cantidad_importada\": 5\n}', '2026-06-09 18:12:03', '2026-06-09 18:12:03'),
(142, '2026-06-09 18:17:42', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Instituciones', 'Importación Masiva', 'Se registraron exitosamente 5 instituciones mediante importación masiva. Omitidas: 0.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', '{\n    \"cantidad_importada\": 5,\n    \"cantidad_omitida\": 0\n}', '2026-06-09 18:17:42', '2026-06-09 18:17:42'),
(143, '2026-06-09 18:17:51', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Instituciones', 'Importación Masiva', 'Se registraron exitosamente 0 instituciones mediante importación masiva. Omitidas: 5.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', '{\n    \"cantidad_importada\": 0,\n    \"cantidad_omitida\": 5\n}', '2026-06-09 18:17:51', '2026-06-09 18:17:51'),
(144, '2026-06-09 18:18:51', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Instituciones', 'Importación Masiva', 'Se registraron exitosamente 1 instituciones mediante importación masiva. Omitidas: 5.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 OPR/131.0.0.0 (Edition std-2)', '{\n    \"cantidad_importada\": 1,\n    \"cantidad_omitida\": 5\n}', '2026-06-09 18:18:51', '2026-06-09 18:18:51'),
(145, '2026-06-16 18:08:24', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0 (Edition std-2)', NULL, '2026-06-16 18:08:24', '2026-06-16 18:08:24'),
(146, '2026-06-16 18:33:05', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Instituciones', 'Importación Masiva', 'Se registraron exitosamente 6 instituciones mediante importación masiva. Omitidas: 0.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0 (Edition std-2)', '{\n    \"cantidad_importada\": 6,\n    \"cantidad_omitida\": 0\n}', '2026-06-16 18:33:05', '2026-06-16 18:33:05'),
(147, '2026-06-16 19:22:33', 'success', 'Éxito', 'Administrador General', 'Administrador', 'admin@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-16 19:22:33', '2026-06-16 19:22:33'),
(148, '2026-06-17 04:43:32', 'success', 'Éxito', 'Coordinador de Prácticas Profesionales', 'Coordinador', 'coordinador@ucol.mx', 'Autenticación', 'Inicio de Sesión', 'El usuario inició sesión en el sistema.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0 (Edition std-2)', NULL, '2026-06-17 04:43:32', '2026-06-17 04:43:32');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `convenios`
--

CREATE TABLE `convenios` (
  `id` int(10) UNSIGNED NOT NULL,
  `ur_id` int(10) UNSIGNED NOT NULL,
  `codigo_convenio` varchar(100) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_termino` date NOT NULL,
  `estatus` enum('activo','inactivo','pendiente') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documentos`
--

CREATE TABLE `documentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `solicitud_id` int(10) UNSIGNED NOT NULL,
  `ur_id` int(10) UNSIGNED NOT NULL,
  `nombre_doc` varchar(255) NOT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `fecha_carga` date NOT NULL DEFAULT curdate(),
  `estatus` enum('pendiente','aprobado','rechazado') NOT NULL DEFAULT 'pendiente',
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `nombre_completo` varchar(255) NOT NULL,
  `primer_nombre` varchar(150) DEFAULT NULL,
  `apellidos` varchar(150) DEFAULT NULL,
  `matricula` varchar(50) NOT NULL,
  `carrera` varchar(150) NOT NULL,
  `semestre` tinyint(3) UNSIGNED NOT NULL,
  `grupo` varchar(20) NOT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `activo_practica` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `estudiantes`
--

INSERT INTO `estudiantes` (`id`, `usuario_id`, `nombre_completo`, `primer_nombre`, `apellidos`, `matricula`, `carrera`, `semestre`, `grupo`, `direccion`, `telefono`, `activo_practica`) VALUES
(1, 3, 'Juan Pérez Alumno', NULL, NULL, '20191234', 'Ingeniería de Software', 8, 'A', NULL, NULL, 0),
(34, 47, 'Rafael Alexandro Vuelvas', NULL, NULL, '20205120', 'Ingeniería de Software', 6, 'E', NULL, NULL, 0),
(35, 48, 'Fernando', NULL, NULL, '20242526', 'Ingeniería de Software', 4, 'D', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `horas`
--

CREATE TABLE `horas` (
  `id` int(10) UNSIGNED NOT NULL,
  `solicitud_id` int(10) UNSIGNED NOT NULL,
  `fecha_registro` date NOT NULL,
  `cantidad_horas` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_14_011444_create_alumnos_table', 1),
(5, '2026_05_14_011445_create_coordinadors_table', 1),
(6, '2026_05_14_011445_create_empresas_table', 1),
(7, '2026_05_14_011446_create_administradors_table', 1),
(8, '2026_05_25_165738_create_bitacora_table', 2),
(9, '2026_05_19_000000_add_contacto_to_estudiantes', 3),
(10, '2026_05_27_000000_add_nombre_fields_to_estudiantes', 3),
(11, '2026_05_27_183624_create_proyectos_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal`
--

CREATE TABLE `personal` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `nombre_completo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal`
--

INSERT INTO `personal` (`id`, `usuario_id`, `nombre_completo`) VALUES
(1, 1, 'Administrador General'),
(2, 2, 'Coordinador de Prácticas Profesionales');

-- --------------------------------------------------------

--
-- Table structure for table `proyectos`
--

CREATE TABLE `proyectos` (
  `id` int(10) UNSIGNED NOT NULL,
  `unidad_receptora_id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `objetivo` text NOT NULL,
  `justificacion` text NOT NULL,
  `actividades` text NOT NULL,
  `impacto_social` text NOT NULL,
  `tipo_proyecto` varchar(150) NOT NULL,
  `tipo_modalidad` varchar(150) NOT NULL,
  `plan` varchar(50) NOT NULL,
  `ciclo_escolar` varchar(100) NOT NULL,
  `cupos_totales` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `cupos_ocupados` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `publico_internet` enum('SI','NO') NOT NULL DEFAULT 'SI',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre_rol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Personal'),
(3, 'Estudiante'),
(4, 'Empresa');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3pBBQyfs3HiEWX7aO3BeuC4NT0KFlcqYDCISG8my', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0 (Edition std-2)', 'eyJfdG9rZW4iOiJvMlV3eTN1cjBqb0VmWjBzVkdpd1plQWNMOUV3amJpNUxrSEtwUmh1IiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2Nvb3JkaW5hZG9yXC9wcm95ZWN0b3MifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9jb29yZGluYWRvclwvZGFzaGJvYXJkIiwicm91dGUiOiJjb29yZGluYWRvci5kYXNoYm9hcmQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6Mn0=', 1781671494),
('KEBeJbjj2hObN72s1pTMuJq6KSeBsemRkiHamLqS', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJkcXN1a1F4VktWbXh5Q1pPaVc5VVV1VHBpUlZJNlNYV252RkVlMGlkIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hZG1pblwvYml0YWNvcmE/ZGF0ZT0mbGV2ZWw9Jm1vZHVsZT0mc2VhcmNoPSZ2aWV3PXRhYmxlIiwicm91dGUiOiJhZG1pbi5iaXRhY29yYSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1781637935),
('sC1ABXOWDOmgEm5DHBZB1Awj7EWvFtJ5OybXq6wM', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0 (Edition std-2)', 'eyJfdG9rZW4iOiJOWEtzdTgxbWx2b0hUbWx1eE1TWVNMbjZnV2lPWjMzTVF3eXBSU3U1IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9jb29yZGluYWRvclwvcHJveWVjdG9zIiwicm91dGUiOiJjb29yZGluYWRvci5wcm95ZWN0b3MifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6Mn0=', 1781638878);

-- --------------------------------------------------------

--
-- Table structure for table `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` int(10) UNSIGNED NOT NULL,
  `estudiante_id` int(10) UNSIGNED NOT NULL,
  `ur_id` int(10) UNSIGNED NOT NULL,
  `responsable` varchar(255) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estatus` enum('pendiente','aprobada','rechazada','en_proceso','finalizada') NOT NULL DEFAULT 'pendiente',
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unidades_receptoras`
--

CREATE TABLE `unidades_receptoras` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `nombre_empresa` varchar(255) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `tipo_persona` varchar(50) NOT NULL COMMENT 'Física o Moral',
  `sistema` varchar(50) NOT NULL,
  `sector` varchar(50) NOT NULL,
  `unidad_receptora` varchar(100) NOT NULL,
  `titular` varchar(100) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `colonia` varchar(50) NOT NULL,
  `cp` int(5) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `municipio` varchar(100) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `convenio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unidades_receptoras`
--

INSERT INTO `unidades_receptoras` (`id`, `usuario_id`, `nombre_empresa`, `direccion`, `tipo_persona`, `sistema`, `sector`, `unidad_receptora`, `titular`, `cargo`, `colonia`, `cp`, `estado`, `municipio`, `telefono`, `convenio`) VALUES
(4, 5, 'Tech Solutions S.A. de C.V.', 'Av. Tecnológico 123, Col. Centro Manzanillo', 'Moral', 'ESTATAL', 'publico', 'Facultad de Ingenieria Electromecanica', 'Mtro. Juan', 'Director', 'El naranjo', 28989, 'Colima', 'Manzanillo', '3122337959', 'Con Convenio'),
(36, 60, 'Universidad de Colima', 'Av. Universidad 333', 'Moral', 'ESTATAL', 'PÚBLICO', 'Facultad de Telemática', 'Mtro. Gerardo Alcaraz', 'Director', 'Las Víboras', 28040, 'Colima', 'Manzanillo', '3123161100', 'Con Convenio'),
(37, 60, 'SECRETARIA DE EDUCACIÓN. DELEGACIÓN FEDERAL', 'SECTOR 7 #100', 'Moral', 'FEDERAL', 'EDUCATIVO EXTERNO', 'JARDÍN DE NIÑOS CUITLÁHUAC TM', 'LEP. MARIELA ALEJANDRA FERREYRA RAMÍREZ', 'DIRECTORA', 'SAN PEDRITO', 28259, 'COLIMA', 'MANZANILLO', '3143321369', 'Con Convenio'),
(38, 61, 'Tech Solutions S.A. de C.V.', 'Av. Constitución 450', 'Moral', 'PRIVADA', 'PRIVADO', 'Departamento de Sistemas', 'Ing. Roberto Gomez', 'Gerente TI', 'Lomas de Circunvalación', 28010, 'Colima', 'Manzanillo', '3123154400', 'Con Convenio'),
(39, 61, 'ISSSTE', 'Av. Parotas, Rosa Morada S/N. Barrio I', 'Moral', 'FEDERAL', 'PÚBLICO', 'HOSPITAL ISSSTE MANZANILLO', 'DR. FERNANDO PARRALES ÁNGELES', 'DIRECTOR GENERAL DE CLÍNICA HOSPITAL ISSSTE MANZANILLO', 'Valle De Las Garzas', 28219, 'Colima', 'Manzanillo', '3143365121', 'Con Convenio'),
(40, 62, 'SECRETARIA DE EDUCACIÓN. DELEGACIÓN FEDERAL', 'RIO DEL FUERTE #100', 'Moral', 'FEDERAL', 'EDUCATIVO EXTERNO', 'BACHILLERATO EMSAD NO. 4 “EMILIANO ZAPATA”', 'ING. OSCAR MAURICIO FARIAS GOMEZ', 'SUBDIRECTOR DEL PLANTEL', 'LA CENTRAL', 28868, 'COLIMA', 'MANZANILLO', '3122106384', 'Con Convenio'),
(41, 63, 'SECRETARIA DE EDUCACIÓN. DELEGACIÓN FEDERAL', 'Calle Aguila 122 Fracc. Paraíso', 'Moral', 'FEDERAL', 'EDUCATIVO EXTERNO', 'CENTRO DE CAPACITACIÓN PARA EL TRABAJO INDUSTRIAL NO. 34', 'GLADYS PATRICIA JIMÉNEZ ZEPEDA', 'DIRECTORA', 'Salagua', 28869, 'Colima', 'Manzanillo', '314 1218445', 'Con Convenio');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `rol_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `correo`, `contraseña`, `activo`, `rol_id`) VALUES
(1, 'admin@ucol.mx', '$2y$12$uQZVFfo0wAWgFcIK5gDusu0W1GBNq.lb6jyw//ygqNFoGZzTtGUoe', 1, 1),
(2, 'coordinador@ucol.mx', '$2y$12$nD/o.O4bptqTBby1KCqCyOorkqXz8aQ5WuqlALMk5.AAoaD2moY7S', 1, 2),
(3, 'alumno@ucol.mx', '$2y$12$cm5JoZ341msAnEIhlv5Ul.WUo0YtE0k9UqJfJWKrnZ8QcMHxNq.ni', 1, 3),
(5, 'empresa@tech.com', '$2y$12$hkvQRP.AXOiWektGtN426.cnXOZxpodLvBYGuEJnOVD2uKNC5TRLe', 1, 4),
(47, 'rvuelvas@ucol.mx', '$2y$12$xXY4Rt.Ge29Xo.RF4guDdurJ8M6ogEoFZ6Rqatt3UvqElb6uPajxa', 1, 3),
(48, 'fbenitez2@ucol.mx', '$2y$12$5xDpR9xdRUjY3N7lMLRcQ.m/OPYPZ5/PP.klugq3lEeRrOZowU8.q', 1, 3),
(60, 'moffa543@gmail.com', '$2y$12$JB52kx6oEaErSfV4d0YNPO2ZCP43eyianqHo1wXXd/CpweuKQF80i', 1, 4),
(61, 'uchihamadara6949@gmail.com', '$2y$12$7yLAd4McdmgZUd//vTYDN.DA6B.nyC6VugdKEENXlSz3g.oZC3d2y', 1, 4),
(62, 'rafaelalexandro6949@gmail.com', '$2y$12$L1yW6ur7mcTfHrYsHCYDAukrzQuqKfIXjuj0Gcf5EYFaB2Ct.VfXu', 1, 4),
(63, 'rafaelalex6949@gmail.com', '$2y$12$es3dpSTyyIFtYUPPgoLCYeSAnKVVlZgyZ40obUCY.rGg.wO2PN40G', 1, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `convenios`
--
ALTER TABLE `convenios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_convenio` (`codigo_convenio`),
  ADD KEY `fk_convenios_ur` (`ur_id`);

--
-- Indexes for table `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_documentos_solicitud` (`solicitud_id`),
  ADD KEY `fk_documentos_ur` (`ur_id`);

--
-- Indexes for table `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matricula` (`matricula`),
  ADD KEY `fk_estudiantes_usuario` (`usuario_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `horas`
--
ALTER TABLE `horas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_horas_solicitud` (`solicitud_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_personal_usuario` (`usuario_id`);

--
-- Indexes for table `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proyectos_unidad_receptora_id_foreign` (`unidad_receptora_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_solicitudes_estudiante` (`estudiante_id`),
  ADD KEY `fk_solicitudes_ur` (`ur_id`);

--
-- Indexes for table `unidades_receptoras`
--
ALTER TABLE `unidades_receptoras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ur_usuario` (`usuario_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_usuarios_rol` (`rol_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `convenios`
--
ALTER TABLE `convenios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `horas`
--
ALTER TABLE `horas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unidades_receptoras`
--
ALTER TABLE `unidades_receptoras`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `convenios`
--
ALTER TABLE `convenios`
  ADD CONSTRAINT `fk_convenios_ur` FOREIGN KEY (`ur_id`) REFERENCES `unidades_receptoras` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `fk_documentos_solicitud` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_documentos_ur` FOREIGN KEY (`ur_id`) REFERENCES `unidades_receptoras` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `fk_estudiantes_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `horas`
--
ALTER TABLE `horas`
  ADD CONSTRAINT `fk_horas_solicitud` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `fk_personal_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_unidad_receptora_id_foreign` FOREIGN KEY (`unidad_receptora_id`) REFERENCES `unidades_receptoras` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `fk_solicitudes_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_solicitudes_ur` FOREIGN KEY (`ur_id`) REFERENCES `unidades_receptoras` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `unidades_receptoras`
--
ALTER TABLE `unidades_receptoras`
  ADD CONSTRAINT `fk_ur_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
