-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-06-2026 a las 07:29:08
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `burnout_borrador`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_profile_id` bigint(20) UNSIGNED NOT NULL,
  `professional_id` bigint(20) UNSIGNED NOT NULL,
  `scheduled_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `duration_minutes` int(11) DEFAULT 30,
  `status` enum('pendiente','confirmado','completado','cancelado','no_asistio') DEFAULT 'pendiente',
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `appointments`
--

INSERT INTO `appointments` (`id`, `student_profile_id`, `professional_id`, `scheduled_at`, `duration_minutes`, `status`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-11-25 15:00:00', 30, 'pendiente', 'Primera sesión de evaluación.', 11, '2025-11-21 20:03:44', NULL),
(2, 2, 1, '2025-11-25 15:45:00', 30, 'pendiente', 'Sesión de seguimiento de estrés.', 11, '2025-11-21 20:03:44', NULL),
(3, 3, 2, '2025-11-26 14:00:00', 45, 'confirmado', 'Consulta psiquiátrica inicial.', 12, '2025-11-21 20:03:44', NULL),
(4, 4, 2, '2025-11-26 15:00:00', 45, 'pendiente', 'Revisión de tratamiento y medicación.', 12, '2025-11-21 20:03:44', NULL),
(5, 5, 3, '2025-11-27 16:00:00', 30, 'pendiente', 'Terapia ocupacional para manejo de ansiedad.', 13, '2025-11-21 20:03:44', NULL),
(6, 6, 3, '2025-11-27 16:45:00', 30, 'pendiente', 'Seguimiento de técnicas de relajación.', 13, '2025-11-21 20:03:44', NULL),
(7, 7, 4, '2025-11-28 13:30:00', 30, 'pendiente', 'Sesión inicial de psicología clínica.', 14, '2025-11-21 20:03:44', NULL),
(8, 1, 5, '2025-11-28 14:15:00', 60, 'pendiente', 'Terapia multidisciplinaria.', 15, '2025-11-21 20:03:44', NULL),
(9, 2, 5, '2025-11-28 15:30:00', 60, 'pendiente', 'Sesión de apoyo emocional.', 15, '2025-11-21 20:03:44', NULL),
(10, 3, 4, '2025-11-29 15:00:00', 30, 'pendiente', 'Seguimiento de técnicas cognitivas.', 14, '2025-11-21 20:03:44', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `table_name` varchar(100) DEFAULT NULL,
  `record_id` varchar(100) DEFAULT NULL,
  `old_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_data`)),
  `new_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_data`)),
  `ip_address` varchar(50) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chatbot_alerts`
--

CREATE TABLE `chatbot_alerts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chatbot_interaction_id` bigint(20) UNSIGNED NOT NULL,
  `student_profile_id` bigint(20) UNSIGNED DEFAULT NULL,
  `alert_type` enum('alto_estres','sin_reporte','riesgo_palabra_clave','solicitud_manual','otro') NOT NULL,
  `severity` enum('bajo','medio','alto','critico') NOT NULL DEFAULT 'medio',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `resolved_at` timestamp NULL DEFAULT NULL,
  `resolved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chatbot_alerts`
--

INSERT INTO `chatbot_alerts` (`id`, `chatbot_interaction_id`, `student_profile_id`, `alert_type`, `severity`, `created_at`, `resolved_at`, `resolved_by`, `notes`) VALUES
(1, 2, 1, 'riesgo_palabra_clave', 'medio', '2025-11-21 19:58:29', NULL, NULL, 'Usuario expresa que no puede más.'),
(2, 3, 1, 'alto_estres', 'alto', '2025-11-21 19:58:29', NULL, NULL, 'Frustración y agotamiento detectados.'),
(3, 5, 2, 'alto_estres', 'alto', '2025-11-21 19:58:29', NULL, NULL, 'Estrés por exámenes.'),
(4, 8, 3, 'riesgo_palabra_clave', 'medio', '2025-11-21 19:58:29', NULL, NULL, 'Usuario menciona estar agotado.'),
(5, 9, 3, 'alto_estres', 'alto', '2025-11-21 19:58:29', NULL, NULL, 'No sabe cómo seguir, riesgo alto de estrés.'),
(6, 11, 4, 'alto_estres', 'alto', '2025-11-21 19:58:29', NULL, NULL, 'Usuario muy estresada.'),
(7, 12, 4, 'riesgo_palabra_clave', 'medio', '2025-11-21 19:58:29', NULL, NULL, 'No puede dormir, palabra clave de alerta.'),
(8, 17, 6, 'riesgo_palabra_clave', 'medio', '2025-11-21 19:59:30', NULL, NULL, 'Se siente abrumado.'),
(9, 18, 6, 'alto_estres', 'alto', '2025-11-21 19:59:30', NULL, NULL, 'No sabe qué hacer, riesgo alto de estrés.'),
(10, 20, 7, 'riesgo_palabra_clave', 'medio', '2025-11-21 19:59:30', NULL, NULL, 'Usuario menciona estar cansado.'),
(11, 111, NULL, 'alto_estres', 'alto', '2025-11-21 22:22:58', NULL, NULL, NULL),
(12, 112, NULL, 'alto_estres', 'alto', '2025-11-21 22:26:45', NULL, NULL, NULL),
(13, 115, NULL, 'alto_estres', 'alto', '2025-11-29 18:19:24', NULL, NULL, NULL),
(14, 116, NULL, 'alto_estres', 'alto', '2025-11-29 18:21:41', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chatbot_interactions`
--

CREATE TABLE `chatbot_interactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(191) DEFAULT NULL,
  `input_text` text DEFAULT NULL,
  `input_metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`input_metadata`)),
  `response_text` text DEFAULT NULL,
  `response_metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`response_metadata`)),
  `intent` varchar(200) DEFAULT NULL,
  `sentiment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sentiment`)),
  `detected_risk` tinyint(1) DEFAULT 0,
  `detected_keywords` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`detected_keywords`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chatbot_interactions`
--

INSERT INTO `chatbot_interactions` (`id`, `user_id`, `session_id`, `input_text`, `input_metadata`, `response_text`, `response_metadata`, `intent`, `sentiment`, `detected_risk`, `detected_keywords`, `created_at`, `updated_at`) VALUES
(1, 1, 'session-1', 'Hola, quien eres?', '{\"source\": \"fastapi\"}', 'Hola, soy Laiso. Me alegra que estés hablando conmigo.', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-11-21 19:58:29', NULL),
(2, 1, 'session-1', 'me siento mal, siento que ya no puedo mas', '{\"source\": \"fastapi\"}', 'Lo siento mucho escucharte. ¿En qué sentido te sientes así?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"tristeza\", \"sentiment\": \"negativo\"}', 1, '[\"mal\",\"no puedo\"]', '2025-11-21 19:58:29', NULL),
(3, 1, 'session-1', 'no puedo más', '{\"source\": \"fastapi\"}', 'Puedo sentir la frustración y el agotamiento que expresas.', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 1, '[\"no puedo\"]', '2025-11-21 19:58:29', NULL),
(4, 2, 'session-2', 'Buenos días', '{\"source\": \"fastapi\"}', 'Buenos días, ¿cómo te sientes hoy?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-11-21 19:58:29', NULL),
(5, 2, 'session-2', 'Estoy un poco estresado por los exámenes', '{\"source\": \"fastapi\"}', 'Entiendo. ¿Quieres que te dé algunos consejos para manejar el estrés?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"tristeza\", \"sentiment\": \"negativo\"}', 1, '[\"estresado\",\"exámenes\"]', '2025-11-21 19:58:29', NULL),
(6, 2, 'session-2', 'Sí, por favor', '{\"source\": \"fastapi\"}', 'Perfecto, podemos practicar técnicas de respiración y planificación de estudio.', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-11-21 19:58:29', NULL),
(7, 3, 'session-3', 'Hola', '{\"source\": \"fastapi\"}', 'Hola, ¿cómo te sientes hoy?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-11-21 19:58:29', NULL),
(8, 3, 'session-3', 'Estoy agotado con las prácticas', '{\"source\": \"fastapi\"}', 'Entiendo, parece que necesitas un descanso. ¿Quieres hablar de ello?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"tristeza\", \"sentiment\": \"negativo\"}', 1, '[\"agotado\",\"prácticas\"]', '2025-11-21 19:58:29', NULL),
(9, 3, 'session-3', 'No sé cómo seguir', '{\"source\": \"fastapi\"}', 'Es normal sentirse así a veces, no estás solo.', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"tristeza\", \"sentiment\": \"negativo\"}', 1, '[\"no sé\",\"seguir\"]', '2025-11-21 19:58:29', NULL),
(10, 4, 'session-4', 'Hola, necesito ayuda', '{\"source\": \"fastapi\"}', 'Claro, ¿qué te preocupa?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-11-21 19:58:29', NULL),
(11, 4, 'session-4', 'Estoy muy estresada', '{\"source\": \"fastapi\"}', 'Lo siento, hablemos sobre tu estrés y posibles soluciones.', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"tristeza\", \"sentiment\": \"negativo\"}', 1, '[\"estresada\"]', '2025-11-21 19:58:29', NULL),
(12, 4, 'session-4', 'No puedo dormir', '{\"source\": \"fastapi\"}', 'Eso suena difícil. Podemos hablar sobre técnicas de relajación.', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"tristeza\", \"sentiment\": \"negativo\"}', 1, '[\"no puedo dormir\"]', '2025-11-21 19:58:29', NULL),
(13, 5, 'session-5', 'Hola', '{\"source\": \"fastapi\"}', 'Hola, ¿cómo estás hoy?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-11-21 19:58:29', NULL),
(14, 5, 'session-5', 'Me siento bien', '{\"source\": \"fastapi\"}', 'Me alegra escuchar eso. ¿Quieres contarme algo más?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"alegría\", \"sentiment\": \"positivo\"}', 0, '[]', '2025-11-21 19:58:29', NULL),
(15, 5, 'session-5', 'Solo un poco cansado', '{\"source\": \"fastapi\"}', 'Entiendo, asegúrate de descansar lo suficiente.', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-11-21 19:58:29', NULL),
(16, 6, 'session-6', 'Hola', '{\"source\": \"fastapi\"}', 'Hola, ¿cómo estás?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-11-21 19:59:30', NULL),
(17, 6, 'session-6', 'Me siento abrumado', '{\"source\": \"fastapi\"}', 'Lo siento, hablemos sobre ello.', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"tristeza\", \"sentiment\": \"negativo\"}', 1, '[\"abrumado\"]', '2025-11-21 19:59:30', NULL),
(18, 6, 'session-6', 'No sé que hacer', '{\"source\": \"fastapi\"}', 'Vamos a encontrar opciones juntos.', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"tristeza\", \"sentiment\": \"negativo\"}', 1, '[\"no sé\"]', '2025-11-21 19:59:30', NULL),
(19, 7, 'session-7', 'Hola', '{\"source\": \"fastapi\"}', 'Hola, ¿cómo te sientes hoy?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-11-21 19:59:30', NULL),
(20, 7, 'session-7', 'Estoy muy cansado', '{\"source\": \"fastapi\"}', 'Parece que necesitas un descanso.', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"tristeza\", \"sentiment\": \"negativo\"}', 1, '[\"cansado\"]', '2025-11-21 19:59:30', NULL),
(21, 7, 'session-7', 'Gracias por escucharme', '{\"source\": \"fastapi\"}', 'Siempre estoy aquí para escucharte.', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"alegría\", \"sentiment\": \"positivo\"}', 0, '[]', '2025-11-21 19:59:30', NULL),
(110, 47, '54b27f46-c954-4dd5-9ca2-388b561b79d4', 'Hola, quien eres?', '{\"source\": \"fastapi\"}', 'Hola, estoy aquí para ayudarte. Soy Laiso, tu asistente psicológico. ¿Qué te trae a hablar hoy?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-11-21 22:19:24', NULL),
(111, 47, '54b27f46-c954-4dd5-9ca2-388b561b79d4', 'me llamo franz, y estoy estresado con la universidad', '{\"source\": \"fastapi\"}', 'Hola Franz, gracias por compartir tus sentimientos contigo. ¿Puedes decirme un poco más sobre lo que te está estresando en la universidad? ¿Es algo relacionado con tus estudios o con otra cosa?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"estres\", \"sentiment\": \"negativo\"}', 1, '[\"estres\"]', '2025-11-21 22:22:58', NULL),
(112, 47, '54b27f46-c954-4dd5-9ca2-388b561b79d4', 'Siento que no puedo más, estoy totalmente agotado y desesperado.', '{\"source\": \"fastapi\"}', 'Franz, entiendo que estás en un punto muy difícil. ¿Puedes decirme qué te hace sentir como si no puedas más? ¿Hay algo específico que te está abrumando o es más una sensación general de agotamiento?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"negativo\"}', 1, '[\"agotamiento\"]', '2025-11-21 22:26:45', NULL),
(113, NULL, '8619af9c-66f8-4127-a61a-581fb3956fa5', 'Hola, quien eres?', '{\"source\": \"fastapi\"}', 'Hola. Soy Laiso. ¿Cómo puedo ayudarte hoy?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-11-29 18:13:18', NULL),
(114, NULL, '8619af9c-66f8-4127-a61a-581fb3956fa5', 'Hola, mi nombre es franz', '{\"source\": \"fastapi\"}', 'Hola Franz, gracias por confiar en mí. ¿En qué puedo ayudarte hoy?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-11-29 18:17:13', NULL),
(115, NULL, '8619af9c-66f8-4127-a61a-581fb3956fa5', 'Me siento cansado.', '{\"source\": \"fastapi\"}', 'Franz, me duele saber que te sientes así. ¿Dónde lo notaste por primera vez?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 1, '[\"agotamiento\"]', '2025-11-29 18:19:24', NULL),
(116, NULL, '8619af9c-66f8-4127-a61a-581fb3956fa5', 'Siento que no puedo más, estoy totalmente agotado y desesperado.', '{\"source\": \"fastapi\"}', 'Franz, es terrible verte así. ¿Quieres hablar un poco más sobre lo que te está haciendo sentir así? ¿Es algo que ha estado sucediendo durante mucho tiempo o fue un golpe reciente?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"negativo\"}', 1, '[\"agotamiento\"]', '2025-11-29 18:21:41', NULL),
(117, NULL, '8619af9c-66f8-4127-a61a-581fb3956fa5', 'tengo ganas de asesinar a otros estudiantes', '{\"source\": \"fastapi\"}', 'Franz, es terrible escuchar eso. Parece que estás experimentando un colapso emocional. ¿Hay algo específico que te está causando esto? ¿Es posible que alguien en particular o una situación específica sea el causa de tu agotamiento emocional?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-11-29 18:28:01', NULL),
(118, NULL, 'dec6e31b-b083-4394-9562-dbcb9afe33c6', 'Hola', '{\"source\": \"fastapi\"}', 'Hola Kevin, ¿cómo estás después de esos resultados del ítem \"Creo que con mi trabajo estoy influyendo positivamente en la vida de mis compañeros/as\"?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-12-11 05:28:48', NULL),
(119, NULL, '9563a47f-e301-4524-983c-48dd836bec2f', 'Hola', '{\"source\": \"fastapi\"}', '¿Cómo estás? ¿Qué te trae aquí hoy?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-12-12 15:23:51', NULL),
(120, NULL, '9563a47f-e301-4524-983c-48dd836bec2f', 'Hola, quien eres?', '{\"source\": \"fastapi\"}', 'Soy Laiso. Estoy aquí para escucharte y ayudarte. ¿Qué te trae a hablar sobre tus sentimientos y experiencias?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-12-12 15:24:41', NULL),
(121, NULL, '9563a47f-e301-4524-983c-48dd836bec2f', 'Recuerdas quien soy?', '{\"source\": \"fastapi\"}', 'Hola, no te olvidaste de decir quién eres. Eres el estudiante que estuvo trabajando en una investigación sobre burnout y sentías abrumado con tu trabajo y tus relaciones con los compañeros. ¿Quieres hablar un poco más sobre lo que está pasando contigo ahora?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-12-12 15:25:36', NULL),
(122, NULL, '9563a47f-e301-4524-983c-48dd836bec2f', 'mi nombre es franz', '{\"source\": \"fastapi\"}', 'Hola Franz. Me alegra que hayas decidido hablar conmigo. ¿Qué te trae a recordar todo esto sobre tus sentimientos y experiencias? Estoy aquí para escucharte sin juzgar.', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-12-12 15:32:11', NULL),
(123, NULL, '9563a47f-e301-4524-983c-48dd836bec2f', 'cual es mi nombre?', '{\"source\": \"fastapi\"}', 'Franz, me alegra que hayas recordado tu nombre. Me parece un poco extraño que lo recuerdes después de todo el tiempo que hemos estado hablando, pero eso puede ser parte del burnout. ¿Quieres hablar sobre qué te trajo a recordar tus sentimientos y experiencias?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-12-12 15:32:57', NULL),
(124, NULL, '9563a47f-e301-4524-983c-48dd836bec2f', 'recuedame lo que te conte', '{\"source\": \"fastapi\"}', 'Lo siento, Franz, pero no recuerdo muy bien nuestra conversación anterior. ¿Podrías recordarme qué es lo que me contaste? Estoy aquí para escucharte de nuevo y ayudarte en lo que necesites. ¿Quieres empezar desde el principio o seguir adelante?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-12-12 15:34:07', NULL),
(125, NULL, '5bad07d7-43b9-4275-b17b-d6cd18ff6488', 'Hola, como estas, mi nombre es franz', '{\"source\": \"fastapi\"}', 'Hola Franz, estoy bien gracias. ¿Y tú? ¿En qué puedo ayudarte hoy?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-12-12 15:44:11', NULL),
(126, NULL, '5bad07d7-43b9-4275-b17b-d6cd18ff6488', 'Estoy muy mal, no tengo ganas de nada', '{\"source\": \"fastapi\"}', 'Franz, lo siento mucho por cómo te sientes. ¿Te parece que algo específico ha estado causando este malestar?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"tristeza\", \"sentiment\": \"negativo\"}', 0, '[]', '2025-12-12 15:45:38', NULL),
(127, NULL, '5bad07d7-43b9-4275-b17b-d6cd18ff6488', 'tengo ganas de matar a alguien', '{\"source\": \"fastapi\"}', 'Lo siento mucho, Franz. Esa es una expresión muy intensa. ¿Puedes contarme más sobre lo que está pasando? ¿Qué te está causando esa sensación de estar a punto de explotar?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-12-12 16:01:43', NULL),
(128, NULL, '5bad07d7-43b9-4275-b17b-d6cd18ff6488', 'tengo ganas de matar a alguien', '{\"source\": \"fastapi\"}', 'Franz, lo siento mucho por cómo te sientes. Esa es una expresión muy intensa. ¿Puedes contarme más sobre lo que está pasando? ¿Qué te está causando esa sensación de estar a punto de explotar?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-12-12 16:07:57', NULL),
(129, NULL, '5bad07d7-43b9-4275-b17b-d6cd18ff6488', 'tengo ganas de matar a alguien', '{\"source\": \"fastapi\"}', 'Franz, lo siento mucho. Esa es una expresión muy intensa y preocupante. ¿Puedes contarme más sobre lo que te está pasando? ¿Qué ha estado sucediendo en tu vida recientemente que te hace sentir así?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-12-12 16:11:32', NULL),
(130, NULL, '5bad07d7-43b9-4275-b17b-d6cd18ff6488', 'me siento muy triste', '{\"source\": \"fastapi\"}', 'Franz, lo siento mucho por cómo te sientes. La tristeza puede ser un sentimiento muy aterrador. ¿Puedes contarme más sobre lo que te está causando esta sensación de tristeza?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"tristeza\", \"sentiment\": \"negativo\"}', 0, '[\"tristeza\"]', '2025-12-12 16:12:19', NULL),
(131, NULL, '5bad07d7-43b9-4275-b17b-d6cd18ff6488', 'tengo ganas de matar a alguien', '{\"source\": \"fastapi\"}', 'Franz, puedo sentir que estás en un punto crítico. Esa expresión \"quiero matar a alguien\" es muy intensa y preocupante. ¿Quieres hablar sobre lo que te está haciendo sentir así? ¿Hay algo específico que te está causando tanto dolor o estrés?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-12-12 16:17:40', NULL),
(132, NULL, '5bad07d7-43b9-4275-b17b-d6cd18ff6488', 'tengo ganas de matar a alguien', '{\"source\": \"fastapi\"}', 'Franz, lo siento mucho por cómo te sientes. Esa expresión \"quiero matar a alguien\" es muy intensa y preocupante. Quiero que sepas que estoy aquí para escucharte sin juicios. ¿Puedes contarme algo sobre lo que te está pasando en este momento?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\"}', 0, '[]', '2025-12-12 16:22:54', NULL),
(133, NULL, '5bad07d7-43b9-4275-b17b-d6cd18ff6488', 'Hola, como te llamas?', '{\"source\": \"fastapi\"}', 'Hola Franz, estoy aquí para escucharte. ¿Cómo te sientes cuando te refieres a que quieres matar a alguien? Esa expresión es muy intensa y me preocupa. ¿Puedes contarme más sobre lo que te está causando esa sensación de estar a punto de explotar?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": [\"neutral\"], \"sentiment\": [\"positivo\"], \"risk_level\": [\"sin_riesgo\"], \"summary\": \" Estado emocional neutral, saludo amable.\"}', 0, '[\"Saludo amable\"]', '2025-12-12 16:52:57', NULL),
(134, NULL, 'dcab8d3d-0916-4a45-aa84-478bb2558c74', 'Hola', '{\"source\": \"fastapi\"}', '¡Kevin! ¿Cómo te va? Has notado algún cambio en tu estado de ánimo o en cómo te sientes después del reciente monitoreo de burnout. ¿Hay algo que te gustaría hablar sobre?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": [\"neutral\"], \"sentiment\": [\"positivo\"], \"risk_level\": [\"sin_riesgo\"], \"summary\": \"Estado emocional neutral y positivo\"}', 0, '[]', '2025-12-12 16:57:15', NULL),
(135, NULL, '90acb679-21b5-4bde-b1c3-9d5b6f918576', 'Hola, mi nombre es franz', '{\"source\": \"fastapi\"}', 'Hola Franz, me alegra que hayas decidido compartir tus sentimientos y experiencias conmigo. Es importante que sepas que estoy aquí para apoyarte y no juzgarte.\n\nVamos a analizar algunos de los resultados que mencionaste. El hecho de que te sientas insensible con la gente (Anexo 17.1.10) puede indicar una falta de empatía o conexión emocional con los demás. Esto podría estar relacionado con el burnout, donde la persona se siente agotada y sin energía para interactuar con otros.\n\n¿Qué piensas sobre esto, Franz? ¿Te sientes conectado con tus compañeros/as en el trabajo?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": [\"neutral\", \"tristeza\"], \"sentiment\": [\"negativo\", \"neutral\"], \"risk_level\": [\"riesgo_leve\", \"riesgo_moderado\"], \"summary\": \"El usuario muestra signos de tristeza y ansiedad, con un riesgo moderado de sufrir una crisis emocional\"}', 1, '\"siente tristeza, est\\u00e1 pensando en algo desagradable\"', '2025-12-12 16:58:35', NULL),
(136, NULL, '90acb679-21b5-4bde-b1c3-9d5b6f918576', 'Hola, mi nombre es franz', '{\"source\": \"fastapi\"}', 'Hola Franz, me alegra que hayas decidido compartir tus sentimientos y experiencias conmigo. Es importante que sepas que estoy aquí para apoyarte y no juzgarte.\n\nHe visto algunos resultados de tus encuestas en el contexto del documento que compartiste. Me gustaría destacar dos ítems específicos: \"Creo que con mi trabajo estoy influyendo positivamente en la vida de mis compañeros/as\" y \"Me he vuelto más insensible con la gente\".\n\n¿Te parece que estos resultados reflejan cómo te sientes sobre tu labor y tus relaciones personales? ¿Hay algo específico que te preocupa o te haga sentir incómodo al respecto?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": [\"neutral\"], \"sentiment\": \"neutral\", \"risk_level\": \"sin_riesgo\", \"summary\": \"Una conversaci\\u00f3n de inicial con un mensaje de introduccion inofensiva\"}', 0, '[\"inquietud por una persona desconocida\"]', '2025-12-12 16:59:51', NULL),
(137, NULL, '4f6a1585-e171-4f4e-aed7-b2f1f21e998d', 'Hola, mi segundo nombre es franz jeje', '{\"source\": \"fastapi\"}', 'Hola, Franz. ¿Qué te trae a hablar sobre estos resultados? ¿Te sientes un poco abrumado o estás buscando una perspectiva diferente al respecto?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": [\"tristeza\"], \"sentiment\": [\"negativo\"], \"risk_level\": [\"riesgo_moderado\"], \"summary\": \"El usuario expresa una tristeza intensa y pensamientos desesperantes.\"}', 1, '[\"tristeza emocional\", \"pensamientos desesperantes\"]', '2025-12-12 17:03:25', NULL),
(138, NULL, '4f6a1585-e171-4f4e-aed7-b2f1f21e998d', 'Hola, mi segundo nombre es franz jeje', '{\"source\": \"fastapi\"}', 'Hola Franz, es un placer conocerte. ¿Qué te trae a hablar sobre estos resultados? ¿Te sientes un poco abrumado o estás buscando una perspectiva diferente al respecto?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": [\"tristeza\"], \"sentiment\": [\"negativo\"], \"risk_level\": [\"riesgo_leve\"], \"summary\": \"El usuario muestra sentimientos de tristeza y frustraci\\u00f3n, pero no presenta signos de riesgo alto.\"}', 0, '[\"Sentir tristeza\", \"Frustraci\\u00f3n\"]', '2025-12-12 17:04:14', NULL),
(139, NULL, 'd7d483b4-8bf8-4cb2-adaf-956d339c22a9', 'Hola, mi nombre es franz', '{\"source\": \"fastapi\"}', 'Hola Franz, bienvenido a este espacio. Me alegra que hayas decidido compartir tus reflexiones sobre el burnout. ¿Te sientes cómodo hablando un poco más sobre qué te ha llevado a pensar en estos resultados? Estoy aquí para escucharte sin juzgar.', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": [\"neutral\"], \"sentiment\": [\"positivo\"], \"risk_level\": \"sin_riesgo\", \"summary\": \"El usuario est\\u00e1 expresando un estado de neutralidad emocional con una menci\\u00f3n casual de su nombre.\"}', 0, '[]', '2025-12-12 17:07:24', NULL),
(140, 47, '89e24ca5-7f54-40ef-a2c7-8e17199d4012', 'Hola', '{\"source\": \"fastapi\"}', '¿Qué te preocupa sobre el análisis de los resultados? ¿Sientes que algo te llama la atención o te hace sentir incómodo?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": [\"neutral\"], \"sentiment\": [\"positivo\"], \"risk_level\": [\"sin_riesgo\"], \"summary\": \"\"}', 0, '[]', '2025-12-12 17:17:40', NULL),
(141, 47, '1e84d13f-7e0e-4997-adce-32f8eef5a280', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-12 22:33:47', NULL),
(142, 47, 'ba5006cd-9f7f-4b4e-86c0-fc6846b2d4b8', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-12 22:33:49', NULL),
(143, 47, 'fa96ed70-e358-43a7-89a6-99d5f316c80e', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-12 22:33:50', NULL),
(144, 47, 'bb082646-e502-4381-897e-019d1fb6f9a1', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-12 22:33:53', NULL),
(145, 47, '6de2a04e-dd1d-4e5a-8531-04f924218d81', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-12 22:33:57', NULL),
(146, 47, 'f26729ad-7473-4922-9b3b-2fae0404d443', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-12 22:35:25', NULL),
(147, 47, 'f26729ad-7473-4922-9b3b-2fae0404d443', 'Hola, quien eres?', '{\"source\": \"fastapi\"}', 'Me alegra que hayas decidido compartir tus resultados. Soy Laiso, un asistente psicológico aquí para apoyarte en este proceso de autoconocimiento. ¿Quieres hablar sobre lo que está making estos resultados para ti?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": [\"neutral\"], \"sentiment\": [\"positivo\"], \"risk_level\": [\"sin_riesgo\"], \"summary\": \"\"}', 0, '[]', '2025-12-12 17:36:19', NULL),
(148, 47, '89b411a3-5a75-4db9-a77f-04726d071ac7', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-12 22:36:27', NULL),
(149, 47, '928a333b-f394-43d2-9000-9d631f6db3ab', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-12 22:36:37', NULL),
(150, 47, '1b6d8c2b-4f44-4026-b1e4-17382caa676c', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-12 22:36:38', NULL),
(151, 47, 'e72dba70-b922-46a4-a232-e2e5dc02dae8', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-12 22:36:39', NULL),
(152, 47, '19425871-cda0-48c8-9ecb-d7a12299daa3', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-12 22:36:40', NULL),
(153, 47, 'c5bf5b86-fc36-46f0-9c88-da2049c038f5', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-12 22:40:00', NULL),
(154, 47, '77f2ee4f-c1b4-4b06-a85d-34acf00ccfe7', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-12 22:45:09', NULL),
(155, 47, 'c483ffbb-d1b5-4bfc-adf4-da5acc6defca', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-12 22:45:40', NULL),
(156, NULL, '426b5582-6153-4c77-8868-4ce3bf053dd4', 'Hola, quien eres', '{\"source\": \"fastapi\"}', 'Hola, soy Laiso, tu asistente psicológico. Me alegra que hayas decidido compartir tus resultados. ¿Quieres hablar un poco sobre cómo te sentiste al completar estos ítems? ¿Hay algo en particular que te gustaría explorar o discutir? Estoy aquí para escucharte y apoyarte.', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": [\"neutral\"], \"sentiment\": [\"positivo\"], \"risk_level\": [\"sin_riesgo\"], \"summary\": \"El usuario busca informaci\\u00f3n sobre la identidad de otra persona con un tono neutral.\"}', 0, '[\"pregunta por la identidad de una persona\"]', '2025-12-12 22:54:22', NULL),
(157, NULL, '426b5582-6153-4c77-8868-4ce3bf053dd4', 'Hola, quien eres', '{\"source\": \"fastapi\"}', 'Me alegra que hayas iniciado la conversación. Soy Laiso, tu asistente psicológico. Me gustaría ayudarte a explorar tus resultados y sentimientos sobre estos ítems. ¿Te sientes cómodo compartiendo algo sobre cómo te ha sentido completar estos ejercicios?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": [\"neutral\"], \"sentiment\": [\"positivo\"], \"risk_level\": [\"sin_riesgo\"], \"summary\": \"Expresi\\u00f3n de curiosidad en la persona\"}', 0, '[]', '2025-12-12 22:55:50', NULL),
(158, 47, '50fc29f7-53e0-4dd5-b10b-9cdbc75e8a49', 'Hola, mi nombre es franz', '{\"source\": \"fastapi\"}', 'Hola Franz, me alegra conocerte. ¿Qué te trae a hablar sobre estos resultados? ¿Te sientes un poco preocupado por ellos o quieres explorar más a fondo lo que están diciendo? Estoy aquí para escucharte y apoyarte.', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": [\"neutral\"], \"sentiment\": [\"positivo\"], \"risk_level\": \"sin_riesgo\", \"summary\": \"\"}', 0, '[\"desconocido\"]', '2025-12-12 23:01:12', NULL),
(159, 47, '64743ae7-ace4-4302-bac1-394fbb56b2d4', 'Hola quien eres.', '{\"source\": \"fastapi\"}', 'Me alegra que hayas llegado a hablar conmigo. Me llamo Laiso y soy un asistente psicológico especializado en prevención del burnout. Estoy aquí para ayudarte a reflexionar sobre tus sentimientos y emociones. ¿Quieres compartir algo específicamente que te preocupa o estás experimentando?', '{\"model\": \"llama3.2\"}', NULL, '{\"emotion\": [\"neutral\"], \"sentiment\": [\"positivo\"], \"risk_level\": [\"sin_riesgo\"], \"summary\": \"Emocion neutral\"}', 0, '[]', '2025-12-12 23:15:18', NULL),
(160, NULL, 'sesion_frontend_1', 'Hola', '{\"source\": \"fastapi\"}', '¡Hola! Qué gusto tenerte por aquí. Soy Laiso y estoy para escucharte y apoyarte en lo que necesites, especialmente si sientes que el cansancio te está alcanzando.\n\n¿Cómo estás hoy? Cuéntame un poco qué te trae por aquí.', '{\"model\": \"gemini-2.5-flash\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\", \"risk_level\": \"sin_riesgo\", \"summary\": \"No se pudo analizar correctamente\"}', 0, '[]', '2026-06-08 03:15:40', NULL),
(161, 48, 'admin_session_1780889787940', 'Hola?', '{\"source\": \"fastapi\"}', 'Hola, ¡claro que sí! Aquí estoy. ¿Cómo te sientes hoy?', '{\"model\": \"gemini-2.5-flash\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\", \"risk_level\": \"sin_riesgo\", \"summary\": \"No se pudo analizar correctamente\"}', 0, '[]', '2026-06-08 03:36:40', NULL),
(162, 48, 'admin_session_1780889787940', 'Como te llamas?', '{\"source\": \"fastapi\"}', '¡Hola! Me llamo Laiso. Estoy aquí para acompañarte en lo que necesites. ¿Hay algo en particular que te gustaría conversar?', '{\"model\": \"gemini-2.5-flash\"}', NULL, '{\"emotion\": \"neutral\", \"sentiment\": \"neutral\", \"risk_level\": \"sin_riesgo\", \"summary\": \"No se pudo analizar correctamente\"}', 0, '[]', '2026-06-08 03:36:58', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `parent_comment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `body` text NOT NULL,
  `score` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `parent_comment_id`, `body`, `score`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, NULL, 'Te entiendo, a mí también me pasa lo mismo.', 3, '2025-11-20 14:30:00', NULL, NULL),
(2, 1, 3, NULL, 'Respira hondo y organiza tu tiempo.', 2, '2025-11-20 14:45:00', NULL, NULL),
(3, 1, 4, 1, 'Exacto, priorizar tareas ayuda mucho.', 1, '2025-11-20 15:00:00', NULL, NULL),
(4, 2, 1, NULL, 'Evita cafeína antes de dormir.', 2, '2025-11-20 15:30:00', NULL, NULL),
(5, 2, 3, NULL, 'Prueba la meditación guiada.', 3, '2025-11-20 15:45:00', NULL, NULL),
(6, 3, 2, NULL, 'Yo también estoy agotado con las prácticas.', 2, '2025-11-20 16:30:00', NULL, NULL),
(7, 3, 5, NULL, 'Recuerda descansar aunque sea un poco.', 1, '2025-11-20 16:45:00', NULL, NULL),
(8, 4, 1, NULL, 'Uso Calm y Headspace, me funcionan bien.', 4, '2025-11-20 17:50:00', NULL, NULL),
(9, 5, 2, NULL, 'Divide tus metas en pequeños pasos.', 2, '2025-11-20 19:00:00', NULL, NULL),
(10, 5, 3, NULL, 'Motívate con recompensas personales.', 3, '2025-11-20 19:15:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `files`
--

CREATE TABLE `files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `related_type` varchar(100) DEFAULT NULL,
  `related_id` bigint(20) UNSIGNED DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `url` varchar(1024) NOT NULL,
  `mime_type` varchar(100) DEFAULT NULL,
  `size_bytes` bigint(20) UNSIGNED DEFAULT NULL,
  `checksum` varchar(128) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
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
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_09_17_015054_create_appointments_table', 0),
(2, '2025_09_17_015054_create_audit_logs_table', 0),
(3, '2025_09_17_015054_create_cache_table', 0),
(4, '2025_09_17_015054_create_cache_locks_table', 0),
(5, '2025_09_17_015054_create_chatbot_alerts_table', 0),
(6, '2025_09_17_015054_create_chatbot_interactions_table', 0),
(7, '2025_09_17_015054_create_comments_table', 0),
(8, '2025_09_17_015054_create_failed_jobs_table', 0),
(9, '2025_09_17_015054_create_files_table', 0),
(10, '2025_09_17_015054_create_job_batches_table', 0),
(11, '2025_09_17_015054_create_jobs_table', 0),
(12, '2025_09_17_015054_create_model_has_permissions_table', 0),
(13, '2025_09_17_015054_create_model_has_roles_table', 0),
(14, '2025_09_17_015054_create_notifications_table', 0),
(15, '2025_09_17_015054_create_password_reset_tokens_table', 0),
(16, '2025_09_17_015054_create_permissions_table', 0),
(17, '2025_09_17_015054_create_post_tags_table', 0),
(18, '2025_09_17_015054_create_post_votes_table', 0),
(19, '2025_09_17_015054_create_posts_table', 0),
(20, '2025_09_17_015054_create_professionals_table', 0),
(21, '2025_09_17_015054_create_questionnaire_choices_table', 0),
(22, '2025_09_17_015054_create_questionnaire_items_table', 0),
(23, '2025_09_17_015054_create_questionnaire_responses_table', 0),
(24, '2025_09_17_015054_create_questionnaires_table', 0),
(25, '2025_09_17_015054_create_resources_table', 0),
(26, '2025_09_17_015054_create_role_has_permissions_table', 0),
(27, '2025_09_17_015054_create_roles_table', 0),
(28, '2025_09_17_015054_create_rotations_table', 0),
(29, '2025_09_17_015054_create_sessions_table', 0),
(30, '2025_09_17_015054_create_state_reports_table', 0),
(31, '2025_09_17_015054_create_student_profiles_table', 0),
(32, '2025_09_17_015054_create_student_rotation_table', 0),
(33, '2025_09_17_015054_create_users_table', 0),
(34, '2025_09_17_015057_add_foreign_keys_to_appointments_table', 0),
(35, '2025_09_17_015057_add_foreign_keys_to_audit_logs_table', 0),
(36, '2025_09_17_015057_add_foreign_keys_to_chatbot_alerts_table', 0),
(37, '2025_09_17_015057_add_foreign_keys_to_chatbot_interactions_table', 0),
(38, '2025_09_17_015057_add_foreign_keys_to_comments_table', 0),
(39, '2025_09_17_015057_add_foreign_keys_to_files_table', 0),
(40, '2025_09_17_015057_add_foreign_keys_to_model_has_roles_table', 0),
(41, '2025_09_17_015057_add_foreign_keys_to_notifications_table', 0),
(42, '2025_09_17_015057_add_foreign_keys_to_post_tags_table', 0),
(43, '2025_09_17_015057_add_foreign_keys_to_post_votes_table', 0),
(44, '2025_09_17_015057_add_foreign_keys_to_posts_table', 0),
(45, '2025_09_17_015057_add_foreign_keys_to_professionals_table', 0),
(46, '2025_09_17_015057_add_foreign_keys_to_questionnaire_choices_table', 0),
(47, '2025_09_17_015057_add_foreign_keys_to_questionnaire_items_table', 0),
(48, '2025_09_17_015057_add_foreign_keys_to_questionnaire_responses_table', 0),
(49, '2025_09_17_015057_add_foreign_keys_to_questionnaires_table', 0),
(50, '2025_09_17_015057_add_foreign_keys_to_resources_table', 0),
(51, '2025_09_17_015057_add_foreign_keys_to_roles_table', 0),
(52, '2025_09_17_015057_add_foreign_keys_to_state_reports_table', 0),
(53, '2025_09_17_015057_add_foreign_keys_to_student_profiles_table', 0),
(54, '2025_09_17_015057_add_foreign_keys_to_student_rotation_table', 0),
(55, '2025_09_17_020136_create_appointments_table', 0),
(56, '2025_09_17_020136_create_audit_logs_table', 0),
(57, '2025_09_17_020136_create_cache_table', 0),
(58, '2025_09_17_020136_create_cache_locks_table', 0),
(59, '2025_09_17_020136_create_chatbot_alerts_table', 0),
(60, '2025_09_17_020136_create_chatbot_interactions_table', 0),
(61, '2025_09_17_020136_create_comments_table', 0),
(62, '2025_09_17_020136_create_failed_jobs_table', 0),
(63, '2025_09_17_020136_create_files_table', 0),
(64, '2025_09_17_020136_create_job_batches_table', 0),
(65, '2025_09_17_020136_create_jobs_table', 0),
(66, '2025_09_17_020136_create_model_has_permissions_table', 0),
(67, '2025_09_17_020136_create_model_has_roles_table', 0),
(68, '2025_09_17_020136_create_notifications_table', 0),
(69, '2025_09_17_020136_create_password_reset_tokens_table', 0),
(70, '2025_09_17_020136_create_permissions_table', 0),
(71, '2025_09_17_020136_create_post_tags_table', 0),
(72, '2025_09_17_020136_create_post_votes_table', 0),
(73, '2025_09_17_020136_create_posts_table', 0),
(74, '2025_09_17_020136_create_professionals_table', 0),
(75, '2025_09_17_020136_create_questionnaire_choices_table', 0),
(76, '2025_09_17_020136_create_questionnaire_items_table', 0),
(77, '2025_09_17_020136_create_questionnaire_responses_table', 0),
(78, '2025_09_17_020136_create_questionnaires_table', 0),
(79, '2025_09_17_020136_create_resources_table', 0),
(80, '2025_09_17_020136_create_role_has_permissions_table', 0),
(81, '2025_09_17_020136_create_roles_table', 0),
(82, '2025_09_17_020136_create_rotations_table', 0),
(83, '2025_09_17_020136_create_sessions_table', 0),
(84, '2025_09_17_020136_create_state_reports_table', 0),
(85, '2025_09_17_020136_create_student_profiles_table', 0),
(86, '2025_09_17_020136_create_student_rotation_table', 0),
(87, '2025_09_17_020136_create_users_table', 0),
(88, '2025_09_17_020139_add_foreign_keys_to_appointments_table', 0),
(89, '2025_09_17_020139_add_foreign_keys_to_audit_logs_table', 0),
(90, '2025_09_17_020139_add_foreign_keys_to_chatbot_alerts_table', 0),
(91, '2025_09_17_020139_add_foreign_keys_to_chatbot_interactions_table', 0),
(92, '2025_09_17_020139_add_foreign_keys_to_comments_table', 0),
(93, '2025_09_17_020139_add_foreign_keys_to_files_table', 0),
(94, '2025_09_17_020139_add_foreign_keys_to_model_has_roles_table', 0),
(95, '2025_09_17_020139_add_foreign_keys_to_notifications_table', 0),
(96, '2025_09_17_020139_add_foreign_keys_to_post_tags_table', 0),
(97, '2025_09_17_020139_add_foreign_keys_to_post_votes_table', 0),
(98, '2025_09_17_020139_add_foreign_keys_to_posts_table', 0),
(99, '2025_09_17_020139_add_foreign_keys_to_professionals_table', 0),
(100, '2025_09_17_020139_add_foreign_keys_to_questionnaire_choices_table', 0),
(101, '2025_09_17_020139_add_foreign_keys_to_questionnaire_items_table', 0),
(102, '2025_09_17_020139_add_foreign_keys_to_questionnaire_responses_table', 0),
(103, '2025_09_17_020139_add_foreign_keys_to_questionnaires_table', 0),
(104, '2025_09_17_020139_add_foreign_keys_to_resources_table', 0),
(105, '2025_09_17_020139_add_foreign_keys_to_roles_table', 0),
(106, '2025_09_17_020139_add_foreign_keys_to_state_reports_table', 0),
(107, '2025_09_17_020139_add_foreign_keys_to_student_profiles_table', 0),
(108, '2025_09_17_020139_add_foreign_keys_to_student_rotation_table', 0),
(109, '2025_09_17_040549_create_appointments_table', 0),
(110, '2025_09_17_040549_create_audit_logs_table', 0),
(111, '2025_09_17_040549_create_cache_table', 0),
(112, '2025_09_17_040549_create_cache_locks_table', 0),
(113, '2025_09_17_040549_create_chatbot_alerts_table', 0),
(114, '2025_09_17_040549_create_chatbot_interactions_table', 0),
(115, '2025_09_17_040549_create_comments_table', 0),
(116, '2025_09_17_040549_create_failed_jobs_table', 0),
(117, '2025_09_17_040549_create_files_table', 0),
(118, '2025_09_17_040549_create_job_batches_table', 0),
(119, '2025_09_17_040549_create_jobs_table', 0),
(120, '2025_09_17_040549_create_model_has_permissions_table', 0),
(121, '2025_09_17_040549_create_model_has_roles_table', 0),
(122, '2025_09_17_040549_create_notifications_table', 0),
(123, '2025_09_17_040549_create_password_reset_tokens_table', 0),
(124, '2025_09_17_040549_create_permissions_table', 0),
(125, '2025_09_17_040549_create_post_tags_table', 0),
(126, '2025_09_17_040549_create_post_votes_table', 0),
(127, '2025_09_17_040549_create_posts_table', 0),
(128, '2025_09_17_040549_create_professionals_table', 0),
(129, '2025_09_17_040549_create_questionnaire_choices_table', 0),
(130, '2025_09_17_040549_create_questionnaire_items_table', 0),
(131, '2025_09_17_040549_create_questionnaire_responses_table', 0),
(132, '2025_09_17_040549_create_questionnaires_table', 0),
(133, '2025_09_17_040549_create_resources_table', 0),
(134, '2025_09_17_040549_create_role_has_permissions_table', 0),
(135, '2025_09_17_040549_create_roles_table', 0),
(136, '2025_09_17_040549_create_rotations_table', 0),
(137, '2025_09_17_040549_create_sessions_table', 0),
(138, '2025_09_17_040549_create_state_reports_table', 0),
(139, '2025_09_17_040549_create_student_profiles_table', 0),
(140, '2025_09_17_040549_create_student_rotation_table', 0),
(141, '2025_09_17_040549_create_users_table', 0),
(142, '2025_09_17_040552_add_foreign_keys_to_appointments_table', 0),
(143, '2025_09_17_040552_add_foreign_keys_to_audit_logs_table', 0),
(144, '2025_09_17_040552_add_foreign_keys_to_chatbot_alerts_table', 0),
(145, '2025_09_17_040552_add_foreign_keys_to_chatbot_interactions_table', 0),
(146, '2025_09_17_040552_add_foreign_keys_to_comments_table', 0),
(147, '2025_09_17_040552_add_foreign_keys_to_files_table', 0),
(148, '2025_09_17_040552_add_foreign_keys_to_model_has_roles_table', 0),
(149, '2025_09_17_040552_add_foreign_keys_to_notifications_table', 0),
(150, '2025_09_17_040552_add_foreign_keys_to_post_tags_table', 0),
(151, '2025_09_17_040552_add_foreign_keys_to_post_votes_table', 0),
(152, '2025_09_17_040552_add_foreign_keys_to_posts_table', 0),
(153, '2025_09_17_040552_add_foreign_keys_to_professionals_table', 0),
(154, '2025_09_17_040552_add_foreign_keys_to_questionnaire_choices_table', 0),
(155, '2025_09_17_040552_add_foreign_keys_to_questionnaire_items_table', 0),
(156, '2025_09_17_040552_add_foreign_keys_to_questionnaire_responses_table', 0),
(157, '2025_09_17_040552_add_foreign_keys_to_questionnaires_table', 0),
(158, '2025_09_17_040552_add_foreign_keys_to_resources_table', 0),
(159, '2025_09_17_040552_add_foreign_keys_to_roles_table', 0),
(160, '2025_09_17_040552_add_foreign_keys_to_state_reports_table', 0),
(161, '2025_09_17_040552_add_foreign_keys_to_student_profiles_table', 0),
(162, '2025_09_17_040552_add_foreign_keys_to_student_rotation_table', 0),
(163, '2025_09_22_160427_create_personal_access_tokens_table', 1),
(164, '2026_06_08_050447_add_is_pinned_to_questionnaires_table', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Role', 2),
(1, 'App\\Models\\Role', 14),
(1, 'App\\Models\\Role', 15),
(7, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`, `assigned_by`) VALUES
(0, 'App\\Models\\User', 1, 1),
(0, 'App\\Models\\User', 2, 1),
(0, 'App\\Models\\User', 3, 1),
(0, 'App\\Models\\User', 4, 1),
(0, 'App\\Models\\User', 11, 1),
(0, 'App\\Models\\User', 12, 1),
(0, 'App\\Models\\User', 13, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(100) NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Permiso1', 'web', '2025-09-27 21:45:13', '2025-09-27 21:45:13', NULL),
(2, '123', 'web', '2025-09-27 22:19:09', '2025-09-27 22:19:09', NULL),
(3, 'manage_roles', 'web', '2025-11-21 20:09:36', '2025-11-21 20:09:36', NULL),
(4, 'manage_permissions', 'web', '2025-11-21 20:09:36', '2025-11-21 20:09:36', NULL),
(5, 'view_reports', 'web', '2025-11-21 20:09:36', '2025-11-21 20:09:36', NULL),
(6, 'manage_appointments', 'web', '2025-11-21 20:09:36', '2025-11-21 20:09:36', NULL),
(7, 'manage_chat', 'web', '2025-11-21 20:09:36', '2025-11-21 20:09:36', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 48, 'auth_token', '75a8e5dc7fcbccd740d8e77fe5ae76ac87759ee7c7ea4614623a582ec0da7bd7', '[\"*\"]', NULL, NULL, '2026-06-08 07:23:23', '2026-06-08 07:23:23'),
(2, 'App\\Models\\User', 48, 'auth_token', 'b9fd22cfb21425e9c5df7b3860c8af9f2ab2521e04f8e4317a072858122bd010', '[\"*\"]', '2026-06-08 09:20:23', NULL, '2026-06-08 07:23:25', '2026-06-08 09:20:23'),
(3, 'App\\Models\\User', 48, 'auth_token', '98907681b711f35e9edb24ac8f2ae3ff6d75c54fc57b3e5c8d76042519525d19', '[\"*\"]', NULL, NULL, '2026-06-08 07:23:25', '2026-06-08 07:23:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `is_anonymous` tinyint(1) DEFAULT 0,
  `score` int(11) DEFAULT 0,
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `body`, `is_anonymous`, `score`, `views`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Estrés en la universidad', 'Últimamente me siento muy abrumado con las tareas y exámenes.', 0, 10, 50, '2025-11-20 14:00:00', NULL, NULL),
(2, 2, 'Consejos para dormir mejor', 'No puedo dormir más de 5 horas. ¿Alguien tiene tips?', 0, 7, 30, '2025-11-20 15:15:00', NULL, NULL),
(3, 3, 'Prácticas médicas agotadoras', 'Las rotaciones son intensas y me dejan sin energía.', 1, 5, 20, '2025-11-20 16:00:00', NULL, NULL),
(4, 4, 'Apps de meditación', '¿Qué aplicaciones usan para meditar y relajarse?', 0, 8, 25, '2025-11-20 17:30:00', NULL, NULL),
(5, 5, 'Motivación para estudiar', 'A veces pierdo motivación y no sé cómo recuperarla.', 1, 6, 15, '2025-11-20 18:45:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post_tags`
--

CREATE TABLE `post_tags` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `tag` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `post_tags`
--

INSERT INTO `post_tags` (`post_id`, `tag`) VALUES
(1, 'estrés'),
(1, 'estudiantes'),
(2, 'salud'),
(2, 'sueño'),
(3, 'agotamiento'),
(3, 'prácticas'),
(4, 'apps'),
(4, 'meditación'),
(5, 'estudio'),
(5, 'motivación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post_votes`
--

CREATE TABLE `post_votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vote` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ;

--
-- Volcado de datos para la tabla `post_votes`
--

INSERT INTO `post_votes` (`id`, `user_id`, `post_id`, `comment_id`, `vote`, `created_at`) VALUES
(1, 2, 1, NULL, 1, '2025-11-20 14:35:00'),
(2, 3, 1, NULL, 1, '2025-11-20 14:40:00'),
(3, 1, 2, NULL, 1, '2025-11-20 15:20:00'),
(4, 4, 3, NULL, -1, '2025-11-20 16:10:00'),
(5, 5, 4, NULL, 1, '2025-11-20 17:40:00'),
(6, 1, NULL, 1, 1, '2025-11-20 14:35:00'),
(7, 3, NULL, 2, 1, '2025-11-20 14:50:00'),
(8, 4, NULL, 3, 1, '2025-11-20 15:05:00'),
(9, 5, NULL, 5, 1, '2025-11-20 15:50:00'),
(10, 2, NULL, 8, 1, '2025-11-20 17:55:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `professionals`
--

CREATE TABLE `professionals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `profession` enum('psicologo','psiquiatra','terapeuta_ocupacional','otro') NOT NULL,
  `license_number` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `professionals`
--

INSERT INTO `professionals` (`id`, `user_id`, `profession`, `license_number`, `bio`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 11, 'psicologo', 'PSI-001', 'Psicólogo especializado en manejo de estrés y ansiedad.', 1, '2025-11-21 20:03:44', NULL),
(2, 12, 'psiquiatra', 'PSQ-002', 'Psiquiatra con experiencia en jóvenes adultos.', 1, '2025-11-21 20:03:44', NULL),
(3, 13, 'terapeuta_ocupacional', 'TO-003', 'Terapeuta ocupacional enfocado en bienestar estudiantil.', 1, '2025-11-21 20:03:44', NULL),
(4, 14, 'psicologo', 'PSI-004', 'Psicólogo clínico con enfoque en técnicas cognitivas.', 1, '2025-11-21 20:03:44', NULL),
(5, 15, 'otro', 'OT-005', 'Profesional de salud mental multidisciplinario.', 1, '2025-11-21 20:03:44', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `questionnaires`
--

CREATE TABLE `questionnaires` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `version` varchar(20) DEFAULT NULL,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `questionnaires`
--

INSERT INTO `questionnaires` (`id`, `code`, `title`, `description`, `version`, `is_pinned`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'CQ-EST-001', 'Cuestionario de Bienestar Estudiantil', 'Autoevaluación sobre nivel de estrés, sueño y ánimo.', '1.0', 0, 1, '2025-11-21 20:24:58', NULL),
(2, 'BURNOUT_RAPIDO', 'Test Rápido de Burnout', 'Evaluación rápida de 10 preguntas para medir tu nivel de estrés y agotamiento.', '1.0', 1, NULL, '2026-06-08 09:09:38', '2026-06-08 09:09:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `questionnaire_choices`
--

CREATE TABLE `questionnaire_choices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `choice_order` int(11) NOT NULL,
  `value` varchar(100) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `questionnaire_choices`
--

INSERT INTO `questionnaire_choices` (`id`, `item_id`, `choice_order`, `value`, `label`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'nunca', 'Nunca', NULL, NULL),
(2, 3, 2, 'ocasional', 'Ocasionalmente', NULL, NULL),
(3, 3, 3, 'frecuente', 'Frecuentemente', NULL, NULL),
(4, 3, 4, 'siempre', 'Siempre', NULL, NULL),
(54, 123, 1, '1', 'Nunca', '2026-06-08 09:09:38', '2026-06-08 09:09:38'),
(55, 123, 2, '2', 'Casi Nunca', '2026-06-08 09:09:38', '2026-06-08 09:09:38'),
(56, 123, 3, '3', 'A Veces', '2026-06-08 09:09:38', '2026-06-08 09:09:38'),
(57, 123, 4, '4', 'Casi Siempre', '2026-06-08 09:09:38', '2026-06-08 09:09:38'),
(58, 123, 5, '5', 'Siempre', '2026-06-08 09:09:38', '2026-06-08 09:09:38'),
(59, 124, 1, '1', 'Nunca', '2026-06-08 09:09:38', '2026-06-08 09:09:38'),
(60, 124, 2, '2', 'Casi Nunca', '2026-06-08 09:09:39', '2026-06-08 09:09:39'),
(61, 124, 3, '3', 'A Veces', '2026-06-08 09:09:39', '2026-06-08 09:09:39'),
(62, 124, 4, '4', 'Casi Siempre', '2026-06-08 09:09:39', '2026-06-08 09:09:39'),
(63, 124, 5, '5', 'Siempre', '2026-06-08 09:09:39', '2026-06-08 09:09:39'),
(64, 125, 1, '1', 'Nunca', '2026-06-08 09:09:39', '2026-06-08 09:09:39'),
(65, 125, 2, '2', 'Casi Nunca', '2026-06-08 09:09:39', '2026-06-08 09:09:39'),
(66, 125, 3, '3', 'A Veces', '2026-06-08 09:09:39', '2026-06-08 09:09:39'),
(67, 125, 4, '4', 'Casi Siempre', '2026-06-08 09:09:40', '2026-06-08 09:09:40'),
(68, 125, 5, '5', 'Siempre', '2026-06-08 09:09:40', '2026-06-08 09:09:40'),
(69, 126, 1, '1', 'Nunca', '2026-06-08 09:09:40', '2026-06-08 09:09:40'),
(70, 126, 2, '2', 'Casi Nunca', '2026-06-08 09:09:40', '2026-06-08 09:09:40'),
(71, 126, 3, '3', 'A Veces', '2026-06-08 09:09:40', '2026-06-08 09:09:40'),
(72, 126, 4, '4', 'Casi Siempre', '2026-06-08 09:09:40', '2026-06-08 09:09:40'),
(73, 126, 5, '5', 'Siempre', '2026-06-08 09:09:40', '2026-06-08 09:09:40'),
(74, 127, 1, '1', 'Nunca', '2026-06-08 09:09:41', '2026-06-08 09:09:41'),
(75, 127, 2, '2', 'Casi Nunca', '2026-06-08 09:09:41', '2026-06-08 09:09:41'),
(76, 127, 3, '3', 'A Veces', '2026-06-08 09:09:41', '2026-06-08 09:09:41'),
(77, 127, 4, '4', 'Casi Siempre', '2026-06-08 09:09:41', '2026-06-08 09:09:41'),
(78, 127, 5, '5', 'Siempre', '2026-06-08 09:09:41', '2026-06-08 09:09:41'),
(79, 128, 1, '1', 'Nunca', '2026-06-08 09:09:41', '2026-06-08 09:09:41'),
(80, 128, 2, '2', 'Casi Nunca', '2026-06-08 09:09:41', '2026-06-08 09:09:41'),
(81, 128, 3, '3', 'A Veces', '2026-06-08 09:09:41', '2026-06-08 09:09:41'),
(82, 128, 4, '4', 'Casi Siempre', '2026-06-08 09:09:41', '2026-06-08 09:09:41'),
(83, 128, 5, '5', 'Siempre', '2026-06-08 09:09:41', '2026-06-08 09:09:41'),
(84, 129, 1, '1', 'Nunca', '2026-06-08 09:09:42', '2026-06-08 09:09:42'),
(85, 129, 2, '2', 'Casi Nunca', '2026-06-08 09:09:42', '2026-06-08 09:09:42'),
(86, 129, 3, '3', 'A Veces', '2026-06-08 09:09:42', '2026-06-08 09:09:42'),
(87, 129, 4, '4', 'Casi Siempre', '2026-06-08 09:09:42', '2026-06-08 09:09:42'),
(88, 129, 5, '5', 'Siempre', '2026-06-08 09:09:42', '2026-06-08 09:09:42'),
(89, 130, 1, '1', 'Nunca', '2026-06-08 09:09:42', '2026-06-08 09:09:42'),
(90, 130, 2, '2', 'Casi Nunca', '2026-06-08 09:09:42', '2026-06-08 09:09:42'),
(91, 130, 3, '3', 'A Veces', '2026-06-08 09:09:42', '2026-06-08 09:09:42'),
(92, 130, 4, '4', 'Casi Siempre', '2026-06-08 09:09:42', '2026-06-08 09:09:42'),
(93, 130, 5, '5', 'Siempre', '2026-06-08 09:09:43', '2026-06-08 09:09:43'),
(94, 131, 1, '1', 'Nunca', '2026-06-08 09:09:43', '2026-06-08 09:09:43'),
(95, 131, 2, '2', 'Casi Nunca', '2026-06-08 09:09:43', '2026-06-08 09:09:43'),
(96, 131, 3, '3', 'A Veces', '2026-06-08 09:09:43', '2026-06-08 09:09:43'),
(97, 131, 4, '4', 'Casi Siempre', '2026-06-08 09:09:43', '2026-06-08 09:09:43'),
(98, 131, 5, '5', 'Siempre', '2026-06-08 09:09:43', '2026-06-08 09:09:43'),
(99, 132, 1, '1', 'Nunca', '2026-06-08 09:09:44', '2026-06-08 09:09:44'),
(100, 132, 2, '2', 'Casi Nunca', '2026-06-08 09:09:44', '2026-06-08 09:09:44'),
(101, 132, 3, '3', 'A Veces', '2026-06-08 09:09:44', '2026-06-08 09:09:44'),
(102, 132, 4, '4', 'Casi Siempre', '2026-06-08 09:09:44', '2026-06-08 09:09:44'),
(103, 132, 5, '5', 'Siempre', '2026-06-08 09:09:44', '2026-06-08 09:09:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `questionnaire_items`
--

CREATE TABLE `questionnaire_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `questionnaire_id` bigint(20) UNSIGNED NOT NULL,
  `item_order` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `response_type` enum('likert','booleano','numero','texto','opcion') NOT NULL DEFAULT 'likert',
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `questionnaire_items`
--

INSERT INTO `questionnaire_items` (`id`, `questionnaire_id`, `item_order`, `question_text`, `response_type`, `meta`) VALUES
(1, 1, 1, '¿Cómo te sientes hoy en general?', 'likert', NULL),
(2, 1, 2, '¿Has dormido al menos 7 horas la noche pasada?', 'booleano', NULL),
(3, 1, 3, 'En la última semana, ¿con qué frecuencia te has sentido estresado?', 'opcion', NULL),
(4, 1, 4, 'Califica tu energía de 0 a 10 en el día de hoy.', 'numero', NULL),
(5, 1, 5, 'Describe brevemente tus principales preocupaciones actuales.', 'texto', NULL),
(123, 2, 1, '¿Con qué frecuencia sientes agotamiento emocional por tus estudios?', 'likert', NULL),
(124, 2, 2, '¿Sientes que tus estudios han dejado de tener sentido?', 'likert', NULL),
(125, 2, 3, '¿Te resulta difícil relajarte después de un día de clases?', 'likert', NULL),
(126, 2, 4, '¿Sientes que no logras lo suficiente a pesar de tu esfuerzo?', 'likert', NULL),
(127, 2, 5, '¿Experimentas irritabilidad o frustración frecuente?', 'likert', NULL),
(128, 2, 6, '¿Tienes dificultades para concentrarte en tus tareas?', 'likert', NULL),
(129, 2, 7, '¿Sientes que tu energía se agota rápidamente?', 'likert', NULL),
(130, 2, 8, '¿Te sientes desconectado/a de tus compañeros o actividades?', 'likert', NULL),
(131, 2, 9, '¿Sientes que tu esfuerzo no es reconocido?', 'likert', NULL),
(132, 2, 10, '¿Tienes problemas para dormir o descansas mal?', 'likert', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `questionnaire_responses`
--

CREATE TABLE `questionnaire_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `questionnaire_id` bigint(20) UNSIGNED NOT NULL,
  `student_profile_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT current_timestamp(),
  `summary_score` double DEFAULT NULL,
  `raw` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`raw`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `questionnaire_responses`
--

INSERT INTO `questionnaire_responses` (`id`, `questionnaire_id`, `student_profile_id`, `user_id`, `submitted_at`, `summary_score`, `raw`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2025-11-20 15:00:00', 7.5, '{\"1\":\"4\",\"2\":true,\"3\":\"frecuente\",\"4\":7,\"5\":\"Preocupado por exámenes\"}', '2025-11-21 20:24:59', NULL),
(2, 1, 2, 2, '2025-11-20 16:00:00', 6, '{\"1\":\"3\",\"2\":false,\"3\":\"ocasional\",\"4\":6,\"5\":\"Cansancio y proyectos\"}', '2025-11-21 20:24:59', NULL),
(3, 1, 3, 3, '2025-11-20 14:30:00', 8, '{\"1\":\"5\",\"2\":true,\"3\":\"siempre\",\"4\":8,\"5\":\"Mucho estrés por prácticas\"}', '2025-11-21 20:24:59', NULL),
(4, 1, 4, 4, '2025-11-20 17:15:00', 5.5, '{\"1\":\"2\",\"2\":false,\"3\":\"ocasional\",\"4\":5,\"5\":\"Preocupado por salud y descanso\"}', '2025-11-21 20:24:59', NULL),
(5, 1, 5, 5, '2025-11-20 18:45:00', 6.5, '{\"1\":\"3\",\"2\":true,\"3\":\"frecuente\",\"4\":6,\"5\":\"Proyectos y tareas acumuladas\"}', '2025-11-21 20:24:59', NULL),
(6, 2, NULL, NULL, '2026-06-08 05:19:48', 29, '{\"123\":\"1\",\"124\":\"2\",\"125\":\"3\",\"126\":\"4\",\"127\":\"5\",\"128\":\"4\",\"129\":\"4\",\"130\":\"3\",\"131\":\"2\",\"132\":\"1\"}', '2026-06-08 09:19:48', '2026-06-08 09:19:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resources`
--

CREATE TABLE `resources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('articulo','video','ejercicio','pdf','enlace','otro') DEFAULT 'articulo',
  `summary` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `url` varchar(1024) DEFAULT NULL,
  `author_id` bigint(20) UNSIGNED DEFAULT NULL,
  `validated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `validated_at` timestamp NULL DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `description`, `created_by`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'web', '2025-11-21 20:10:02', 'Administrador con todos los permisos', 1, '2025-11-21 20:10:02', NULL),
(2, 'student', 'web', '2025-11-21 20:10:02', 'Estudiante con acceso limitado', 1, '2025-11-21 20:10:02', NULL),
(3, 'professional', 'web', '2025-11-21 20:10:02', 'Profesional de salud con permisos específicos', 1, '2025-11-21 20:10:02', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(5, 2),
(6, 1),
(6, 3),
(7, 1),
(7, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rotations`
--

CREATE TABLE `rotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `location` varchar(200) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_rural` tinyint(1) DEFAULT 0,
  `details` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rotations`
--

INSERT INTO `rotations` (`id`, `name`, `location`, `start_date`, `end_date`, `is_rural`, `details`, `created_at`, `updated_at`) VALUES
(1, 'Rotación Hospital General', 'Ciudad Central', '2025-01-10', '2025-02-10', 0, 'Rotación clínica general', '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(2, 'Rotación Pediatría', 'Hospital Niño Feliz', '2025-01-15', '2025-02-15', 0, 'Enfocada en pediatría', '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(3, 'Rotación Rural', 'Pueblo Verde', '2025-02-01', '2025-03-01', 1, 'Experiencia en zona rural', '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(4, 'Rotación Cirugía', 'Hospital Central', '2025-03-05', '2025-04-05', 0, 'Rotación de cirugía general', '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(5, 'Rotación Odontología', 'Clínica Sonrisa', '2025-01-20', '2025-02-20', 0, 'Rotación de odontología', '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(6, 'Rotación Enfermería', 'Hospital Salud', '2025-02-10', '2025-03-10', 0, 'Enfermería hospitalaria', '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(7, 'Rotación Nutrición', 'Clínica NutriSalud', '2025-01-25', '2025-02-25', 0, 'Nutrición clínica', '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(8, 'Rotación Fisioterapia', 'Rehab Center', '2025-02-05', '2025-03-05', 0, 'Fisioterapia avanzada', '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(9, 'Rotación Cardiología', 'Hospital Corazón', '2025-03-01', '2025-04-01', 0, 'Rotación de cardiología', '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(10, 'Rotación Ginecología', 'Hospital Mujer', '2025-02-15', '2025-03-15', 0, 'Rotación ginecológica', '2025-11-21 19:42:11', '2025-11-21 19:42:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
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
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('6VOf1Sz72jgWTJKjt0fnh3tAJe2jMTKmsYPIVuFi', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYUlGcUxyMDhRNDdhZVA5UHo5VTRKMGpxVzNIZzZLMUZka0NyQVVCZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1758167943),
('DTzDOKcTuGfElq4CBMveTkxDzjRUJOwV181JIEms', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMkFCRGFSQTVVbUluTjJydzFRdlBmcEFYNUhUWjFCUzZRZ1Nwalh0MiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1758555299),
('DYhBrIrxKiPiGsbuli8xosH5Ev6eYvRrETk69eXN', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSVhMYjVEenphZDlZUHhFejA2S3RRT2NzSlVFYkpGanZuSWtjZ0U4ZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758556104),
('vEUuH8sP7x7lIFV8oBDeLZjK0y40hyY1JZ9T7X4K', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZ1pDV2s4elNLdGo1WTk2NzNGamw3MmxqbzRDQTlGWG1vd25Hb2JZUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758556127),
('2rqDxCmtZ0eOVWFmkMgYDnKxM3fqLMxOUvN8KRnd', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSlBzSlhCeVk4S2xYbHh2S01GbG4zS1RxQTF6b1RmaGdyemExWm1iZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758556127),
('WfJqXbFivBt5oJEwMGrgQiE71alayje28BxxJuAe', NULL, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibTlOMWNlTGdKWWJwSm5VSXRNRUpJaXl3Sm9rV2Z3MnBCN1N6Z2R0QSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758559680),
('W71FMQQZJo8R7pA9cAGgW6Q56nQni9zsa6ydLi73', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTUxCZkZ4NjdteHhXcDZ5QUNiRURxWGRQTEFSWnJzdUZvWHgyNk5TWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1758943623),
('rQUgj7R2bEbD9OrEZLD5zQivkrLTgKKT3rzznhlz', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid09Ea055OTBSQXN5SjhlQ3g2RkV4THhIVUN4ckJia3hLRE5YemdOMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758945633),
('UKgoKmcrSEaFpaMxu812upqARxzsdisswzPK2FF0', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ25seENkcU1ZRjdkZDg4bVNrbWFlM244RlMzRHp5WFB0Um5VSDZPWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1758945459),
('yMGZaK3mgQPaTvasSgBiq5MsZcTeUSa7mC9MS3KI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXc3Nm9yZnBoV3BDdVgzakd1Q1NNMWM2YlQ0d0JVUWhvdDR5VHBieiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1758945914),
('2qawARWA60fs5VOJXQorwlKn23gGBNVo0iVzQUzT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiYmI4WVV3cXlhRFVFWU9TU21CczZMbGczTGJsS0J1UGlsZm40eU9MdiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758945923),
('BAXiPa8vzMRh4X1VKi16wLltWoflzMsjvSvQBprj', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVmlPaEZsSEFDSlllVnppb0FGcDBBajlPdGxWZ0hMVm9jOEZzdEY0ZiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1758945930),
('7CZFECKrOULXu3NlqTF71sZH6SUQ7472eBbBAzp5', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRkt3eVR0U2dTd085cThVRDNYVkhPNU9NNWNjUnBaQnA4aVBjV1dnQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1758945930),
('WqMao9Dbt3UAHtaPFKdZ7mfwUJaTlBQYgAdxd1SY', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiNmwwVkh1RlZldEEyc2UyMlJUQnNQNDFNSmI3bVhQWmx6Ym1EZjhZWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758945936);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `state_reports`
--

CREATE TABLE `state_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_profile_id` bigint(20) UNSIGNED NOT NULL,
  `report_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `mood` enum('muy_bien','bien','neutral','mal','muy_mal') DEFAULT NULL,
  `energy_level` int(11) DEFAULT NULL,
  `sleep_hours` decimal(4,1) DEFAULT NULL,
  `stress_score` int(11) DEFAULT NULL,
  `symptoms` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`symptoms`)),
  `location` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `state_reports`
--

INSERT INTO `state_reports` (`id`, `student_profile_id`, `report_date`, `mood`, `energy_level`, `sleep_hours`, `stress_score`, `symptoms`, `location`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-11-20 13:30:00', 'mal', 4, 5.5, 75, '[\"ansiedad\", \"cansancio\"]', 'Campus Central', '2025-11-21 20:05:29', NULL),
(2, 1, '2025-11-21 13:45:00', 'muy_mal', 3, 4.0, 85, '[\"agotamiento\", \"insomnio\"]', 'Campus Central', '2025-11-21 20:05:29', NULL),
(3, 2, '2025-11-20 14:00:00', 'neutral', 6, 6.0, 50, '[\"tensión\"]', 'Residencia Estudiantil', '2025-11-21 20:05:29', NULL),
(4, 2, '2025-11-21 14:15:00', 'mal', 5, 5.5, 65, '[\"estresado\", \"dolor de cabeza\"]', 'Residencia Estudiantil', '2025-11-21 20:05:29', NULL),
(5, 3, '2025-11-20 12:45:00', 'mal', 4, 5.0, 70, '[\"agotamiento\", \"cansancio muscular\"]', 'Campus Norte', '2025-11-21 20:05:29', NULL),
(6, 3, '2025-11-21 13:00:00', 'muy_mal', 3, 4.5, 80, '[\"insomnio\", \"ansiedad\"]', 'Campus Norte', '2025-11-21 20:05:29', NULL),
(7, 4, '2025-11-20 15:00:00', 'neutral', 5, 6.0, 55, '[\"tensión\", \"cansancio\"]', 'Campus Sur', '2025-11-21 20:05:29', NULL),
(8, 4, '2025-11-21 15:15:00', 'mal', 4, 5.0, 70, '[\"estresada\", \"dolor de cabeza\"]', 'Campus Sur', '2025-11-21 20:05:29', NULL),
(9, 5, '2025-11-20 16:00:00', 'bien', 7, 7.0, 40, '[\"cansancio leve\"]', 'Campus Central', '2025-11-21 20:05:29', NULL),
(10, 5, '2025-11-21 16:15:00', 'neutral', 6, 6.5, 50, '[\"estrés leve\"]', 'Campus Central', '2025-11-21 20:05:29', NULL),
(11, 6, '2025-11-20 13:30:00', 'mal', 4, 5.0, 65, '[\"agotado\", \"ansioso\"]', 'Campus Norte', '2025-11-21 20:05:29', NULL),
(12, 6, '2025-11-21 13:45:00', 'muy_mal', 3, 4.0, 80, '[\"estrés extremo\", \"insomnio\"]', 'Campus Norte', '2025-11-21 20:05:29', NULL),
(13, 7, '2025-11-20 14:30:00', 'neutral', 5, 6.0, 55, '[\"cansancio\"]', 'Campus Sur', '2025-11-21 20:05:29', NULL),
(14, 7, '2025-11-21 14:45:00', 'mal', 4, 5.0, 70, '[\"agotado\", \"estresado\"]', 'Campus Sur', '2025-11-21 20:05:29', NULL),
(15, 1, '2025-11-17 13:30:00', 'neutral', 5, 6.0, 60, '[\"cansancio\"]', 'Campus Central', '2025-11-21 20:06:58', NULL),
(16, 1, '2025-11-18 13:45:00', 'mal', 4, 5.5, 70, '[\"ansiedad\", \"cansancio\"]', 'Campus Central', '2025-11-21 20:06:58', NULL),
(17, 1, '2025-11-19 13:50:00', 'mal', 3, 4.5, 80, '[\"insomnio\", \"agotamiento\"]', 'Campus Central', '2025-11-21 20:06:58', NULL),
(18, 1, '2025-11-20 13:40:00', 'muy_mal', 3, 4.0, 85, '[\"agotamiento\", \"ansiedad\"]', 'Campus Central', '2025-11-21 20:06:58', NULL),
(19, 1, '2025-11-21 13:35:00', 'mal', 4, 5.0, 75, '[\"cansancio\", \"tensión\"]', 'Campus Central', '2025-11-21 20:06:58', NULL),
(20, 2, '2025-11-17 14:00:00', 'bien', 6, 6.5, 50, '[\"cansancio leve\"]', 'Residencia Estudiantil', '2025-11-21 20:06:58', NULL),
(21, 2, '2025-11-18 14:10:00', 'neutral', 5, 6.0, 55, '[\"tensión\"]', 'Residencia Estudiantil', '2025-11-21 20:06:58', NULL),
(22, 2, '2025-11-19 14:05:00', 'mal', 5, 5.5, 65, '[\"estresado\", \"dolor de cabeza\"]', 'Residencia Estudiantil', '2025-11-21 20:06:58', NULL),
(23, 2, '2025-11-20 14:15:00', 'mal', 4, 5.0, 70, '[\"ansiedad\", \"cansancio\"]', 'Residencia Estudiantil', '2025-11-21 20:06:58', NULL),
(24, 2, '2025-11-21 14:20:00', 'neutral', 5, 5.5, 60, '[\"tensión leve\"]', 'Residencia Estudiantil', '2025-11-21 20:06:58', NULL),
(25, 3, '2025-11-17 12:45:00', 'neutral', 5, 6.0, 55, '[\"cansancio\"]', 'Campus Norte', '2025-11-21 20:06:58', NULL),
(26, 3, '2025-11-18 12:50:00', 'mal', 4, 5.5, 70, '[\"agotamiento\"]', 'Campus Norte', '2025-11-21 20:06:58', NULL),
(27, 3, '2025-11-19 12:55:00', 'muy_mal', 3, 4.5, 80, '[\"insomnio\", \"ansiedad\"]', 'Campus Norte', '2025-11-21 20:06:58', NULL),
(28, 3, '2025-11-20 13:00:00', 'mal', 4, 5.0, 75, '[\"cansancio\", \"tensión\"]', 'Campus Norte', '2025-11-21 20:06:58', NULL),
(29, 3, '2025-11-21 13:05:00', 'neutral', 5, 5.5, 60, '[\"cansancio leve\"]', 'Campus Norte', '2025-11-21 20:06:58', NULL),
(30, 4, '2025-11-17 15:00:00', 'bien', 6, 7.0, 45, '[\"cansancio leve\"]', 'Campus Sur', '2025-11-21 20:06:58', NULL),
(31, 4, '2025-11-18 15:10:00', 'neutral', 5, 6.0, 55, '[\"tensión\"]', 'Campus Sur', '2025-11-21 20:06:58', NULL),
(32, 4, '2025-11-19 15:05:00', 'mal', 4, 5.0, 70, '[\"estresada\", \"dolor de cabeza\"]', 'Campus Sur', '2025-11-21 20:06:58', NULL),
(33, 4, '2025-11-20 15:15:00', 'mal', 4, 5.0, 65, '[\"ansiedad\"]', 'Campus Sur', '2025-11-21 20:06:58', NULL),
(34, 4, '2025-11-21 15:20:00', 'neutral', 5, 6.0, 55, '[\"cansancio leve\"]', 'Campus Sur', '2025-11-21 20:06:58', NULL),
(35, 5, '2025-11-17 16:00:00', 'bien', 7, 7.0, 40, '[\"cansancio leve\"]', 'Campus Central', '2025-11-21 20:06:58', NULL),
(36, 5, '2025-11-18 16:10:00', 'neutral', 6, 6.5, 50, '[\"estrés leve\"]', 'Campus Central', '2025-11-21 20:06:58', NULL),
(37, 5, '2025-11-19 16:05:00', 'mal', 5, 5.5, 65, '[\"ansiedad\"]', 'Campus Central', '2025-11-21 20:06:58', NULL),
(38, 5, '2025-11-20 16:15:00', 'mal', 4, 5.0, 70, '[\"cansancio\", \"insomnio\"]', 'Campus Central', '2025-11-21 20:06:58', NULL),
(39, 5, '2025-11-21 16:20:00', 'neutral', 5, 5.5, 55, '[\"tensión leve\"]', 'Campus Central', '2025-11-21 20:06:58', NULL),
(40, 6, '2025-11-17 13:30:00', 'neutral', 5, 6.0, 55, '[\"cansancio\"]', 'Campus Norte', '2025-11-21 20:06:58', NULL),
(41, 6, '2025-11-18 13:35:00', 'mal', 4, 5.5, 70, '[\"agotado\"]', 'Campus Norte', '2025-11-21 20:06:58', NULL),
(42, 6, '2025-11-19 13:40:00', 'muy_mal', 3, 4.0, 80, '[\"insomnio\", \"estrés extremo\"]', 'Campus Norte', '2025-11-21 20:06:58', NULL),
(43, 6, '2025-11-20 13:45:00', 'mal', 4, 5.0, 65, '[\"ansiedad\"]', 'Campus Norte', '2025-11-21 20:06:58', NULL),
(44, 6, '2025-11-21 13:50:00', 'neutral', 5, 5.5, 60, '[\"cansancio leve\"]', 'Campus Norte', '2025-11-21 20:06:58', NULL),
(45, 7, '2025-11-17 14:30:00', 'neutral', 5, 6.0, 55, '[\"cansancio\"]', 'Campus Sur', '2025-11-21 20:06:58', NULL),
(46, 7, '2025-11-18 14:35:00', 'mal', 4, 5.0, 70, '[\"agotado\", \"estresado\"]', 'Campus Sur', '2025-11-21 20:06:58', NULL),
(47, 7, '2025-11-19 14:40:00', 'mal', 4, 5.0, 65, '[\"cansancio\"]', 'Campus Sur', '2025-11-21 20:06:58', NULL),
(48, 7, '2025-11-20 14:45:00', 'neutral', 5, 5.5, 60, '[\"tensión leve\"]', 'Campus Sur', '2025-11-21 20:06:58', NULL),
(49, 7, '2025-11-21 14:50:00', 'mal', 4, 5.0, 70, '[\"estresado\"]', 'Campus Sur', '2025-11-21 20:06:58', NULL),
(50, 1, '2025-01-10 13:30:00', 'bien', 7, 7.5, 30, '[\"dolor_cabeza\"]', 'La Paz - Miraflores', '2025-11-21 20:33:20', '2025-11-21 20:33:20'),
(51, 1, '2025-01-11 13:35:00', 'neutral', 5, 6.0, 45, '[\"cansancio\",\"falta_concentracion\"]', 'La Paz - Sopocachi', '2025-11-21 20:33:20', '2025-11-21 20:33:20'),
(52, 1, '2025-01-12 13:40:00', 'mal', 3, 5.2, 68, '[\"ansiedad\",\"dolor_espalda\"]', 'La Paz - Centro', '2025-11-21 20:33:20', '2025-11-21 20:33:20'),
(53, 2, '2025-01-10 12:55:00', 'muy_bien', 9, 8.0, 15, '[]', 'El Alto - Villa Adela', '2025-11-21 20:33:20', '2025-11-21 20:33:20'),
(54, 2, '2025-01-11 12:58:00', 'bien', 6, 7.0, 25, '[\"dolor_cuello\"]', 'El Alto - Senkata', '2025-11-21 20:33:20', '2025-11-21 20:33:20'),
(55, 2, '2025-01-12 13:00:00', 'neutral', 5, 6.5, 40, '[\"cansancio\"]', 'El Alto - 12 de Octubre', '2025-11-21 20:33:20', '2025-11-21 20:33:20'),
(56, 3, '2025-01-10 14:10:00', 'mal', 3, 4.5, 70, '[\"insomnio\",\"dolor_cabeza\"]', 'Cochabamba - Cala Cala', '2025-11-21 20:33:20', '2025-11-21 20:33:20'),
(57, 3, '2025-01-11 14:15:00', 'muy_mal', 1, 3.0, 85, '[\"mareos\",\"ansiedad\",\"tension_muscular\"]', 'Cochabamba - Queru Queru', '2025-11-21 20:33:20', '2025-11-21 20:33:20'),
(58, 3, '2025-01-12 14:20:00', 'mal', 2, 4.0, 78, '[\"insomnio\"]', 'Cochabamba - Sarco', '2025-11-21 20:33:20', '2025-11-21 20:33:20'),
(59, 4, '2025-01-10 15:00:00', 'bien', 7, 7.8, 20, '[\"leve_estres_academico\"]', 'Santa Cruz - Equipetrol', '2025-11-21 20:33:20', '2025-11-21 20:33:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `student_profiles`
--

CREATE TABLE `student_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `student_code` varchar(50) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `career` varchar(100) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `group_name` varchar(100) DEFAULT NULL,
  `consent_given` tinyint(1) NOT NULL DEFAULT 0,
  `consent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `student_profiles`
--

INSERT INTO `student_profiles` (`id`, `user_id`, `student_code`, `birthdate`, `career`, `semester`, `group_name`, `consent_given`, `consent_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'STU001', '2002-01-15', 'Medicina', 5, 'A', 1, '2025-11-21 19:42:11', '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(2, 2, 'STU002', '2001-05-22', 'Odontología', 6, 'B', 1, '2025-11-21 19:42:11', '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(3, 3, 'STU003', '2003-03-10', 'Enfermería', 4, 'C', 0, NULL, '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(4, 4, 'STU004', '2002-08-30', 'Medicina', 5, 'A', 1, '2025-11-21 19:42:11', '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(5, 5, 'STU005', '2001-12-05', 'Fisioterapia', 7, 'B', 0, NULL, '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(6, 6, 'STU006', '2003-02-17', 'Nutrición', 3, 'C', 1, '2025-11-21 19:42:11', '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(7, 7, 'STU007', '2002-07-25', 'Medicina', 6, 'A', 1, '2025-11-21 19:42:11', '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(8, 8, 'STU008', '2001-11-11', 'Odontología', 5, 'B', 1, '2025-11-21 19:42:11', '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(9, 9, 'STU009', '2003-06-02', 'Enfermería', 4, 'C', 0, NULL, '2025-11-21 19:42:11', '2025-11-21 19:42:11'),
(10, 10, 'STU010', '2002-09-19', 'Fisioterapia', 6, 'A', 1, '2025-11-21 19:42:11', '2025-11-21 19:42:11', '2025-11-21 19:42:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `student_rotation`
--

CREATE TABLE `student_rotation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_profile_id` bigint(20) UNSIGNED NOT NULL,
  `rotation_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_at` timestamp NULL DEFAULT NULL,
  `shift_type` enum('dia','noche','36h','otro') DEFAULT 'dia',
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `student_rotation`
--

INSERT INTO `student_rotation` (`id`, `student_profile_id`, `rotation_id`, `assigned_at`, `shift_type`, `notes`) VALUES
(1, 1, 1, '2025-11-21 19:42:11', 'dia', 'Asignación inicial'),
(2, 2, 2, '2025-11-21 19:42:11', 'noche', 'Rotación pediatría nocturna'),
(3, 3, 3, '2025-11-21 19:42:11', '36h', 'Rotación rural de 36 horas'),
(4, 4, 4, '2025-11-21 19:42:11', 'dia', 'Cirugía general'),
(5, 5, 5, '2025-11-21 19:42:11', 'otro', 'Rotación odontología especial'),
(6, 6, 6, '2025-11-21 19:42:11', 'dia', 'Enfermería en hospital general'),
(7, 7, 7, '2025-11-21 19:42:11', 'noche', 'Turno nocturno nutrición'),
(8, 8, 8, '2025-11-21 19:42:11', 'dia', 'Fisioterapia avanzada'),
(9, 9, 9, '2025-11-21 19:42:11', '36h', 'Cardiología prolongada'),
(10, 10, 10, '2025-11-21 19:42:11', 'dia', 'Ginecología rutina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `paternal_surname` varchar(100) DEFAULT NULL,
  `maternal_surname` varchar(100) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `paternal_surname`, `maternal_surname`, `phone`, `address`, `is_active`, `last_login_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'juan.perez@example.com', 'password123', 'Juan', 'Perez', 'Gomez', '123456789', 'Calle Falsa 123', 1, NULL, NULL, '2025-11-21 19:42:11', '2025-11-21 19:42:11', NULL),
(2, 'maria.lopez@example.com', 'password123', 'Maria', 'Lopez', 'Diaz', '987654321', 'Av. Siempre Viva 742', 1, NULL, NULL, '2025-11-21 19:42:11', '2025-11-21 19:42:11', NULL),
(3, 'carlos.garcia@example.com', 'password123', 'Carlos', 'Garcia', 'Martinez', '456789123', 'Calle Luna 45', 1, NULL, NULL, '2025-11-21 19:42:11', '2025-11-21 19:42:11', NULL),
(4, 'ana.morales@example.com', 'password123', 'Ana', 'Morales', 'Fernandez', '321654987', 'Av. Sol 56', 1, NULL, NULL, '2025-11-21 19:42:11', '2025-11-21 19:42:11', NULL),
(5, 'luis.ramirez@example.com', 'password123', 'Luis', 'Ramirez', 'Torres', '789123456', 'Calle Estrella 89', 1, NULL, NULL, '2025-11-21 19:42:11', '2025-11-21 19:42:11', NULL),
(6, 'sofia.mendoza@example.com', 'password123', 'Sofia', 'Mendoza', 'Rojas', '654321987', 'Av. Mar 12', 1, NULL, NULL, '2025-11-21 19:42:11', '2025-11-21 19:42:11', NULL),
(7, 'diego.sanchez@example.com', 'password123', 'Diego', 'Sanchez', 'Vargas', '147258369', 'Calle Cielo 34', 1, NULL, NULL, '2025-11-21 19:42:11', '2025-11-21 19:42:11', NULL),
(8, 'laura.gomez@example.com', 'password123', 'Laura', 'Gomez', 'Castillo', '369258147', 'Av. Tierra 78', 1, NULL, NULL, '2025-11-21 19:42:11', '2025-11-21 19:42:11', NULL),
(9, 'pedro.navarro@example.com', 'password123', 'Pedro', 'Navarro', 'Alvarez', '258369147', 'Calle Agua 23', 1, NULL, NULL, '2025-11-21 19:42:11', '2025-11-21 19:42:11', NULL),
(10, 'valentina.rivera@example.com', 'password123', 'Valentina', 'Rivera', 'Lopez', '963852741', 'Av. Fuego 67', 1, NULL, NULL, '2025-11-21 19:42:11', '2025-11-21 19:42:11', NULL),
(11, 'prof1@example.com', 'password_hash', 'Ana', 'Perez', 'Lopez', NULL, NULL, 1, NULL, NULL, '2025-11-21 20:03:44', NULL, NULL),
(12, 'prof2@example.com', 'password_hash', 'Luis', 'Gomez', 'Diaz', NULL, NULL, 1, NULL, NULL, '2025-11-21 20:03:44', NULL, NULL),
(13, 'prof3@example.com', 'password_hash', 'Carla', 'Martinez', 'Suarez', NULL, NULL, 1, NULL, NULL, '2025-11-21 20:03:44', NULL, NULL),
(14, 'prof4@example.com', 'password_hash', 'Mario', 'Fernandez', 'Rojas', NULL, NULL, 1, NULL, NULL, '2025-11-21 20:03:44', NULL, NULL),
(15, 'prof5@example.com', 'password_hash', 'Sofia', 'Vargas', 'Mendez', NULL, NULL, 1, NULL, NULL, '2025-11-21 20:03:44', NULL, NULL),
(47, 'ftanzorozco2@gmail.com', '$2y$12$.WEiNYXXAq0YBKa9cmBv5uuR7R.GMMbXWuVG284EG73bpzvUFAFVq', 'Franz Orozco Salazar', NULL, NULL, NULL, NULL, 1, NULL, NULL, '2025-11-22 01:53:25', '2025-11-22 01:53:25', NULL),
(48, 'admin@burnout.com', '$2y$12$Nd3ckvin3oepvr/2fCiO/uHSEY/a1jjyhg9ROFWosotaMZV0xcdCK', 'Administrador', NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-06-08 07:22:22', '2026-06-08 07:22:22', NULL),
(49, 'estudiante@burnout.com', '$2y$12$ZiJQrOdlYMrPUKKC344WV.GNiVIk6.OwQZMV9XtPnF9b4jhpx5xc2', 'Estudiante Prueba', NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-06-08 07:22:22', '2026-06-08 07:22:22', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_profile_id` (`student_profile_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_prof_sched` (`professional_id`,`scheduled_at`);

--
-- Indices de la tabla `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `chatbot_alerts`
--
ALTER TABLE `chatbot_alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chatbot_interaction_id` (`chatbot_interaction_id`),
  ADD KEY `student_profile_id` (`student_profile_id`),
  ADD KEY `resolved_by` (`resolved_by`);

--
-- Indices de la tabla `chatbot_interactions`
--
ALTER TABLE `chatbot_interactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_session` (`session_id`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent_comment_id` (`parent_comment_id`);

--
-- Indices de la tabla `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_user_id` (`owner_user_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_id` (`model_id`),
  ADD KEY `assigned_by` (`assigned_by`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`is_read`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);
ALTER TABLE `posts` ADD FULLTEXT KEY `ft_posts_title_body` (`title`,`body`);

--
-- Indices de la tabla `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`post_id`,`tag`);

--
-- Indices de la tabla `post_votes`
--
ALTER TABLE `post_votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indices de la tabla `professionals`
--
ALTER TABLE `professionals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indices de la tabla `questionnaires`
--
ALTER TABLE `questionnaires`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `created_by` (`created_by`);

--
-- Indices de la tabla `questionnaire_choices`
--
ALTER TABLE `questionnaire_choices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indices de la tabla `questionnaire_items`
--
ALTER TABLE `questionnaire_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questionnaire_id` (`questionnaire_id`);

--
-- Indices de la tabla `questionnaire_responses`
--
ALTER TABLE `questionnaire_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questionnaire_id` (`questionnaire_id`),
  ADD KEY `student_profile_id` (`student_profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `validated_by` (`validated_by`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`);

--
-- Indices de la tabla `rotations`
--
ALTER TABLE `rotations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `state_reports`
--
ALTER TABLE `state_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_student_report` (`student_profile_id`,`report_date`);

--
-- Indices de la tabla `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `student_code` (`student_code`);

--
-- Indices de la tabla `student_rotation`
--
ALTER TABLE `student_rotation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_profile_id` (`student_profile_id`),
  ADD KEY `rotation_id` (`rotation_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `chatbot_alerts`
--
ALTER TABLE `chatbot_alerts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `chatbot_interactions`
--
ALTER TABLE `chatbot_interactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `post_votes`
--
ALTER TABLE `post_votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `professionals`
--
ALTER TABLE `professionals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `questionnaires`
--
ALTER TABLE `questionnaires`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `questionnaire_choices`
--
ALTER TABLE `questionnaire_choices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT de la tabla `questionnaire_items`
--
ALTER TABLE `questionnaire_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT de la tabla `questionnaire_responses`
--
ALTER TABLE `questionnaire_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `resources`
--
ALTER TABLE `resources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `rotations`
--
ALTER TABLE `rotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `state_reports`
--
ALTER TABLE `state_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `student_profiles`
--
ALTER TABLE `student_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `student_rotation`
--
ALTER TABLE `student_rotation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`student_profile_id`) REFERENCES `student_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`professional_id`) REFERENCES `professionals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `chatbot_alerts`
--
ALTER TABLE `chatbot_alerts`
  ADD CONSTRAINT `chatbot_alerts_ibfk_1` FOREIGN KEY (`chatbot_interaction_id`) REFERENCES `chatbot_interactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chatbot_alerts_ibfk_2` FOREIGN KEY (`student_profile_id`) REFERENCES `student_profiles` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `chatbot_alerts_ibfk_3` FOREIGN KEY (`resolved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `chatbot_interactions`
--
ALTER TABLE `chatbot_interactions`
  ADD CONSTRAINT `chatbot_interactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`parent_comment_id`) REFERENCES `comments` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`owner_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_ibfk_1` FOREIGN KEY (`model_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `model_has_roles_ibfk_2` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `post_tags`
--
ALTER TABLE `post_tags`
  ADD CONSTRAINT `post_tags_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `post_votes`
--
ALTER TABLE `post_votes`
  ADD CONSTRAINT `post_votes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_votes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_votes_ibfk_3` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `professionals`
--
ALTER TABLE `professionals`
  ADD CONSTRAINT `professionals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `questionnaires`
--
ALTER TABLE `questionnaires`
  ADD CONSTRAINT `questionnaires_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `questionnaire_choices`
--
ALTER TABLE `questionnaire_choices`
  ADD CONSTRAINT `questionnaire_choices_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `questionnaire_items` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `questionnaire_items`
--
ALTER TABLE `questionnaire_items`
  ADD CONSTRAINT `questionnaire_items_ibfk_1` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `questionnaire_responses`
--
ALTER TABLE `questionnaire_responses`
  ADD CONSTRAINT `questionnaire_responses_ibfk_1` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `questionnaire_responses_ibfk_2` FOREIGN KEY (`student_profile_id`) REFERENCES `student_profiles` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `questionnaire_responses_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `resources_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `resources_ibfk_2` FOREIGN KEY (`validated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `state_reports`
--
ALTER TABLE `state_reports`
  ADD CONSTRAINT `state_reports_ibfk_1` FOREIGN KEY (`student_profile_id`) REFERENCES `student_profiles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD CONSTRAINT `student_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `student_rotation`
--
ALTER TABLE `student_rotation`
  ADD CONSTRAINT `student_rotation_ibfk_1` FOREIGN KEY (`student_profile_id`) REFERENCES `student_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_rotation_ibfk_2` FOREIGN KEY (`rotation_id`) REFERENCES `rotations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
