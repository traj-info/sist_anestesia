-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tempo de Geração: Jul 23, 2012 as 02:26 PM
-- Versão do Servidor: 5.0.51
-- Versão do PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Banco de Dados: `traj_anestesia`
-- 

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `traj_aprovacoes`
-- 

CREATE TABLE `traj_aprovacoes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned default NULL,
  `status` int(1) default NULL,
  `obs` text,
  `controle_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Extraindo dados da tabela `traj_aprovacoes`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `traj_avaliacoes`
-- 

CREATE TABLE `traj_avaliacoes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `description` varchar(255) default NULL,
  `obs` text,
  `created` datetime default NULL,
  `filename` varchar(100) default NULL,
  `name` varchar(255) default NULL,
  `target` int(2) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- 
-- Extraindo dados da tabela `traj_avaliacoes`
-- 

INSERT INTO `traj_avaliacoes` VALUES (2, '', 'Exceto UTI', '2012-07-16 11:26:43', 'assistente', 'Médico assistente', 1);
INSERT INTO `traj_avaliacoes` VALUES (3, '', '', '2012-07-16 11:52:23', 'assistente_uti', 'Médico assistente - UTI', 1);
INSERT INTO `traj_avaliacoes` VALUES (4, '', '', '2012-07-16 11:52:51', 'supervisor', 'Médico supervisor', 3);
INSERT INTO `traj_avaliacoes` VALUES (5, '', '', '2012-07-16 12:17:49', 'coordenador', 'Coordenador de grupo', 2);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `traj_avaliacoes_groups`
-- 

CREATE TABLE `traj_avaliacoes_groups` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `group_id` int(10) unsigned default NULL,
  `avaliacao_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- 
-- Extraindo dados da tabela `traj_avaliacoes_groups`
-- 

INSERT INTO `traj_avaliacoes_groups` VALUES (17, 7, 3);
INSERT INTO `traj_avaliacoes_groups` VALUES (18, 7, 4);
INSERT INTO `traj_avaliacoes_groups` VALUES (19, 7, 5);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `traj_controles`
-- 

CREATE TABLE `traj_controles` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ref_mes` date default NULL,
  `user_id` int(10) unsigned default NULL,
  `obs` text,
  `producao_id` int(10) unsigned default NULL,
  `status` int(2) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `pontuacao` int(10) default NULL,
  `nivel` int(1) default NULL,
  `valor_hora` float(5,2) default NULL,
  `valor_total` float(10,2) default NULL,
  `valor_plantoes` float(10,2) default NULL,
  `valor_jornada` float(10,2) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

-- 
-- Extraindo dados da tabela `traj_controles`
-- 

INSERT INTO `traj_controles` VALUES (57, '2012-06-01', 65, '', 46, 1, '2012-07-16 22:59:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `traj_controles` VALUES (58, '2012-06-01', 68, '', 47, 1, '2012-07-16 22:59:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `traj_controles` VALUES (59, '2012-06-01', 69, '', 48, 1, '2012-07-16 22:59:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `traj_controles` VALUES (60, '2012-06-01', 70, '', 49, 1, '2012-07-16 22:59:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `traj_controles` VALUES (61, '2012-06-01', 71, '', 50, 1, '2012-07-16 22:59:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `traj_groups`
-- 

CREATE TABLE `traj_groups` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `supervisor_id` int(11) default NULL,
  `coordenador_id` int(11) default NULL,
  `obs` text,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Extraindo dados da tabela `traj_groups`
-- 

INSERT INTO `traj_groups` VALUES (7, 'UTI', 69, 70, '', '2012-07-16 15:23:02', NULL);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `traj_groups_users`
-- 

CREATE TABLE `traj_groups_users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `group_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

-- 
-- Extraindo dados da tabela `traj_groups_users`
-- 

INSERT INTO `traj_groups_users` VALUES (67, 65, 7);
INSERT INTO `traj_groups_users` VALUES (68, 68, 7);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `traj_logs`
-- 

CREATE TABLE `traj_logs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `description` text,
  `obs` text,
  `datetime` datetime default NULL,
  `ip` varchar(45) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Extraindo dados da tabela `traj_logs`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `traj_messages`
-- 

CREATE TABLE `traj_messages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `from_id` int(10) unsigned NOT NULL,
  `to_id` int(10) unsigned NOT NULL,
  `body` text,
  `created` datetime default NULL,
  `reference` varchar(36) default NULL,
  `obs` text,
  `read_count` int(11) default NULL,
  `last_read_datetime` datetime default NULL,
  `subject` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

-- 
-- Extraindo dados da tabela `traj_messages`
-- 

INSERT INTO `traj_messages` VALUES (1, 65, 69, 'dfsdf', '2012-07-11 00:28:04', 'A671A994-0AF7-AAFE-9218-A3B932F2A391', NULL, 1, '2012-07-12 15:36:35', 'fsdfsdfds');
INSERT INTO `traj_messages` VALUES (2, 65, 65, 'djf skdjfldjfç\r\nsçdflkjsldjfksdf', '2012-07-11 00:31:10', 'D9F46108-2A0A-9481-5B50-7D22AA94AE8F', NULL, 1, '2012-07-12 12:45:16', 'Teste 3');
INSERT INTO `traj_messages` VALUES (3, 65, 65, 'dfds', '2012-07-11 00:33:29', '9D848A19-CA92-C07E-BE53-A42BE8872802', NULL, 4, '2012-07-12 15:36:39', 'dfd');
INSERT INTO `traj_messages` VALUES (4, 65, 65, 'df sdfsdfdsf dsfs', '2012-07-11 00:35:02', '0E4AC727-7AEC-557E-BB42-0C6A2073D0FA', NULL, 3, '2012-07-12 12:43:24', 'TESTE ABC');
INSERT INTO `traj_messages` VALUES (5, 65, 65, 'dfd', '2012-07-11 00:35:52', '04C51165-FD5F-8B77-03E9-183D0168F404', NULL, 3, '2012-07-12 15:36:37', 'f dfd');
INSERT INTO `traj_messages` VALUES (6, 65, 65, 'dfd', '2012-07-11 00:44:34', '0718E933-A55B-68A5-3515-BFB1DEF76DD4', NULL, 1, '2012-07-12 16:54:36', 'dfdf');
INSERT INTO `traj_messages` VALUES (7, 65, 65, 'dfd', '2012-07-11 00:45:45', 'AC8142E5-A027-2294-06FE-D474526A84CF', NULL, 1, '2012-07-12 16:54:35', 'dfdf');
INSERT INTO `traj_messages` VALUES (8, 65, 65, 'dfd', '2012-07-11 00:48:23', '1E34C6FF-ACCE-63A9-D39E-AD8FE43DAEC1', NULL, 1, '2012-07-12 16:09:05', 'dfdf');
INSERT INTO `traj_messages` VALUES (9, 65, 65, 'dfd', '2012-07-11 00:48:40', '104AFC24-EB21-657A-15BB-E5070D920244', NULL, 1, '2012-07-12 16:54:33', 'dfdf');
INSERT INTO `traj_messages` VALUES (10, 65, 65, 'dfd', '2012-07-11 00:50:44', '10BDBA59-4736-2C45-7310-2A0BBD6F76EF', NULL, 1, '2012-07-12 16:54:32', 'dfdf');
INSERT INTO `traj_messages` VALUES (11, 65, 65, 'dfd', '2012-07-11 00:54:00', 'FB63B0BA-CD0D-14D0-367E-5D08EEEDA814', NULL, 2, '2012-07-12 15:37:06', 'dfdf');
INSERT INTO `traj_messages` VALUES (12, 65, 65, 'dfd', '2012-07-11 00:54:33', 'D8694578-7B1F-8074-201D-05292DD85B55', NULL, 1, '2012-07-12 16:09:08', 'dfdf');
INSERT INTO `traj_messages` VALUES (13, 65, 65, 'dfd', '2012-07-11 00:54:58', 'CCEE5D7F-C6B7-9C1E-23DB-8379F462A443', NULL, 1, '2012-07-12 15:36:42', 'dfdf');
INSERT INTO `traj_messages` VALUES (14, 65, 65, 'dfd', '2012-07-11 00:55:06', '768FD878-58B8-8A7C-5745-FD9E16391833', NULL, 1, '2012-07-12 15:37:12', 'dfdf');
INSERT INTO `traj_messages` VALUES (15, 65, 65, 'dfd', '2012-07-11 00:55:30', '0F2125CC-B0FE-FF0C-38C3-156194FF26DB', NULL, 1, '2012-07-12 12:56:38', 'dfdf');
INSERT INTO `traj_messages` VALUES (16, 65, 65, 'dfd', '2012-07-11 00:56:40', 'C075121F-78EB-8C77-16C8-BD1D8CE3A26F', NULL, 5, '2012-07-12 15:37:04', 'dfdf');
INSERT INTO `traj_messages` VALUES (17, 65, 68, 'dfd', '2012-07-11 00:56:40', 'C075121F-78EB-8C77-16C8-BD1D8CE3A26F', NULL, 0, NULL, 'dfdf');
INSERT INTO `traj_messages` VALUES (18, 65, 69, 'dfd', '2012-07-11 00:56:40', 'C075121F-78EB-8C77-16C8-BD1D8CE3A26F', NULL, 0, NULL, 'dfdf');
INSERT INTO `traj_messages` VALUES (19, 65, 65, 'dfd', '2012-07-11 00:57:40', 'B88A6177-F2A0-E2CB-C6D2-4C94CEEE0DD1', NULL, 2, '2012-07-12 12:53:16', 'dfdf');
INSERT INTO `traj_messages` VALUES (20, 65, 68, 'dfd', '2012-07-11 00:57:40', 'B88A6177-F2A0-E2CB-C6D2-4C94CEEE0DD1', NULL, 0, NULL, 'dfdf');
INSERT INTO `traj_messages` VALUES (21, 65, 69, 'dfd', '2012-07-11 00:57:40', 'B88A6177-F2A0-E2CB-C6D2-4C94CEEE0DD1', NULL, 0, NULL, 'dfdf');
INSERT INTO `traj_messages` VALUES (22, 65, 65, 'dfd', '2012-07-11 00:58:16', '9A172BFB-6E8D-90B0-CEF3-9BB064AC182F', NULL, 1, '2012-07-12 12:52:14', 'dfdf');
INSERT INTO `traj_messages` VALUES (23, 65, 68, 'dfd', '2012-07-11 00:58:16', '9A172BFB-6E8D-90B0-CEF3-9BB064AC182F', NULL, 0, NULL, 'dfdf');
INSERT INTO `traj_messages` VALUES (24, 65, 69, 'dfd', '2012-07-11 00:58:16', '9A172BFB-6E8D-90B0-CEF3-9BB064AC182F', NULL, 0, NULL, 'dfdf');
INSERT INTO `traj_messages` VALUES (25, 65, 65, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 00:59:05', '5E8CA531-E80F-F7CA-46CB-9E4456B11166', NULL, 3, '2012-07-12 16:53:57', 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (26, 65, 68, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 00:59:05', '5E8CA531-E80F-F7CA-46CB-9E4456B11166', NULL, 0, NULL, 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (27, 65, 69, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 00:59:05', '5E8CA531-E80F-F7CA-46CB-9E4456B11166', NULL, 0, NULL, 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (28, 65, 65, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:00:42', '845193D2-1086-DFA6-211E-7796B2E34587', NULL, 3, '2012-07-12 15:00:11', 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (29, 65, 68, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:00:42', '845193D2-1086-DFA6-211E-7796B2E34587', NULL, 0, NULL, 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (30, 65, 69, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:00:42', '845193D2-1086-DFA6-211E-7796B2E34587', NULL, 0, NULL, 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (31, 65, 65, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:01:17', '17278C81-F22C-A6CA-5DDB-968C8BB56288', NULL, 6, '2012-07-12 14:59:57', 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (32, 65, 68, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:01:17', '17278C81-F22C-A6CA-5DDB-968C8BB56288', NULL, 0, NULL, 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (33, 65, 69, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:01:17', '17278C81-F22C-A6CA-5DDB-968C8BB56288', NULL, 0, NULL, 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (34, 65, 65, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:06:15', 'DE8C56ED-0559-D10E-BC76-624AB67DBE92', NULL, 4, '2012-07-12 15:01:38', 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (35, 65, 68, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:06:15', 'DE8C56ED-0559-D10E-BC76-624AB67DBE92', NULL, 0, NULL, 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (36, 65, 69, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:06:15', 'DE8C56ED-0559-D10E-BC76-624AB67DBE92', NULL, 0, NULL, 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (37, 65, 65, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:08:01', '4ADB16F4-B25F-3489-B48E-E28FC1C37AAF', NULL, 4, '2012-07-12 14:59:55', 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (38, 65, 68, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:08:01', '4ADB16F4-B25F-3489-B48E-E28FC1C37AAF', NULL, 0, NULL, 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (39, 65, 69, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:08:01', '4ADB16F4-B25F-3489-B48E-E28FC1C37AAF', NULL, 0, NULL, 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (40, 65, 65, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:09:50', '74FB3FD7-8D59-3CC4-40CD-76B6E4C5ECBA', 'deleted', 2, '2012-07-12 15:00:10', 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (41, 65, 68, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:09:50', '74FB3FD7-8D59-3CC4-40CD-76B6E4C5ECBA', NULL, 0, NULL, 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (42, 65, 69, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:09:50', '74FB3FD7-8D59-3CC4-40CD-76B6E4C5ECBA', NULL, 0, NULL, 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (43, 65, 65, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:12:51', '68367F52-B4B0-8CAD-D159-F004849205E9', 'deleted', 8, '2012-07-12 15:36:29', 'Supposed to be deleted');
INSERT INTO `traj_messages` VALUES (44, 65, 68, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:12:51', '68367F52-B4B0-8CAD-D159-F004849205E9', NULL, 0, NULL, 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (45, 65, 69, 'sfdfd fdfdf\r\ndfldjfljdf kdsflkdlkfdl kflksdjflksdjf', '2012-07-11 01:12:51', '68367F52-B4B0-8CAD-D159-F004849205E9', NULL, 0, NULL, 'TESTE FROM A');
INSERT INTO `traj_messages` VALUES (46, 65, 69, 'E aqui vai o conteúdo da mensagem', '2012-07-11 01:13:22', 'D53412EB-C94D-0CD2-D15E-ACDDC3BA629A', NULL, 4, '2012-07-12 14:58:21', 'Aqui vai o assunto');
INSERT INTO `traj_messages` VALUES (47, 65, 70, 'E aqui vai o conteúdo da mensagem', '2012-07-11 01:13:22', 'D53412EB-C94D-0CD2-D15E-ACDDC3BA629A', 'deleted', 0, NULL, 'Aqui vai o assunto');
INSERT INTO `traj_messages` VALUES (48, 68, 65, '<p>fdd fdf lkdjfld</p>\r\n<ol>\r\n<li>s&ccedil;dfklsd<strong>jfkljsdlkj</strong>f lksdf</li>\r\n<li>s&ccedil;l kfjlksdjlkf jd</li>\r\n</ol>\r\n<p>sdjflkjsdklf</p>', '2012-07-12 16:02:51', 'C60393A3-F8E5-971A-01E7-F3E3B85F1A35', NULL, 7, '2012-07-12 16:58:37', 'AAAAAWWWW');
INSERT INTO `traj_messages` VALUES (49, 68, 68, '<p>fdd fdf lkdjfld</p>\r\n<ol>\r\n<li>s&ccedil;dfklsd<strong>jfkljsdlkj</strong>f lksdf</li>\r\n<li>s&ccedil;l kfjlksdjlkf jd</li>\r\n</ol>\r\n<p>sdjflkjsdklf</p>', '2012-07-12 16:02:51', 'C60393A3-F8E5-971A-01E7-F3E3B85F1A35', NULL, 0, NULL, 'AAAAAWWWW');
INSERT INTO `traj_messages` VALUES (50, 68, 69, '<p>fdd fdf lkdjfld</p>\r\n<ol>\r\n<li>s&ccedil;dfklsd<strong>jfkljsdlkj</strong>f lksdf</li>\r\n<li>s&ccedil;l kfjlksdjlkf jd</li>\r\n</ol>\r\n<p>sdjflkjsdklf</p>', '2012-07-12 16:02:51', 'C60393A3-F8E5-971A-01E7-F3E3B85F1A35', NULL, 0, NULL, 'AAAAAWWWW');
INSERT INTO `traj_messages` VALUES (51, 68, 70, '<p>fdd fdf lkdjfld</p>\r\n<ol>\r\n<li>s&ccedil;dfklsd<strong>jfkljsdlkj</strong>f lksdf</li>\r\n<li>s&ccedil;l kfjlksdjlkf jd</li>\r\n</ol>\r\n<p>sdjflkjsdklf</p>', '2012-07-12 16:02:51', 'C60393A3-F8E5-971A-01E7-F3E3B85F1A35', 'deleted', 0, NULL, 'AAAAAWWWW');
INSERT INTO `traj_messages` VALUES (52, 68, 71, '<p>dfdf</p>', '2012-07-12 16:04:16', '5346E0D1-FF91-AC84-8F84-C95D30792948', NULL, 0, NULL, 'dfdfd');
INSERT INTO `traj_messages` VALUES (53, 68, 65, '<p>dfdfdf</p>', '2012-07-12 16:04:26', '61085F15-2B3C-53EB-C034-F6A81F892F84', NULL, 6, '2012-07-12 16:53:27', 'dfdfd');
INSERT INTO `traj_messages` VALUES (54, 68, 65, '<p>dfdf</p>', '2012-07-12 17:09:21', '205887C2-D6BA-F2EA-6437-8B65BB815187', NULL, 2, '2012-07-13 23:09:30', 'TESTE rrrr');
INSERT INTO `traj_messages` VALUES (55, 68, 68, '<p>dfdf</p>', '2012-07-12 17:09:21', '205887C2-D6BA-F2EA-6437-8B65BB815187', NULL, 0, NULL, 'TESTE rrrr');
INSERT INTO `traj_messages` VALUES (60, 71, 65, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 18:05:15', '2D8F6819-1253-864E-4253-39BB26E70BCD', NULL, 1, '2012-07-16 18:29:18', '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (61, 71, 68, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 18:05:15', '97E4BDE9-9A87-6888-51EF-A6EDFD7934BB', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (62, 71, 69, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 18:05:15', 'D87894BF-19B8-4524-473D-E668E5C38DF5', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (63, 71, 70, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 18:05:15', 'D08A1295-15C3-B248-EE66-B93F42DB45D8', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (64, 71, 71, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 18:05:15', 'D3133F31-8929-C410-6A69-5C9E4AB85604', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (65, 71, 65, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 19:04:52', '25761828-96A4-D0F9-2C3A-45FB1A00AE82', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (66, 71, 68, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 19:04:52', '13345B12-8DBA-8012-B971-490300B6AEF4', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (67, 71, 69, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 19:04:52', 'A1220AE7-FD11-296A-2496-28FFC5ABA700', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (68, 71, 70, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 19:04:52', 'D222416B-90C2-4AD4-C8A3-3D1C8F282148', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (69, 71, 71, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 19:04:52', 'BAE79AAE-E4F2-CAFB-7BF7-94A7F33FAC64', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (70, 71, 65, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 19:26:05', '07E99FB5-AEFE-AF72-9FF2-740F56799987', NULL, 2, '2012-07-23 14:20:50', '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (71, 71, 68, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 19:26:05', '9E92D95A-06A6-9CEB-BF83-F46F7D87F1B4', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (72, 71, 69, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 19:26:05', '7E3521A3-7832-CC0A-C0E0-BBFBAFC577E0', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (73, 71, 70, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 19:26:05', '583A90AB-D35E-58DD-855F-DFDF85D5C4F6', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (74, 71, 71, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 19:26:05', '28152A18-02C6-FD37-D6A2-C6FE0776131A', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (75, 71, 65, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 22:59:20', '3CB435C2-14B6-9598-30E4-32CD37D3FADD', NULL, 1, '2012-07-17 19:59:18', '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (76, 71, 68, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 22:59:20', '95782479-B311-FD5E-39B9-186BE68C4F66', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (77, 71, 69, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 22:59:20', '5E53A2C5-6E67-459E-7123-4AC725F6ED79', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (78, 71, 70, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 22:59:20', '0FB21684-8975-60B8-8E7A-E125E272C859', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');
INSERT INTO `traj_messages` VALUES (79, 71, 71, 'Já estão disponíveis os formulários de avaliação de desempenho da Disciplina de Anestesiologia!<br/>Acesse o sistema para preenchê-los: <a href="http://localhost/sist_anestesia/">http://localhost/sist_anestesia/</a>', '2012-07-16 22:59:20', '2EA968B2-FAFE-2228-012F-91278BE992F8', NULL, 0, NULL, '[Anestesiologia USP] Formulários disponíveis');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `traj_producoes`
-- 

CREATE TABLE `traj_producoes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `modified_author_id` int(10) unsigned default NULL,
  `obs` text,
  `ch_cumprida` varchar(5) default NULL,
  `ch_prevista` varchar(5) default NULL,
  `sh_mes` varchar(5) default NULL,
  `sh_acumulado` varchar(5) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

-- 
-- Extraindo dados da tabela `traj_producoes`
-- 

INSERT INTO `traj_producoes` VALUES (46, '2012-07-16 22:59:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `traj_producoes` VALUES (47, '2012-07-16 22:59:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `traj_producoes` VALUES (48, '2012-07-16 22:59:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `traj_producoes` VALUES (49, '2012-07-16 22:59:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `traj_producoes` VALUES (50, '2012-07-16 22:59:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `traj_respostas`
-- 

CREATE TABLE `traj_respostas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `avaliacao_id` int(10) unsigned default NULL,
  `ref_user_id` int(10) unsigned default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `author_id` int(10) unsigned default NULL,
  `obs` text,
  `q1` text,
  `q2` text,
  `q3` text,
  `q4` text,
  `q5` text,
  `q6` text,
  `q7` text,
  `q8` text,
  `q9` text,
  `q10` text,
  `q11` text,
  `q12` text,
  `q13` text,
  `q14` text,
  `q15` text,
  `q16` text,
  `q17` text,
  `q18` text,
  `q19` text,
  `q20` text,
  `score` int(4) default NULL,
  `controle_id` int(10) unsigned default NULL,
  `status_id` int(2) default NULL,
  `open_as` int(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=155 ;

-- 
-- Extraindo dados da tabela `traj_respostas`
-- 

INSERT INTO `traj_respostas` VALUES (146, 3, 65, '2012-07-16 22:59:20', NULL, 65, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 57, 0, 0);
INSERT INTO `traj_respostas` VALUES (147, 3, 65, '2012-07-16 22:59:20', NULL, 69, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 57, 0, 2);
INSERT INTO `traj_respostas` VALUES (148, 3, 68, '2012-07-16 22:59:20', NULL, 68, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 58, 0, 0);
INSERT INTO `traj_respostas` VALUES (149, 3, 68, '2012-07-16 22:59:20', NULL, 69, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 58, 0, 2);
INSERT INTO `traj_respostas` VALUES (150, 4, 69, '2012-07-16 22:59:20', NULL, 69, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 59, 0, 0);
INSERT INTO `traj_respostas` VALUES (151, 4, 69, '2012-07-16 22:59:20', NULL, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 59, 0, 5);
INSERT INTO `traj_respostas` VALUES (152, 5, 70, '2012-07-16 22:59:20', NULL, 70, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 60, 0, 0);
INSERT INTO `traj_respostas` VALUES (153, 5, 70, '2012-07-16 22:59:20', NULL, 69, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 60, 0, 3);
INSERT INTO `traj_respostas` VALUES (154, 5, 70, '2012-07-16 22:59:20', NULL, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 60, 0, 4);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `traj_settings`
-- 

CREATE TABLE `traj_settings` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `param` varchar(255) default NULL,
  `value` varchar(255) default NULL,
  `modified` datetime default NULL,
  `modified_author_id` int(10) unsigned default NULL,
  `obs` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- 
-- Extraindo dados da tabela `traj_settings`
-- 

INSERT INTO `traj_settings` VALUES (1, 'diaNotificacao', '3', NULL, NULL, NULL);
INSERT INTO `traj_settings` VALUES (2, 'email_host', 'smtp.gmail.com', NULL, NULL, NULL);
INSERT INTO `traj_settings` VALUES (3, 'email_username', 'anestesiologia.usp@gmail.com', NULL, NULL, NULL);
INSERT INTO `traj_settings` VALUES (4, 'email_password', 'anestesia$$', NULL, NULL, NULL);
INSERT INTO `traj_settings` VALUES (5, 'email_fromName', 'Disciplina de Anestesiologia USP', NULL, NULL, NULL);
INSERT INTO `traj_settings` VALUES (6, 'email_port', '465', NULL, NULL, NULL);
INSERT INTO `traj_settings` VALUES (7, 'email_SMTPSecure', 'ssl', NULL, NULL, NULL);
INSERT INTO `traj_settings` VALUES (8, 'email_SMTPAuth', 'true', NULL, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `traj_users`
-- 

CREATE TABLE `traj_users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `wp_user_id` bigint(20) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL default '0',
  `obs` text,
  `status_id` int(10) unsigned NOT NULL,
  `modified` datetime default NULL,
  `modified_author_id` int(10) unsigned NOT NULL,
  `created` datetime default NULL,
  `wp_username` varchar(60) default NULL,
  `wp_firstname` varchar(255) default NULL,
  `wp_lastname` varchar(255) default NULL,
  `nome` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

-- 
-- Extraindo dados da tabela `traj_users`
-- 

INSERT INTO `traj_users` VALUES (65, 2, 1, NULL, 1, NULL, 0, '2012-07-09 00:46:51', 'renato', '', '', 'RENATO', 'renatoteste@trajettoria.com');
INSERT INTO `traj_users` VALUES (68, 5, 1, NULL, 1, NULL, 0, '2012-07-09 16:57:06', 'graziele', 'Graziele', 'Vasconcelos', 'GRAZIELE VASCONCELOS', 'grazieleteste@trajettoria.com');
INSERT INTO `traj_users` VALUES (69, 12, 1, NULL, 1, NULL, 0, '2012-07-09 16:57:06', 'teste100', 'Fulano', 'de Tal', 'FULANO DE TAL', 'teste100_fulano@trajettoria.com');
INSERT INTO `traj_users` VALUES (70, 1, 1, NULL, 1, NULL, 0, '2012-07-09 16:57:06', 'trajettoria', '', '', 'TRAJETTORIA', 'trajettoria@trajettoria.com');
INSERT INTO `traj_users` VALUES (71, 4, 1, NULL, 1, NULL, 0, '2012-07-10 23:42:20', 'admin', '', '', 'ADMIN', 'contato@trajettoria.com');
