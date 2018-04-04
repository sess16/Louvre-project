SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `louvre`
--

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `short_code` varchar(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `countries`
--

INSERT INTO `countries` (`id`, `name`, `short_code`) VALUES
(1, 'Andorre', 'AD'),
(2, 'Émirats arabes unis', 'AE'),
(3, 'Afghanistan', 'AF'),
(4, 'Antigua-et-Barbuda', 'AG'),
(5, 'Anguilla', 'AI'),
(6, 'Albanie', 'AL'),
(7, 'Arménie', 'AM'),
(8, 'Angola', 'AO'),
(9, 'Antarctique', 'AQ'),
(10, 'Argentine', 'AR'),
(11, 'Samoa américaine', 'AS'),
(12, 'Autriche', 'AT'),
(13, 'Australie', 'AU'),
(14, 'Aruba', 'AW'),
(15, 'Îles d\'Åland', 'AX'),
(16, 'Azerbaïdjan', 'AZ'),
(17, 'Bosnie-Herzégovine', 'BA'),
(18, 'Barbade', 'BB'),
(19, 'Bangladesh', 'BD'),
(20, 'Belgique', 'BE'),
(21, 'Burkina Faso', 'BF'),
(22, 'Bulgarie', 'BG'),
(23, 'Bahreïn', 'BH'),
(24, 'Burundi', 'BI'),
(25, 'Bénin', 'BJ'),
(26, 'Saint-Barthélemy', 'BL'),
(27, 'Bermudes', 'BM'),
(28, 'Brunei Darussalam', 'BN'),
(29, 'Bolivie', 'BO'),
(30, 'Pays-Bas caribéens', 'BQ'),
(31, 'Brésil', 'BR'),
(32, 'Bahamas', 'BS'),
(33, 'Bhoutan', 'BT'),
(34, 'Île Bouvet', 'BV'),
(35, 'Botswana', 'BW'),
(36, 'Bélarus', 'BY'),
(37, 'Belize', 'BZ'),
(38, 'Canada', 'CA'),
(39, 'Îles Cocos (Keeling)', 'CC'),
(40, 'Congo, République démocratique du', 'CD'),
(41, 'République centrafricaine', 'CF'),
(42, 'Congo', 'CG'),
(43, 'Suisse', 'CH'),
(44, 'Côte d\'Ivoire', 'CI'),
(45, 'Îles Cook', 'CK'),
(46, 'Chili', 'CL'),
(47, 'Cameroun', 'CM'),
(48, 'Chine', 'CN'),
(49, 'Colombie', 'CO'),
(50, 'Costa Rica', 'CR'),
(51, 'Cuba', 'CU'),
(52, 'Cap-Vert', 'CV'),
(53, 'Curaçao', 'CW'),
(54, 'Île Christmas', 'CX'),
(55, 'Chypre', 'CY'),
(56, 'République tchèque', 'CZ'),
(57, 'Allemagne', 'DE'),
(58, 'Djibouti', 'DJ'),
(59, 'Danemark', 'DK'),
(60, 'Dominique', 'DM'),
(61, 'République dominicaine', 'DO'),
(62, 'Algérie', 'DZ'),
(63, 'Équateur', 'EC'),
(64, 'Estonie', 'EE'),
(65, 'Égypte', 'EG'),
(66, 'Sahara Occidental', 'EH'),
(67, 'Érythrée', 'ER'),
(68, 'Espagne', 'ES'),
(69, 'Éthiopie', 'ET'),
(70, 'Finlande', 'FI'),
(71, 'Fidji', 'FJ'),
(72, 'Îles Malouines', 'FK'),
(73, 'Micronésie, États fédérés de', 'FM'),
(74, 'Îles Féroé', 'FO'),
(75, 'France', 'FR'),
(76, 'Gabon', 'GA'),
(77, 'Royaume-Uni', 'GB'),
(78, 'Grenade', 'GD'),
(79, 'Géorgie', 'GE'),
(80, 'Guyane française', 'GF'),
(81, 'Guernesey', 'GG'),
(82, 'Ghana', 'GH'),
(83, 'Gibraltar', 'GI'),
(84, 'Groenland', 'GL'),
(85, 'Gambie', 'GM'),
(86, 'Guinée', 'GN'),
(87, 'Guadeloupe', 'GP'),
(88, 'Guinée équatoriale', 'GQ'),
(89, 'Grèce', 'GR'),
(90, 'Géorgie du Sud Iles Sandwich du Sud', 'GS'),
(91, 'Guatemala', 'GT'),
(92, 'Guam', 'GU'),
(93, 'Guinée-Bissau', 'GW'),
(94, 'Guyana', 'GY'),
(95, 'Hong Kong', 'HK'),
(96, 'Îles Heard et McDonald', 'HM'),
(97, 'Honduras', 'HN'),
(98, 'Croatie', 'HR'),
(99, 'Haïti', 'HT'),
(100, 'Hongrie', 'HU'),
(101, 'Indonésie', 'ID'),
(102, 'Irlande', 'IE'),
(103, 'Israël', 'IL'),
(104, 'Île de Man', 'IM'),
(105, 'Inde', 'IN'),
(106, 'Territoire britannique de l\'océan Indien', 'IO'),
(107, 'Irak', 'IQ'),
(108, 'Iran', 'IR'),
(109, 'Islande', 'IS'),
(110, 'Italie', 'IT'),
(111, 'Jersey', 'JE'),
(112, 'Jamaïque', 'JM'),
(113, 'Jordanie', 'JO'),
(114, 'Japon', 'JP'),
(115, 'Kenya', 'KE'),
(116, 'Kirghizistan', 'KG'),
(117, 'Cambodge', 'KH'),
(118, 'Kiribati', 'KI'),
(119, 'Comores', 'KM'),
(120, 'Saint-Kitts-et-Nevis', 'KN'),
(121, 'Corée du Nord', 'KP'),
(122, 'Corée du Sud', 'KR'),
(123, 'Koweït', 'KW'),
(124, 'Îles Caïmans', 'KY'),
(125, 'Kazakhstan', 'KZ'),
(126, 'Laos', 'LA'),
(127, 'Liban', 'LB'),
(128, 'Sainte-Lucie', 'LC'),
(129, 'Liechtenstein', 'LI'),
(130, 'Sri Lanka', 'LK'),
(131, 'Libéria', 'LR'),
(132, 'Lesotho', 'LS'),
(133, 'Lituanie', 'LT'),
(134, 'Luxembourg', 'LU'),
(135, 'Lettonie', 'LV'),
(136, 'Libye', 'LY'),
(137, 'Maroc', 'MA'),
(138, 'Monaco', 'MC'),
(139, 'Moldavie', 'MD'),
(140, 'Monténégro', 'ME'),
(141, 'Saint-Martin (France)', 'MF'),
(142, 'Madagascar', 'MG'),
(143, 'Îles Marshall', 'MH'),
(144, 'Macédoine', 'MK'),
(145, 'Mali', 'ML'),
(146, 'Myanmar', 'MM'),
(147, 'Mongolie', 'MN'),
(148, 'Macao', 'MO'),
(149, 'Mariannes du Nord', 'MP'),
(150, 'Martinique', 'MQ'),
(151, 'Mauritanie', 'MR'),
(152, 'Montserrat', 'MS'),
(153, 'Malte', 'MT'),
(154, 'Maurice', 'MU'),
(155, 'Maldives', 'MV'),
(156, 'Malawi', 'MW'),
(157, 'Mexique', 'MX'),
(158, 'Malaisie', 'MY'),
(159, 'Mozambique', 'MZ'),
(160, 'Namibie', 'NA'),
(161, 'Nouvelle-Calédonie', 'NC'),
(162, 'Niger', 'NE'),
(163, 'Île Norfolk', 'NF'),
(164, 'Nigeria', 'NG'),
(165, 'Nicaragua', 'NI'),
(166, 'Pays-Bas', 'NL'),
(167, 'Norvège', 'NO'),
(168, 'Népal', 'NP'),
(169, 'Nauru', 'NR'),
(170, 'Niue', 'NU'),
(171, 'Nouvelle-Zélande', 'NZ'),
(172, 'Oman', 'OM'),
(173, 'Panama', 'PA'),
(174, 'Pérou', 'PE'),
(175, 'Polynésie française', 'PF'),
(176, 'Papouasie-Nouvelle-Guinée', 'PG'),
(177, 'Philippines', 'PH'),
(178, 'Pakistan', 'PK'),
(179, 'Pologne', 'PL'),
(180, 'Saint-Pierre-et-Miquelon', 'PM'),
(181, 'Pitcairn', 'PN'),
(182, 'Puerto Rico', 'PR'),
(183, 'Palestine', 'PS'),
(184, 'Portugal', 'PT'),
(185, 'Palau', 'PW'),
(186, 'Paraguay', 'PY'),
(187, 'Qatar', 'QA'),
(188, 'Réunion', 'RE'),
(189, 'Roumanie', 'RO'),
(190, 'Serbie', 'RS'),
(191, 'Russie', 'RU'),
(192, 'Rwanda', 'RW'),
(193, 'Arabie saoudite', 'SA'),
(194, 'Îles Salomon', 'SB'),
(195, 'Seychelles', 'SC'),
(196, 'Soudan', 'SD'),
(197, 'Suède', 'SE'),
(198, 'Singapour', 'SG'),
(199, 'Sainte-Hélène', 'SH'),
(200, 'Slovénie', 'SI'),
(201, 'Svalbard et île de Jan Mayen', 'SJ'),
(202, 'Slovaquie', 'SK'),
(203, 'Sierra Leone', 'SL'),
(204, 'Saint-Marin', 'SM'),
(205, 'Sénégal', 'SN'),
(206, 'Somalie', 'SO'),
(207, 'Suriname', 'SR'),
(208, 'Soudan du Sud', 'SS'),
(209, 'Sao Tomé-et-Principe', 'ST'),
(210, 'El Salvador', 'SV'),
(211, 'Saint-Martin (Pays-Bas)', 'SX'),
(212, 'Syrie', 'SY'),
(213, 'Swaziland', 'SZ'),
(214, 'Îles Turks et Caicos', 'TC'),
(215, 'Tchad', 'TD'),
(216, 'Terres australes françaises', 'TF'),
(217, 'Togo', 'TG'),
(218, 'Thaïlande', 'TH'),
(219, 'Tadjikistan', 'TJ'),
(220, 'Tokelau', 'TK'),
(221, 'Timor-Leste', 'TL'),
(222, 'Turkménistan', 'TM'),
(223, 'Tunisie', 'TN'),
(224, 'Tonga', 'TO'),
(225, 'Turquie', 'TR'),
(226, 'Trinité-et-Tobago', 'TT'),
(227, 'Tuvalu', 'TV'),
(228, 'Taïwan', 'TW'),
(229, 'Tanzanie', 'TZ'),
(230, 'Ukraine', 'UA'),
(231, 'Ouganda', 'UG'),
(232, 'Îles mineures ', 'UM'),
(233, 'États-Unis', 'US'),
(234, 'Uruguay', 'UY'),
(235, 'Ouzbékistan', 'UZ'),
(236, 'Vatican', 'VA'),
(237, 'Saint-Vincent-et-les-Grenadines', 'VC'),
(238, 'Venezuela', 'VE'),
(239, 'Îles Vierges britanniques', 'VG'),
(240, 'Îles Vierges américaines', 'VI'),
(241, 'Vietnam', 'VN'),
(242, 'Vanuatu', 'VU'),
(243, 'Îles Wallis-et-Futuna', 'WF'),
(244, 'Samoa', 'WS'),
(245, 'Yémen', 'YE'),
(246, 'Mayotte', 'YT'),
(247, 'Afrique du Sud', 'ZA'),
(248, 'Zambie', 'ZM'),
(249, 'Zimbabwe', 'ZW');

-- --------------------------------------------------------

--
-- Structure de la table `durations`
--

CREATE TABLE `durations` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `durations`
--

INSERT INTO `durations` (`id`, `name`) VALUES
(1, 'Journée'),
(2, 'Demi-journée');

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `first_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20170901152743'),
('20170902061622'),
('20170902092757');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `duration_id` int(11) DEFAULT NULL,
  `order_date` datetime NOT NULL,
  `venue_date` date NOT NULL,
  `order_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `customer_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `order_paid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rates`
--

CREATE TABLE `rates` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `rates`
--

INSERT INTO `rates` (`id`, `name`) VALUES
(1, 'Adulte (plus de 12 ans)'),
(2, 'Enfant (de 4 à 12 ans)'),
(3, 'Senior (plus de 60 ans)'),
(4, 'Réduit');

-- --------------------------------------------------------

--
-- Structure de la table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `duration_id` int(11) DEFAULT NULL,
  `rate_id` int(11) DEFAULT NULL,
  `price` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `tickets`
--

INSERT INTO `tickets` (`id`, `duration_id`, `rate_id`, `price`) VALUES
(1, 1, 1, '16.00'),
(2, 2, 1, '8.00'),
(3, 1, 2, '8.00'),
(4, 2, 2, '4.00'),
(5, 1, 3, '12.00'),
(6, 2, 3, '6.00'),
(7, 1, 4, '10.00'),
(8, 2, 4, '5.00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `durations`
--
ALTER TABLE `durations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E11EE94DF92F3E70` (`country_id`),
  ADD KEY `IDX_E11EE94D700047D2` (`ticket_id`),
  ADD KEY `IDX_E11EE94D8D9F6D38` (`order_id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E52FFDEE37B987D8` (`duration_id`);

--
-- Index pour la table `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_54469DF437B987D8` (`duration_id`),
  ADD KEY `IDX_54469DF4BC999F9F` (`rate_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;
--
-- AUTO_INCREMENT pour la table `durations`
--
ALTER TABLE `durations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `rates`
--
ALTER TABLE `rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `FK_E11EE94D700047D2` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`),
  ADD CONSTRAINT `FK_E11EE94D8D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `FK_E11EE94DF92F3E70` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_E52FFDEE37B987D8` FOREIGN KEY (`duration_id`) REFERENCES `durations` (`id`);

--
-- Contraintes pour la table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `FK_54469DF437B987D8` FOREIGN KEY (`duration_id`) REFERENCES `durations` (`id`),
  ADD CONSTRAINT `FK_54469DF4BC999F9F` FOREIGN KEY (`rate_id`) REFERENCES `rates` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
