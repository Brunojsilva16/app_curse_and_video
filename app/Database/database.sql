-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16-Out-2025 às 20:30
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `conecta_app`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `instructor` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('published','draft') NOT NULL DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `workload` int(11) DEFAULT NULL,
  `target_audience` varchar(255) DEFAULT NULL,
  `format` varchar(255) DEFAULT NULL,
  `level` varchar(100) DEFAULT NULL,
  `modality` varchar(100) DEFAULT NULL,
  `category` enum('essential','premium','platinum') NOT NULL DEFAULT 'essential'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `instructor`, `price`, `image_url`, `status`, `created_at`, `workload`, `target_audience`, `format`, `level`, `modality`, `category`) VALUES
(1, 'Introdução à Psicologia Positiva', 'Descubra os fundamentos da psicologia positiva e aprenda a aplicar os seus princípios para uma vida mais feliz e realizada.', 'Dra. Sofia Almeida', 179.90, '/assets/img-courses/68eed021ec006-pexels-photo-3771120.webp', 'published', '2025-10-15 19:46:11', 40, 'Estudantes de psicologia, terapeutas e público geral.', 'Vídeo-aulas e leituras', 'Iniciante', 'Online', 'essential'),
(2, 'Técnicas de Mindfulness para Redução de Stress', 'Aprenda práticas de mindfulness e meditação para gerir o stress do dia a dia, aumentar o foco e promover o bem-estar mental.', 'Dr. Marcos Oliveira', 199.50, '/assets/img-courses/68eed04aa91ad-pexels-photo-3621180.jpeg', 'published', '2025-10-15 19:46:11', 30, 'Qualquer pessoa que queira reduzir o stress.', 'Áudios guiados', 'Iniciante', 'Online', 'essential'),
(3, 'Comunicação Não-Violenta nas Relações', 'Transforme as suas relações através de uma comunicação mais empática e eficaz.', 'Clara Mendes', 249.90, '/assets/img-courses/68eed1941f49d-pexels-photo-8468726.jpeg', 'published', '2025-10-15 19:46:11', 25, 'Todos os interessados em melhorar a comunicação.', 'Vídeos e exercícios práticos', 'Intermediário', 'Online', 'premium'),
(4, 'Fundamentos da Terapia de Casal', 'Um curso essencial para terapeutas que desejam compreender as dinâmicas dos relacionamentos.', 'Dr. Ricardo Bastos', 349.00, '/assets/img-courses/68eed2256afc7-pexels-photo-7533347.jpeg', 'published', '2025-10-15 19:46:11', 50, 'Psicólogos e terapeutas', 'Estudo de casos', 'Avançado', 'Online', 'premium'),
(5, 'Inteligência Emocional: Teoria e Prática', 'Desenvolva a sua inteligência emocional para tomar melhores decisões e melhorar as suas relações.', 'Beatriz Costa', 219.90, '/assets/img-courses/68eed08c4ff3e-pexels-photo-7841793.webp', 'published', '2025-10-15 19:46:11', 35, 'Profissionais e estudantes de todas as áreas.', 'Aulas teóricas e práticas', 'Todos os níveis', 'Online', 'essential'),
(6, 'Psicologia do Desenvolvimento Infantil', 'Explore as fases do desenvolvimento infantil, desde o nascimento até à adolescência.', 'Dra. Helena Martins', 299.00, '/assets/img-courses/68eed169a8003-pexels-photo-3932929.jpeg', 'published', '2025-10-15 19:46:11', 60, 'Pais, educadores e profissionais da saúde infantil.', 'Vídeo-aulas', 'Intermediário', 'Online', 'premium'),
(7, 'Como Lidar com a Ansiedade Social', 'Este curso oferece ferramentas práticas baseadas na TCC para gerir e superar a ansiedade social.', 'Felipe Rocha', 189.90, '/assets/img-courses/68ed8a8e0fcfd-Captura de tela 2023-01-27 144340.png', 'published', '2025-10-15 19:46:11', 20, 'Pessoas com ansiedade social.', 'Exercícios práticos', 'Todos os níveis', 'Online', 'essential'),
(8, 'Neurociência para Terapeutas', 'Compreenda como o cérebro funciona e de que forma a neurociência pode enriquecer a prática clínica.', 'Dr. Lucas Farias', 399.00, '/assets/img-courses/68eed2466ec85-pexels-photo-2280571.webp', 'published', '2025-10-15 19:46:11', 100, 'Psicólogos, psiquiatras e neurocientistas.', 'Aulas expositivas', 'Avançado', 'Online', 'platinum'),
(9, 'O Poder do Hábito', 'Aprenda como os hábitos são formados e como pode criar rotinas positivas para alcançar os seus objetivos.', 'Júlia Nunes', 159.50, '/assets/img-courses/68ed8aa4aa79b-transferir.jpg', 'published', '2025-10-15 19:46:11', 25, 'Qualquer pessoa interessada em desenvolvimento pessoal.', 'Ferramentas de planejamento', 'Iniciante', 'Online', 'essential'),
(10, 'Terapia de Aceitação e Compromisso (ACT)', 'Uma introdução aos conceitos da Terapia de Aceitação e Compromisso para aumentar a flexibilidade psicológica.', 'Mariana Esteves', 279.90, '/assets/img-courses/68eed14aa4b78-pexels-photo-3913025.webp', 'published', '2025-10-15 19:46:11', 45, 'Terapeutas e estudantes de psicologia.', 'Aulas e meditações guiadas', 'Intermediário', 'Online', 'premium'),
(11, 'Gestão de Tempo para Terapeutas', 'Aprenda a organizar sua agenda, otimizar atendimentos e aumentar sua produtividade sem sacrificar o bem-estar.', 'Dra. Ana Carolina', 229.00, NULL, 'published', '2025-10-16 23:29:50', 20, 'Terapeutas, psicólogos e profissionais da saúde mental.', 'Vídeo-aulas e exercícios práticos.', 'Intermediário', 'Online', 'premium'),
(12, 'Marketing Digital para Psicólogos', 'Descubra como divulgar seu trabalho de forma ética e eficaz, atraindo os pacientes certos para sua clínica.', 'Prof. Ricardo Gomes', 350.00, NULL, 'published', '2025-10-16 23:29:50', 30, 'Psicólogos, terapeutas e estudantes de psicologia.', 'Aulas ao vivo e gravadas.', 'Todos os níveis', 'Online', 'platinum'),
(13, 'Workshop: Introdução à Terapia Cognitivo-Comportamental (TCC)', 'Um workshop intensivo sobre os conceitos e técnicas fundamentais da TCC.', 'Dr. Felipe Moreira', 99.90, NULL, 'published', '2025-10-16 23:29:50', 8, 'Estudantes e profissionais iniciantes em psicologia.', 'Online Ao Vivo', 'Iniciante', 'Workshop', 'essential'),
(14, 'Workshop: Ferramentas de Avaliação Psicológica', 'Conheça e pratique o uso de importantes ferramentas de avaliação no contexto clínico.', 'Dra. Letícia Barros', 120.00, NULL, 'published', '2025-10-16 23:29:50', 10, 'Psicólogos e estudantes avançados.', 'Prático e Interativo', 'Intermediário', 'Workshop', 'premium'),
(15, 'Workshop: Primeiros Socorros Psicológicos', 'Aprenda a oferecer suporte inicial a pessoas em crise ou sofrimento agudo.', 'Enf. Mário Sérgio', 79.00, NULL, 'published', '2025-10-16 23:29:50', 6, 'Público geral, profissionais da saúde e educação.', 'Teórico-prático', 'Básico', 'Workshop', 'essential'),
(16, 'Workshop: Ética e Redes Sociais na Psicologia', 'Navegue pelos desafios éticos da presença digital do psicólogo.', 'Dra. Patrícia Valente', 150.00, NULL, 'published', '2025-10-16 23:29:50', 4, 'Psicólogos e estudantes de psicologia.', 'Expositivo com discussão de casos', 'Todos os níveis', 'Workshop', 'platinum');

-- --------------------------------------------------------

--
-- Estrutura da tabela `interested_users`
--

CREATE TABLE `interested_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_courses`
--

CREATE TABLE `user_courses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `status` enum('Em Andamento','Finalizado') NOT NULL DEFAULT 'Em Andamento',
  `access_granted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `user_courses`
--

INSERT INTO `user_courses` (`id`, `user_id`, `course_id`, `status`, `access_granted_at`) VALUES
(1, 2, 1, 'Em Andamento', '2025-10-15 19:46:11'),
(2, 2, 2, 'Finalizado', '2025-10-15 19:46:11'),
(3, 3, 4, 'Em Andamento', '2025-10-15 19:46:11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_app`
--

CREATE TABLE `users_app` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `subscription_plan` enum('none','essential','premium') NOT NULL DEFAULT 'none',
  `subscription_expires_at` datetime DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `password_reset_expires` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users_app`
--

INSERT INTO `users_app` (`id`, `name`, `email`, `cpf`, `password_hash`, `role`, `subscription_plan`, `subscription_expires_at`, `password_reset_token`, `password_reset_expires`, `created_at`) VALUES
(1, 'Bruno Admin', 'brunojsilvasuporte@gmail.com', NULL, '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG', 'admin', 'premium', NULL, NULL, NULL, '2025-10-15 19:46:11'),
(2, 'João Essencial', 'essential@email.com', NULL, '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG', 'user', 'essential', NULL, NULL, NULL, '2025-10-15 19:46:11'),
(3, 'Carlos Avulso', 'semplano@email.com', '111.222.333-44', '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG', 'user', 'none', NULL, NULL, NULL, '2025-10-15 19:46:11'),
(4, 'Ana Premium', 'premium@email.com', NULL, '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG', 'user', 'premium', NULL, NULL, NULL, '2025-10-15 22:56:56');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `interested_users`
--
ALTER TABLE `interested_users`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `user_courses`
--
ALTER TABLE `user_courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_course_unique` (`user_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Índices para tabela `users_app`
--
ALTER TABLE `users_app`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `interested_users`
--
ALTER TABLE `interested_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `user_courses`
--
ALTER TABLE `user_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `users_app`
--
ALTER TABLE `users_app`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `user_courses`
--
ALTER TABLE `user_courses`
  ADD CONSTRAINT `user_courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users_app` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
