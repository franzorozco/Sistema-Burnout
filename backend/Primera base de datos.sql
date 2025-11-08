-- 1. Roles y permisos



-- 2. Usuarios
CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  name VARCHAR(100) NOT NULL,
  paternal_surname VARCHAR(100) NULL,
  maternal_surname VARCHAR(100) NULL,
  phone VARCHAR(30),
  address VARCHAR(255),
  is_active BOOLEAN NOT NULL DEFAULT TRUE,
  last_login_at TIMESTAMP NULL,
  remember_token varchar(100) DEFAULT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  deleted_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE model_has_permissions (
  permission_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  model_type varchar(255) NOT NULL,
  model_id bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE permissions (
  id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(255) NOT NULL,
  guard_name varchar(255) NOT NULL,
  created_at timestamp NULL DEFAULT NULL,
  updated_at timestamp NULL DEFAULT NULL,
  deleted_at TIMESTAMP NULL DEFAULT NULL -- Soft delete
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE roles (
  id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(255) NOT NULL,
  guard_name varchar(255) NOT NULL,
  created_at timestamp NULL DEFAULT NULL,
  description VARCHAR(255) NULL,
  created_by BIGINT UNSIGNED NULL,
  updated_at timestamp NULL DEFAULT NULL,
  deleted_at TIMESTAMP NULL DEFAULT NULL, -- Soft delete
  FOREIGN KEY (created_by) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE role_has_permissions (
  permission_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  role_id bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE model_has_roles (
  role_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  model_type varchar(255) NOT NULL,
  model_id bigint(20) UNSIGNED NOT NULL,
  assigned_by BIGINT UNSIGNED NULL,
  FOREIGN KEY (model_id) REFERENCES users (id) ON DELETE CASCADE,
  FOREIGN KEY (assigned_by) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- 3. Perfiles de estudiante y rotaciones
CREATE TABLE student_profiles (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL UNIQUE,
  student_code VARCHAR(50) UNIQUE,
  birthdate DATE,
  career VARCHAR(100),
  semester INT,
  group_name VARCHAR(100),
  consent_given BOOLEAN NOT NULL DEFAULT FALSE,
  consent_at TIMESTAMP NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE rotations (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  location VARCHAR(200),
  start_date DATE,
  end_date DATE,
  is_rural BOOLEAN DEFAULT FALSE,
  details TEXT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE student_rotation (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  student_profile_id BIGINT UNSIGNED NOT NULL,
  rotation_id BIGINT UNSIGNED NOT NULL,
  assigned_at TIMESTAMP NULL,
  shift_type ENUM('dia','noche','36h','otro') DEFAULT 'dia',
  notes TEXT,
  FOREIGN KEY (student_profile_id) REFERENCES student_profiles(id) ON DELETE CASCADE,
  FOREIGN KEY (rotation_id) REFERENCES rotations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Cuestionarios y formularios (para autoevaluaciones)
CREATE TABLE questionnaires (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(50) NOT NULL UNIQUE,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  version VARCHAR(20),
  created_by BIGINT UNSIGNED NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 
CREATE TABLE questionnaire_items (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  questionnaire_id BIGINT UNSIGNED NOT NULL,
  item_order INT NOT NULL,
  question_text TEXT NOT NULL,
  response_type ENUM('likert','booleano','numero','texto','opcion') NOT NULL DEFAULT 'likert',
  meta JSON NULL,
  FOREIGN KEY (questionnaire_id) REFERENCES questionnaires(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 
CREATE TABLE questionnaire_choices (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  item_id BIGINT UNSIGNED NOT NULL,
  choice_order INT NOT NULL,
  value VARCHAR(100),
  label VARCHAR(255),
  FOREIGN KEY (item_id) REFERENCES questionnaire_items(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE questionnaire_responses (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  questionnaire_id BIGINT UNSIGNED NOT NULL,
  student_profile_id BIGINT UNSIGNED NULL,
  user_id BIGINT UNSIGNED NULL,
  submitted_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  summary_score DOUBLE NULL, -- calculo agregado
  raw JSON NULL, -- almacenar pares pregunta->respuesta si se desea
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (questionnaire_id) REFERENCES questionnaires(id) ON DELETE CASCADE,
  FOREIGN KEY (student_profile_id) REFERENCES student_profiles(id) ON DELETE SET NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Reportes periodicos de estado (registro de estres)
CREATE TABLE state_reports (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  student_profile_id BIGINT UNSIGNED NOT NULL,
  report_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  mood ENUM('muy_bien','bien','neutral','mal','muy_mal') NULL,
  energy_level INT NULL, -- 0-10
  sleep_hours DECIMAL(4,1) NULL,
  stress_score INT NULL, -- 0-100 o escala propia
  symptoms JSON NULL, -- lista de sintomas reportados
  location VARCHAR(200) NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (student_profile_id) REFERENCES student_profiles(id) ON DELETE CASCADE,
  INDEX idx_student_report (student_profile_id, report_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Chatbot: interacciones, deteccion y alertas
CREATE TABLE chatbot_interactions (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NULL,
  session_id VARCHAR(191) NULL, -- para agrupar interacciones
  input_text TEXT,
  input_metadata JSON NULL,
  response_text TEXT,
  response_metadata JSON NULL,
  intent VARCHAR(200) NULL,
  sentiment JSON NULL,
  detected_risk BOOLEAN DEFAULT FALSE,
  detected_keywords JSON NULL,
  created_at TIMESTAMP NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_session (session_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE chatbot_alerts (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  chatbot_interaction_id BIGINT UNSIGNED NOT NULL,
  student_profile_id BIGINT UNSIGNED NULL,
  alert_type ENUM('alto_estres','sin_reporte','riesgo_palabra_clave','solicitud_manual','otro') NOT NULL,
  severity ENUM('bajo','medio','alto','critico') NOT NULL DEFAULT 'medio',
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  resolved_at TIMESTAMP NULL,
  resolved_by BIGINT UNSIGNED NULL,
  notes TEXT,
  FOREIGN KEY (chatbot_interaction_id) REFERENCES chatbot_interactions(id) ON DELETE CASCADE,
  FOREIGN KEY (student_profile_id) REFERENCES student_profiles(id) ON DELETE SET NULL,
  FOREIGN KEY (resolved_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Profesionales y agenda
CREATE TABLE professionals (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL UNIQUE,
  profession ENUM('psicologo','psiquiatra','terapeuta_ocupacional','otro') NOT NULL,
  license_number VARCHAR(100),
  bio TEXT,
  is_available BOOLEAN DEFAULT TRUE,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE appointments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  student_profile_id BIGINT UNSIGNED NOT NULL,
  professional_id BIGINT UNSIGNED NOT NULL,
  scheduled_at TIMESTAMP NOT NULL,
  duration_minutes INT DEFAULT 30,
  status ENUM('pendiente','confirmado','completado','cancelado','no_asistio') DEFAULT 'pendiente',
  notes TEXT,
  created_by BIGINT UNSIGNED NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (student_profile_id) REFERENCES student_profiles(id) ON DELETE CASCADE,
  FOREIGN KEY (professional_id) REFERENCES professionals(id) ON DELETE CASCADE,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_prof_sched (professional_id, scheduled_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. Recursos (articulos, videos, ejercicios)
CREATE TABLE resources (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  type ENUM('articulo','video','ejercicio','pdf','enlace','otro') DEFAULT 'articulo',
  summary TEXT,
  content TEXT, -- or URL/markdown
  url VARCHAR(1024) NULL,
  author_id BIGINT UNSIGNED NULL,
  validated_by BIGINT UNSIGNED NULL, -- profesional que valido el recurso
  validated_at TIMESTAMP NULL,
  tags JSON NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (validated_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 9. Sistema tipo Reddit: posts, comentarios, votos, tags
CREATE TABLE posts (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  title VARCHAR(255) NOT NULL,
  body TEXT NOT NULL,
  is_anonymous BOOLEAN DEFAULT FALSE, -- opcion para publicar anonimamente
  score INT DEFAULT 0,
  views INT DEFAULT 0,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL,
  deleted_at TIMESTAMP NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FULLTEXT KEY ft_posts_title_body (title, body) -- si MySQL lo soporta
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE comments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  post_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  parent_comment_id BIGINT UNSIGNED NULL,
  body TEXT NOT NULL,
  score INT DEFAULT 0,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL,
  deleted_at TIMESTAMP NULL,
  FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (parent_comment_id) REFERENCES comments(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE post_votes (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  post_id BIGINT UNSIGNED NULL,
  comment_id BIGINT UNSIGNED NULL,
  vote TINYINT NOT NULL, -- 1 upvote, -1 downvote
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
  FOREIGN KEY (comment_id) REFERENCES comments(id) ON DELETE CASCADE,
  CHECK ( (post_id IS NOT NULL AND comment_id IS NULL) OR (post_id IS NULL AND comment_id IS NOT NULL) )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE post_tags (
  post_id BIGINT UNSIGNED NOT NULL,
  tag VARCHAR(100) NOT NULL,
  PRIMARY KEY (post_id, tag),
  FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 10. Archivos y multimedia (almacenamiento externo)
CREATE TABLE files (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  owner_user_id BIGINT UNSIGNED NULL,
  related_type VARCHAR(100) NULL, -- e.g., 'post','resource','profile','evidence'
  related_id BIGINT UNSIGNED NULL,
  filename VARCHAR(255) NOT NULL,
  url VARCHAR(1024) NOT NULL,
  mime_type VARCHAR(100),
  size_bytes BIGINT UNSIGNED NULL,
  checksum VARCHAR(128) NULL,
  created_at TIMESTAMP NULL,
  FOREIGN KEY (owner_user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




-- 12. Notifications y audit log: seguimiento de notificaciones y acciones de usuarios

-- Tabla para almacenar notificaciones a usuarios
CREATE TABLE notifications (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, -- ID único de la notificación
  user_id BIGINT UNSIGNED NOT NULL, -- ID del usuario al que va dirigida
  type VARCHAR(100) NOT NULL, -- Tipo de notificación (ej. info, alerta)
  payload JSON NULL, -- Información adicional de la notificación en JSON
  is_read BOOLEAN DEFAULT FALSE, -- Estado de lectura de la notificación
  created_at TIMESTAMP NULL, -- Fecha de creación de la notificación
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, -- Si se elimina el usuario, también se eliminan sus notificaciones
  INDEX (user_id, is_read) -- Índice para consultas de notificaciones no leídas
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla para registrar auditoría de acciones de usuarios
CREATE TABLE audit_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, -- ID único del log
  user_id BIGINT UNSIGNED NULL, -- ID del usuario que realizó la acción (puede ser NULL)
  action VARCHAR(100) NOT NULL, -- Acción realizada (ej. INSERT, UPDATE, DELETE)
  table_name VARCHAR(100) NULL, -- Nombre de la tabla afectada
  record_id VARCHAR(100) NULL, -- ID del registro afectado
  old_data JSON NULL, -- Estado anterior del registro en JSON
  new_data JSON NULL, -- Estado nuevo del registro en JSON
  ip_address VARCHAR(50) NULL, -- IP desde donde se realizó la acción
  user_agent VARCHAR(255) NULL, -- Información del navegador/dispositivo
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP, -- Fecha y hora de la acción
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL -- Si se elimina el usuario, se conserva el log pero con user_id NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;








CREATE TABLE cache (
    `key` varchar(255) NOT NULL,
    value mediumtext NOT NULL,
    expiration int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estructura de tabla para la tabla cache_locks

CREATE TABLE cache_locks (
  `key` varchar(255) NOT NULL,
  owner varchar(255) NOT NULL,
  expiration int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estructura de tabla para la tabla failed_jobs

CREATE TABLE failed_jobs (
  id bigint(20) UNSIGNED NOT NULL,
  uuid varchar(255) NOT NULL,
  connection text NOT NULL,
  queue text NOT NULL,
  payload longtext NOT NULL,
  exception longtext NOT NULL,
  failed_at timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estructura de tabla para la tabla jobs

CREATE TABLE jobs (
  id bigint(20) UNSIGNED NOT NULL,
  queue varchar(255) NOT NULL,
  payload longtext NOT NULL,
  attempts tinyint(3) UNSIGNED NOT NULL,
  reserved_at int(10) UNSIGNED DEFAULT NULL,
  available_at int(10) UNSIGNED NOT NULL,
  created_at int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estructura de tabla para la tabla job_batches

CREATE TABLE job_batches (
  id varchar(255) NOT NULL,
  name varchar(255) NOT NULL,
  total_jobs int(11) NOT NULL,
  pending_jobs int(11) NOT NULL,
  failed_jobs int(11) NOT NULL,
  failed_job_ids longtext NOT NULL,
  options mediumtext DEFAULT NULL,
  cancelled_at int(11) DEFAULT NULL,
  created_at int(11) NOT NULL,
  finished_at int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estructura de tabla para la tabla password_reset_tokens

CREATE TABLE password_reset_tokens (
  email varchar(255) NOT NULL,
  token varchar(255) NOT NULL,
  created_at timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Estructura de tabla para la tabla sessions

CREATE TABLE sessions (
  id varchar(255) NOT NULL,
  user_id bigint(20) UNSIGNED DEFAULT NULL,
  ip_address varchar(45) DEFAULT NULL,
  user_agent text DEFAULT NULL,
  payload longtext NOT NULL,
  last_activity int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;