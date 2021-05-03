-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 30 avr. 2021 à 10:55
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `snow-p6`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_parent` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1277 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `category_parent`, `name`, `description`) VALUES
(1248, 'grabs', 'Mute', 'Saisie de la carre frontside de la planche entre les deux pieds avec la main avant'),
(1249, 'grabs', 'Sad', 'Saisie de la carre backside de la planche, entre les deux pieds, avec la main avant'),
(1250, 'grabs', 'Indy', 'Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière'),
(1251, 'grabs', 'Stalefish', 'Saisie de la carre backside de la planche entre les deux pieds avec la main arrière'),
(1252, 'grabs', 'Tail grab', 'Saisie de la partie arrière de la planche, avec la main arrière'),
(1253, 'grabs', 'Nose grab', 'Saisie de la partie avant de la planche, avec la main avant'),
(1254, 'grabs', 'Japan', 'Saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside'),
(1255, 'grabs', 'Seat belt', 'Saisie du carre frontside à l\'arrière avec la main avant'),
(1256, 'grabs', 'Truck driver', 'Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture)'),
(1257, 'rotations', '180', 'Désigne un demi-tour, soit 180 degrés d\'angle'),
(1258, 'rotations', '360', 'Trois six pour un tour complet'),
(1259, 'rotations', '540', 'Cinq quatre pour un tour et demi'),
(1260, 'rotations', '720', 'Sept deux pour deux tours complets'),
(1261, 'rotations', '900', 'Pour deux tours et demi'),
(1262, 'rotations', '1080', '1080 ou big foot pour trois tours'),
(1263, 'flips', 'Front flips', 'Désigne un demi-tour, en avant'),
(1264, 'flips', 'Back flip', 'Désigne un demi-tour, en arrière'),
(1265, 'slides', 'Nose slide', 'Slide à l\'avant de la planche sur la barre'),
(1266, 'slides', 'Tail slide', 'Slide à l\'arrière de la planche sur la barre'),
(1267, 'Old School', 'Backside Aid', 'Slide à l\'avant de la planche sur la barre'),
(1268, 'Old School', 'Method Air', 'Slide à l\'arrière de la planche sur la barre'),
(1269, 'One foot tricks', 'One foot manual', 'Le One foot manual est un manual assez particulier puisqu\'il consiste à rouler sur un pied et l\'arrière du snow'),
(1270, 'One foot tricks', 'One footed flip', 'Semblable au One foot manual mais avec un flip 90 en plus'),
(1271, '0', 'Grabs', 'Consiste à attraper la planche avec la main pendant le saut'),
(1272, '0', 'Rotations', 'Le principe est d\'effectuer une rotation horizontale pendant le saut, puis d\'attérir en position switch ou normal'),
(1273, '0', 'Flips', 'Un flip est une rotation verticale'),
(1274, '0', 'Slides', 'Un slide consiste à glisser sur une barre de slide'),
(1275, '0', 'One foot tricks', 'Figures réalisée avec un pied décroché de la fixation, afin de tendre la jambe correspondante pour mettre en évidence le fait que le pied n\'est pas fixé'),
(1276, '0', 'Old school', 'Le terme old school désigne un style de freestyle caractérisée par en ensemble de figure et une manière de réaliser des figures passée de mode, qui fait penser au freestyle des années 1980');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `tricks_id` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CF675F31B` (`author_id`),
  KEY `IDX_9474526C3B153154` (`tricks_id`)
) ENGINE=InnoDB AUTO_INCREMENT=916 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `author_id`, `tricks_id`, `content`, `date_create`) VALUES
(874, 686, 582, 'Il mangeait des abricots. -- Extraordinaire!... reprit le percepteur d\'un air cordial qu\'il avait.', '2021-04-22 10:01:55'),
(875, 686, 575, 'Bertaux. La dernière journée s\'était écoulée comme les pierres, allait maintenant s\'évaporer.', '2021-04-20 13:21:29'),
(876, 687, 580, 'Retournons. Il eut de belles idées à propos du monde, et une femme en peau de daim. Rodolphe avait.', '2021-03-30 05:43:46'),
(877, 687, 579, 'C\'est bien, c\'est bien. Mais il ne put parvenir à trouver un habit vert, répandit dans son ménage.', '2021-04-27 15:42:25'),
(878, 688, 575, 'Charles, comme aux plantes indiennes, des terrains préparés, une température particulière? Les.', '2021-04-19 18:43:46'),
(879, 688, 578, 'Elle prétendit avoir été une de ces jours du mois l\'argent de son amour. Il ne se souciant pas, vu.', '2021-04-17 14:25:52'),
(880, 689, 582, 'La plus grande encore. Charles n\'était point de vue du sang des autres à un les coups furieux de.', '2021-04-01 07:17:49'),
(881, 689, 585, 'Il ne pouvait rien; mais lui, Léon, il allait devenir premier clerc: c\'était le chic. Il adorait.', '2021-04-25 14:05:36'),
(882, 690, 579, 'L\'amour... conjugal! dit-il en se disant: -- Madame, sans doute, s\'en aller vers ces pays à noms.', '2021-04-03 11:52:36'),
(883, 690, 582, 'La mariée avait supplié son père serait sourd, et il avait une robe de satin, Emma fixait ses.', '2021-04-04 00:34:23'),
(884, 691, 577, 'Emma avait la Esméralda de Steuben, avec la conscience des magistrats; et il y avait, pour décorer.', '2021-04-03 11:13:13'),
(885, 691, 582, 'Deux ou trois fois honneur! N\'est-ce pas l\'agriculteur encore qui engraisse, pour nos tables, et.', '2021-03-29 01:55:42'),
(886, 692, 574, 'Tout le monde ne vous fâchez pas, je ne vois nulle part aucun métier..., à moins peut- être que.', '2021-04-16 21:33:42'),
(887, 692, 572, 'Madame dans sa maison. Elle envoyait aux malades le compte de leur bordure, des noms divers.', '2021-04-16 16:58:52'),
(888, 693, 567, 'Allons, éclaire-moi! Elle entra dans sa tunique, il avait disparu. Elle retomba désespérée.', '2021-03-30 04:04:48'),
(889, 693, 579, 'Rodolphe, tombée à terre et de cailloux. Jusqu\'en 1835, il n\'y voyait jamais de millionnaire. Loin.', '2021-04-26 18:05:25'),
(890, 694, 580, 'Je ne sais pas! c\'est une simple piqûre comme une comtesse. Pauvre bonhomme, d\'ailleurs, qui sans.', '2021-04-05 01:01:00'),
(891, 694, 580, 'Turcs. On sentait l\'absinthe, le cigare aux dents, raccommodait avec son drapeau de fer-blanc qui.', '2021-04-27 19:56:14'),
(892, 695, 586, 'J\'aimerais beaucoup, dit-elle, à être nus. Ses jambes, en fauchant avec leurs grands parapluies.', '2021-04-14 13:37:38'),
(893, 695, 567, 'Elle aurait voulu ne rien respecter. Un jour, avec Léon... Oh! comme j\'aurais dépensé toute.', '2021-04-16 11:29:06'),
(894, 696, 581, 'Charles s\'arrêta devant le crucifix, et le monde est dehors! les vents de sud- est, lesquels.', '2021-04-11 21:48:05'),
(895, 696, 585, 'Elle était très contente, très heureuse, que Tostes lui plaisait beaucoup, et autres discours.', '2021-04-01 20:21:42'),
(896, 697, 581, 'Tout est peine perdue, dit Emma. Et, comme dans un mince habit noir, mal fait. Elle était aussi.', '2021-04-11 16:01:29'),
(897, 697, 567, 'Il discourait sur la pièce à côté. Emma, le soir, n\'alla pas chez ses parents. Charles voulut.', '2021-04-24 03:08:24'),
(898, 698, 585, 'Son langage, à propos de rétablir le membre dans l\'appareil, et en français. Par la fenêtre.', '2021-04-14 21:36:51'),
(899, 698, 584, 'Alors elle se détournait; il la chérissait davantage. C\'était un de ces lamentations mélodieuses.', '2021-04-22 21:48:45'),
(900, 699, 580, 'Homais parlait. Il expliquait à la main, et se mit à rire. Il se recula tout effrayé. Puis elle.', '2021-04-24 11:45:40'),
(901, 699, 567, 'Bournisien demanda où il voulut faire valoir. Mais, comme il le contemplait d\'une manière.', '2021-04-02 19:10:43'),
(902, 700, 570, 'Le Proviseur nous fit signe de tête qu\'elle faisait, le bas de soie, en culotte courte.', '2021-04-18 20:28:29'),
(903, 700, 584, 'Emma se jeta sur elle plutôt qu\'il ne fût guère tendre cependant, ni facilement accessible à.', '2021-04-20 17:12:37'),
(904, 701, 573, 'À six heures battant vous allez là-bas? dit-elle avec un rire épais, et moi, les deux autres.', '2021-04-08 07:21:32'),
(905, 701, 569, 'Charles retourna donc vers sa chambre, au coin des halles. C\'était le lendemain et quelque chose.', '2021-04-14 21:31:56'),
(906, 702, 584, 'Quelque chose incessamment me poussait là; j\'y suis resté des heures et un peu dans ses rêves. (Et.', '2021-04-15 03:21:15'),
(907, 702, 581, 'Il mit sa robe du côté de l\'eau, sous la poésie du rôle qui l\'envahissait, et, entraînée vers.', '2021-04-03 13:20:50'),
(908, 703, 579, 'Il l\'excusait intérieurement, trouvant qu\'elle avait rêvé. VII Elle songeait qu\'elle l\'avait.', '2021-04-20 08:08:55'),
(909, 703, 573, 'Nous ne sommes pas près, à ce qu\'on ne lui servait guère dans sa volée. Aussi poussa-t-il un grand.', '2021-03-29 03:04:14'),
(910, 704, 580, 'Dès le matin dans les salons, que l\'on emboîta dans les massifs, se tenaient, sur deux colonnes.', '2021-04-06 01:44:01'),
(911, 704, 586, 'Sa chevelure rouge dégouttait de sueur. Selon la mode la manie des plantes bizarres, hérissées de.', '2021-04-28 02:29:44'),
(912, 705, 576, 'Il avait passé à l\'ordre de Vinçart. Elle expédia chez lui un tour, où il se tournait vers eux.', '2021-04-12 08:29:24'),
(913, 705, 573, 'Outre la cravache à pommeau de vermeil, Rodolphe avait reçu la lettre dans le mouvement d\'étendre.', '2021-04-04 07:20:12'),
(914, 706, 585, 'Mais elle ne répondit rien. Elle respirait d\'une façon tendre. -- Est-ce de t\'en aller?.', '2021-04-18 00:33:42'),
(915, 706, 580, 'Ils repartirent; et, d\'un mouvement brusque entrait dans quelque hôtel plus modeste; mais elle.', '2021-04-17 16:27:11');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210402123807', '2021-04-02 14:38:22', 207),
('DoctrineMigrations\\Version20210406084404', '2021-04-06 10:44:48', 389),
('DoctrineMigrations\\Version20210408142928', '2021-04-08 16:33:27', 67),
('DoctrineMigrations\\Version20210408152127', '2021-04-08 17:22:37', 203),
('DoctrineMigrations\\Version20210409113933', '2021-04-09 13:40:03', 119),
('DoctrineMigrations\\Version20210409132301', '2021-04-09 15:23:32', 159),
('DoctrineMigrations\\Version20210416091114', '2021-04-16 11:11:46', 275),
('DoctrineMigrations\\Version20210416135934', '2021-04-16 16:00:04', 109),
('DoctrineMigrations\\Version20210416142824', '2021-04-16 16:29:09', 98),
('DoctrineMigrations\\Version20210420153911', '2021-04-20 17:40:32', 115),
('DoctrineMigrations\\Version20210423131044', '2021-04-23 15:11:05', 237);

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tricks_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6A2CA10C3B153154` (`tricks_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2937 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`id`, `tricks_id`, `name`, `path`, `type`) VALUES
(2857, 567, 'snow_11.jpg', 'snow_11.jpg', 'img'),
(2858, 567, 'snow_1.jpg', 'snow_1.jpg', 'img'),
(2859, 567, 'snow_16.jpg', 'snow_16.jpg', 'img'),
(2860, 567, 'snow_21.jpg', 'snow_21.jpg', 'img'),
(2861, 568, 'snow_14.jpg', 'snow_14.jpg', 'img'),
(2862, 568, 'snow_6.jpg', 'snow_6.jpg', 'img'),
(2863, 568, 'snow_8.jpg', 'snow_8.jpg', 'img'),
(2864, 568, 'snow_17.jpg', 'snow_17.jpg', 'img'),
(2865, 569, 'snow_11.jpg', 'snow_11.jpg', 'img'),
(2866, 569, 'snow_14.jpg', 'snow_14.jpg', 'img'),
(2867, 569, 'snow_8.jpg', 'snow_8.jpg', 'img'),
(2868, 569, 'snow_18.jpg', 'snow_18.jpg', 'img'),
(2869, 570, 'snow_13.jpg', 'snow_13.jpg', 'img'),
(2870, 570, 'snow_8.jpg', 'snow_8.jpg', 'img'),
(2871, 570, 'snow_17.jpg', 'snow_17.jpg', 'img'),
(2872, 570, 'snow_21.jpg', 'snow_21.jpg', 'img'),
(2873, 571, 'snow_10.jpg', 'snow_10.jpg', 'img'),
(2874, 571, 'snow_7.jpg', 'snow_7.jpg', 'img'),
(2875, 571, 'snow_3.jpg', 'snow_3.jpg', 'img'),
(2876, 571, 'snow_22.jpg', 'snow_22.jpg', 'img'),
(2877, 572, 'snow_6.jpg', 'snow_6.jpg', 'img'),
(2878, 572, 'snow_16.jpg', 'snow_16.jpg', 'img'),
(2879, 572, 'snow_3.jpg', 'snow_3.jpg', 'img'),
(2880, 572, 'snow_22.jpg', 'snow_22.jpg', 'img'),
(2881, 573, 'snow_1.jpg', 'snow_1.jpg', 'img'),
(2882, 573, 'snow_15.jpg', 'snow_15.jpg', 'img'),
(2883, 573, 'snow_2.jpg', 'snow_2.jpg', 'img'),
(2884, 573, 'snow_18.jpg', 'snow_18.jpg', 'img'),
(2885, 574, 'snow_5.jpg', 'snow_5.jpg', 'img'),
(2886, 574, 'snow_1.jpg', 'snow_1.jpg', 'img'),
(2887, 574, 'snow_17.jpg', 'snow_17.jpg', 'img'),
(2888, 574, 'snow_11.jpg', 'snow_11.jpg', 'img'),
(2889, 575, 'snow_16.jpg', 'snow_16.jpg', 'img'),
(2890, 575, 'snow_15.jpg', 'snow_15.jpg', 'img'),
(2891, 575, 'snow_16.jpg', 'snow_16.jpg', 'img'),
(2892, 575, 'snow_14.jpg', 'snow_14.jpg', 'img'),
(2893, 576, 'snow_13.jpg', 'snow_13.jpg', 'img'),
(2894, 576, 'snow_3.jpg', 'snow_3.jpg', 'img'),
(2895, 576, 'snow_2.jpg', 'snow_2.jpg', 'img'),
(2896, 576, 'snow_3.jpg', 'snow_3.jpg', 'img'),
(2897, 577, 'snow_2.jpg', 'snow_2.jpg', 'img'),
(2898, 577, 'snow_19.jpg', 'snow_19.jpg', 'img'),
(2899, 577, 'snow_3.jpg', 'snow_3.jpg', 'img'),
(2900, 577, 'snow_20.jpg', 'snow_20.jpg', 'img'),
(2901, 578, 'snow_22.jpg', 'snow_22.jpg', 'img'),
(2902, 578, 'snow_13.jpg', 'snow_13.jpg', 'img'),
(2903, 578, 'snow_16.jpg', 'snow_16.jpg', 'img'),
(2904, 578, 'snow_9.jpg', 'snow_9.jpg', 'img'),
(2905, 579, 'snow_22.jpg', 'snow_22.jpg', 'img'),
(2906, 579, 'snow_2.jpg', 'snow_2.jpg', 'img'),
(2907, 579, 'snow_2.jpg', 'snow_2.jpg', 'img'),
(2908, 579, 'snow_14.jpg', 'snow_14.jpg', 'img'),
(2909, 580, 'snow_9.jpg', 'snow_9.jpg', 'img'),
(2910, 580, 'snow_8.jpg', 'snow_8.jpg', 'img'),
(2911, 580, 'snow_1.jpg', 'snow_1.jpg', 'img'),
(2912, 580, 'snow_18.jpg', 'snow_18.jpg', 'img'),
(2913, 581, 'snow_9.jpg', 'snow_9.jpg', 'img'),
(2914, 581, 'snow_8.jpg', 'snow_8.jpg', 'img'),
(2915, 581, 'snow_20.jpg', 'snow_20.jpg', 'img'),
(2916, 581, 'snow_8.jpg', 'snow_8.jpg', 'img'),
(2917, 582, 'snow_2.jpg', 'snow_2.jpg', 'img'),
(2918, 582, 'snow_22.jpg', 'snow_22.jpg', 'img'),
(2919, 582, 'snow_10.jpg', 'snow_10.jpg', 'img'),
(2920, 582, 'snow_20.jpg', 'snow_20.jpg', 'img'),
(2921, 583, 'snow_3.jpg', 'snow_3.jpg', 'img'),
(2922, 583, 'snow_3.jpg', 'snow_3.jpg', 'img'),
(2923, 583, 'snow_7.jpg', 'snow_7.jpg', 'img'),
(2924, 583, 'snow_6.jpg', 'snow_6.jpg', 'img'),
(2925, 584, 'snow_15.jpg', 'snow_15.jpg', 'img'),
(2926, 584, 'snow_10.jpg', 'snow_10.jpg', 'img'),
(2927, 584, 'snow_6.jpg', 'snow_6.jpg', 'img'),
(2928, 584, 'snow_9.jpg', 'snow_9.jpg', 'img'),
(2929, 585, 'snow_15.jpg', 'snow_15.jpg', 'img'),
(2930, 585, 'snow_6.jpg', 'snow_6.jpg', 'img'),
(2931, 585, 'snow_18.jpg', 'snow_18.jpg', 'img'),
(2932, 585, 'snow_5.jpg', 'snow_5.jpg', 'img'),
(2933, 586, 'snow_6.jpg', 'snow_6.jpg', 'img'),
(2934, 586, 'snow_1.jpg', 'snow_1.jpg', 'img'),
(2935, 586, 'snow_10.jpg', 'snow_10.jpg', 'img'),
(2936, 586, 'snow_3.jpg', 'snow_3.jpg', 'img');

-- --------------------------------------------------------

--
-- Structure de la table `tricks`
--

DROP TABLE IF EXISTS `tricks`;
CREATE TABLE IF NOT EXISTS `tricks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E1D902C1989D9B62` (`slug`),
  KEY `IDX_E1D902C169CCBE9A` (`author_id_id`)
) ENGINE=InnoDB AUTO_INCREMENT=587 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tricks`
--

INSERT INTO `tricks` (`id`, `author_id_id`, `name`, `description`, `created_at`, `update_at`, `slug`, `main_image`) VALUES
(567, 686, 'Quisquam harum fugit.', 'Cependant M. Boulanger congédia son domestique, en l\'engageant à se torturer l\'esprit dans tous les fusils retombèrent. Alors on prétendit qu\'il s\'enfermait pour boire. Quelquefois pourtant, un.', '2019-04-28 17:08:39', NULL, 'quisquam-harum-fugit', 'snow_7.jpg'),
(568, 687, 'Quibusdam laborum.', 'Comme c\'était loin, tout au bord, elle venait dans le ciel vide qu\'elle éclairait; et alors, sans parti pris de résignation, une indulgence universelle. Son langage, à propos lui fournir une.', '2019-04-28 17:08:39', NULL, 'quibusdam-laborum', 'snow_7.jpg'),
(569, 688, 'Illum doloribus ut.', 'Les dames, en bonnet, avaient des habits, des redingotes, des vestes, des habits-vestes: -- bons habits, entourés de toute perception, de tout le monde encore serait endormi. Cette idée la fit.', '2019-04-28 17:08:39', NULL, 'illum-doloribus-ut', 'snow_7.jpg'),
(570, 689, 'Aut molestiae.', 'Mais on entendit trois coups sur la soie des écharpes, dépliées, dans toute l\'Europe. L\'ouvrier qui l\'a fondue en est mort de joie... -- Partons, dit Léon. Le bonhomme se remit en marche; puis.', '2019-04-28 17:08:39', NULL, 'aut-molestiae', 'snow_1.jpg'),
(571, 690, 'Enim consequuntur sit.', 'Le bruit de la confession? Homais attaqua la confession. Bournisien la défendit; il s\'étendit sur les chenets. Il y avait la poitrine les marques d\'une écuellée de braise qu\'une cuisinière.', '2019-04-28 17:08:40', NULL, 'enim-consequuntur-sit', 'snow_5.jpg'),
(572, 691, 'Accusantium a.', 'Charles offrit le sien. -- Ah! qu\'il doit être bon signe, n\'est-ce pas? moi qui t\'ai ruiné, pauvre homme! quel malheur!» Son nom s\'était répandu, sa clientèle s\'était accrue; et puis (Homais.', '2019-04-28 17:08:40', NULL, 'accusantium-a', 'snow_17.jpg'),
(573, 692, 'Autem non ea.', 'Ah! va-t\'en! disait-elle. Ou, d\'autres fois, brûlée plus fort contre les portes. Le vent soufflait par les premiers jours. Elle se détournait pas. Elle décachetait ses lettres, épiait ses démarches.', '2019-04-28 17:08:40', NULL, 'autem-non-ea', 'snow_5.jpg'),
(574, 693, 'Nobis alias.', 'Elle appelait Djali, la prenait sur son pupitre. Sa maison, du haut en bas par une multitude d\'hypothèses, ballottait au bord des golfes le parfum de la livrée. Le garçon de tempérament plus.', '2019-04-28 17:08:40', NULL, 'nobis-alias', 'snow_6.jpg'),
(575, 694, 'Illo dignissimos cumque.', 'Madame était dans sa soucoupe, sa demi-tasse de café à moitié de sa poche et saisit Emma par le vin de Pomard, cependant, lui excitait un peu les cendres du foyer, sentait l\'ennui plus lourd qui.', '2019-04-28 17:08:41', NULL, 'illo-dignissimos-cumque', 'snow_15.jpg'),
(576, 695, 'Eligendi dolorum.', 'Mais elle reprit vivement, à voix basse, en parlant vite: -- Est-ce possible! Ils ne voudront pas! -- Et non seulement, continua l\'apothicaire, les humains sont en butte à ces retours du sentiment.', '2019-04-28 17:08:41', NULL, 'eligendi-dolorum', 'snow_6.jpg'),
(577, 696, 'Dolorem harum.', 'Une aventure amenait parfois des fringales, et de flageolets qui piaulaient. Mais on veut faire le malheur de votre baraque, et que tout le reste, tels que des masses infinies, qu\'un poids énorme.', '2019-04-28 17:08:41', NULL, 'dolorem-harum', 'snow_2.jpg'),
(578, 697, 'Est iusto.', 'Et puis, l\'eau de Seltz, pour se donner du coeur, l\'élégance des habitudes et les sillons lui parurent écrits dans une boutique, je restais dans la diligence par le haut, et, de temps à autre, comme.', '2019-04-28 17:08:41', NULL, 'est-iusto', 'snow_7.jpg'),
(579, 698, 'Consequuntur doloremque.', 'Et elle s\'avança, elle regarda au loin, quelque part. -- Entendez-vous un chien écrasé, une grange incendiée, une femme mariée; et aussitôt la bonne demoiselle elle-même avalait de longs fils clairs.', '2019-04-28 17:08:41', NULL, 'consequuntur-doloremque', 'snow_13.jpg'),
(580, 699, 'Nobis alias expedita.', 'Oui, du capharnaüm! L\'apothicaire appelait ainsi la bouteille d\'aplomb sur la table, et, sur la soie du tablier. -- Laisse-moi! dit celle-ci en l\'écartant avec la mienne, cependant! Emma sourit.', '2019-04-28 17:08:42', NULL, 'nobis-alias-expedita', 'snow_17.jpg'),
(581, 700, 'Provident nam sunt.', 'Par où commencerai-je?» Et à mesure qu\'elle l\'envisageait, la monotonie du dîner. Un garde-chasse, guéri par Monsieur, d\'une fluxion de poitrine, parce qu\'elle n\'était la sienne. Mais le ton.', '2019-04-28 17:08:42', NULL, 'provident-nam-sunt', 'snow_3.jpg'),
(582, 701, 'Autem facere dicta.', 'Adolphe..., Dodolphe..., je crois.» Elle frissonna. -- Tu en es sûr? -- Certainement. -- C\'est celui qui, dans n\'importe quel moyen, l\'occasion permanente de se sentir humiliée de la langue. Les.', '2019-04-28 17:08:42', NULL, 'autem-facere-dicta', 'snow_11.jpg'),
(583, 702, 'Odit reprehenderit.', 'Sais-tu à quoi M. Bournisien répondit qu\'il ne parlât plus tard, au lever de la possession d\'eux-mêmes, qu\'ils se disaient, et le violon recommença. On les regardait. Il croyait entendre l\'haleine.', '2019-04-28 17:08:42', NULL, 'odit-reprehenderit', 'snow_5.jpg'),
(584, 703, 'Dolor mollitia.', 'Elle fit une longue énumération de toutes les pages, forêts sombres, troubles du coeur, il but trois cafés l\'un sur l\'autre. Il se calmait cependant, et, à travers les branches du jasmin sans.', '2019-04-28 17:08:43', NULL, 'dolor-mollitia', 'snow_13.jpg'),
(585, 704, 'Consequuntur rem.', 'Le ménétrier allait en tête, rapière au mollet, canne au poing, plus majestueux qu\'un cardinal et reluisant comme un grenier dont la bretelle dure lui fatiguait l\'épaule; et, tantôt dolente et.', '2019-04-28 17:08:43', NULL, 'consequuntur-rem', 'snow_19.jpg'),
(586, 705, 'Voluptatum officia est.', 'Les verres à patte!!! souffla Homais. -- Silence! exclama son mari, remarquant sa pâleur, lui demandait à sortir de table. Puis elle se perdait. Rodolphe l\'interrompit, affirmant qu\'il se mît avec.', '2019-04-28 17:08:43', NULL, 'voluptatum-officia-est', 'snow_1.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `tricks_category`
--

DROP TABLE IF EXISTS `tricks_category`;
CREATE TABLE IF NOT EXISTS `tricks_category` (
  `tricks_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`tricks_id`,`category_id`),
  KEY `IDX_2656C2663B153154` (`tricks_id`),
  KEY `IDX_2656C26612469DE2` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tricks_category`
--

INSERT INTO `tricks_category` (`tricks_id`, `category_id`) VALUES
(567, 1257),
(567, 1259),
(568, 1258),
(568, 1262),
(569, 1249),
(569, 1258),
(570, 1253),
(570, 1263),
(571, 1249),
(571, 1256),
(572, 1262),
(572, 1263),
(573, 1249),
(573, 1260),
(574, 1251),
(574, 1263),
(575, 1253),
(575, 1261),
(576, 1249),
(576, 1257),
(577, 1254),
(577, 1264),
(578, 1258),
(578, 1259),
(579, 1249),
(579, 1261),
(580, 1253),
(580, 1262),
(581, 1248),
(581, 1252),
(582, 1248),
(582, 1262),
(583, 1249),
(583, 1264),
(584, 1259),
(584, 1261),
(585, 1258),
(585, 1262),
(586, 1253),
(586, 1259);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `devise` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL,
  `rgpd` tinyint(1) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_expir_token` datetime DEFAULT NULL,
  `actif` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=707 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `fname`, `lname`, `avatar`, `devise`, `slug`, `date_create`, `rgpd`, `token`, `date_expir_token`, `actif`) VALUES
(686, 'Élodie-Gonzalez@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$TFNNeVVPL0tIZm9tdUpNdw$URcsmB9oufwOzgLIU3s5l4lnOtE9zAfo04EyENJ6CLk', 'Élodie', 'Gonzalez', 'profil_5.jpg', 'Mr Élodie pour vous servir !', 'lodiegonzalez', '2021-04-16 06:56:56', 1, NULL, NULL, 0),
(687, 'Théodore-Legrand@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$MkZLTTNyM0QxL3NIb0xNbw$aQMtLAE9Dl/x/WH3rtQYRNFuRMhyVe4OY0UGFhuxcfA', 'Théodore', 'Legrand', 'profil_14.jpg', 'Mr Théodore pour vous servir !', 'th-odorelegrand', '2021-03-14 08:55:57', 1, NULL, NULL, 0),
(688, 'Christophe-Hamel@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$Y3NEYWdTVXF3dGRCTngybA$lZj0mrVidsva3UgrIMfcFmWmwRqsyniFu7RwDBIfv3g', 'Christophe', 'Hamel', 'profil_20.jpg', 'Mr Christophe pour vous servir !', 'christophehamel', '2021-04-20 10:13:55', 1, NULL, NULL, 0),
(689, 'Susan-Bourgeois@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$T0laSHV0NFR0Z05ObE5OQg$LqMU3TAV7p4NoZCdNGPXuifK2EdDnpPVd0YMjkJxnOY', 'Susan', 'Bourgeois', 'profil_6.jpg', 'Mr Susan pour vous servir !', 'susanbourgeois', '2021-01-10 23:51:41', 1, NULL, NULL, 0),
(690, 'Charles-Gallet@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$UDVKTWYzd1BWaTdJTE9KTQ$u87iHEgM0MrqaGQMd84FgMZuHt3Whje3/pbuFyhbrhQ', 'Charles', 'Gallet', 'profil_12.jpg', 'Mr Charles pour vous servir !', 'charlesgallet', '2021-04-08 17:42:36', 1, NULL, NULL, 0),
(691, 'Alex-Colas@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$b1EwT2VZMmlOWjRiVkg0SQ$FC1KVTa+5FFt94m1t3VBZrtQ6kvv8YelS941K62Lak8', 'Alex', 'Colas', 'profil_12.jpg', 'Mr Alex pour vous servir !', 'alexcolas', '2021-02-27 09:58:47', 1, NULL, NULL, 0),
(692, 'Aurore-De Oliveira@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$aHk1TERveHI5LlVralNQWA$/znmpTh3VqQWIjVRO3AJvy1J+Ft321iF48fYizOFcso', 'Aurore', 'De Oliveira', 'profil_16.jpg', 'Mr Aurore pour vous servir !', 'aurorede-oliveira', '2021-01-05 07:36:33', 1, NULL, NULL, 0),
(693, 'Jérôme-Julien@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$TnBMNkxKM2ZYUU12S0dmaA$u9RrDxKFyuIHgXM7N0oOebmLX0u7PEP8eEF1Jz39eps', 'Jérôme', 'Julien', 'profil_19.jpg', 'Mr Jérôme pour vous servir !', 'j-r-mejulien', '2021-04-18 10:16:37', 1, NULL, NULL, 0),
(694, 'Robert-Richard@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$dUlmaks5dVZkNmROTTVzbg$h/mVQTHHX47l/JNy/1Mgmo5OSvU+7lzRuLNKyU+cZVw', 'Robert', 'Richard', 'profil_16.jpg', 'Mr Robert pour vous servir !', 'robertrichard', '2021-01-11 07:50:07', 1, NULL, NULL, 0),
(695, 'Adèle-Laporte@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$MjlxSXFiOUxPOFIxREhFMg$OawnI5Od/CRlFrA1YdYIDjoIwc3yFkcAaDFFI5IG6NA', 'Adèle', 'Laporte', 'profil_2.jpg', 'Mr Adèle pour vous servir !', 'ad-lelaporte', '2021-04-21 12:35:36', 1, NULL, NULL, 0),
(696, 'Claude-Leroy@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$azEuZEdFSlhhREF3WW1QRg$Vrxdm+Xje/taYaw7Pse+K6aR6mlhA34CxgrEKINKgsQ', 'Claude', 'Leroy', 'profil_6.jpg', 'Mr Claude pour vous servir !', 'claudeleroy', '2021-03-21 09:00:40', 1, NULL, NULL, 0),
(697, 'Margaux-Marechal@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$MWlQLnZZSXcwYkhKdnUwQw$OkdHDErm8vJKNWJz4voxDKVNvMCN0JxdK241bDkGjJ0', 'Margaux', 'Marechal', 'profil_17.jpg', 'Mr Margaux pour vous servir !', 'margauxmarechal', '2021-04-23 09:52:23', 1, NULL, NULL, 0),
(698, 'Louis-Marie@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$M0xQejZaSklWWlJJR2VIWA$1fEEp36aTjs37dwxb1YAdcwExASIfIucAfNpFIc2PUU', 'Louis', 'Marie', 'profil_10.jpg', 'Mr Louis pour vous servir !', 'louismarie', '2021-02-26 04:20:42', 1, NULL, NULL, 0),
(699, 'Agathe-Traore@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$alNCSlJKenBtOTYzV25DYw$5bmpwzE+S85sO2c3sBX+dfpucmof89woEq/ed7mZZwI', 'Agathe', 'Traore', 'profil_7.jpg', 'Mr Agathe pour vous servir !', 'agathetraore', '2021-03-08 03:56:50', 1, NULL, NULL, 0),
(700, 'Alexandre-Levy@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$aG9Ydmc0WnB4WFdLNGdrcA$G+mMb+JqbKvNswzvdVMkMXlsKquN5/PR9AIxA48ChAk', 'Alexandre', 'Levy', 'profil_19.jpg', 'Mr Alexandre pour vous servir !', 'alexandrelevy', '2021-04-11 20:44:09', 1, NULL, NULL, 0),
(701, 'Alexandria-Aubert@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$SG1QWlVFdTBUQlk2djcuTQ$e4wwjrJWedcQTUYlub2oCQOGS8v7jj9NPqIzCrdDe48', 'Alexandria', 'Aubert', 'profil_17.jpg', 'Mr Alexandria pour vous servir !', 'alexandriaaubert', '2021-01-24 02:52:59', 1, NULL, NULL, 0),
(702, 'William-Bigot@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$WVhtcU9nRW0uL0RNWUZwQw$/sq0dM6DEaIlcXD9ms5RiCch8+6cSTjejRLsNW+2yus', 'William', 'Bigot', 'profil_18.jpg', 'Mr William pour vous servir !', 'williambigot', '2021-03-15 20:29:04', 1, NULL, NULL, 0),
(703, 'Jacqueline-Bouvier@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$MnZUWDN0M3FVUTVYVUcwUQ$Xzy95AlJyY4HLxVYZhVdXZ9CO001jbnIibnInjz+mAA', 'Jacqueline', 'Bouvier', 'profil_19.jpg', 'Mr Jacqueline pour vous servir !', 'jacquelinebouvier', '2021-01-09 05:43:44', 1, NULL, NULL, 0),
(704, 'Michèle-Evrard@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$NEV1cEtuaGYwRmpsUGxHWA$lcmWqXNYwJeS1hyrUqMUZnRrq9lzH165A+NXsZ8bpbc', 'Michèle', 'Evrard', 'profil_11.jpg', 'Mr Michèle pour vous servir !', 'mich-leevrard', '2021-02-08 15:04:22', 1, NULL, NULL, 0),
(705, 'Maryse-Dos Santos@snowtrick.com', 'ROLE_USER', '$argon2id$v=19$m=65536,t=4,p=1$V0JpaWZUcDVMNEIxMzV4Zw$Mljn2FILywJSmVbyo3drI9APxma/vUTGNJ1B6lqyz8o', 'Maryse', 'Dos Santos', 'profil_16.jpg', 'Mr Maryse pour vous servir !', 'marysedos-santos', '2021-03-21 10:26:04', 1, NULL, NULL, 0),
(706, 'toto@toto.com', 'ROLE_ADMIN', '$argon2id$v=19$m=65536,t=4,p=1$Mk5iOEMxTWZ5V1pHMmlZUQ$Aplt7uLVHAkmCb0gsulXE1GWeWZHa2qDVWFRGYPjzzc', 'Open', 'Alix', 'profil_5.jpg', 'Née pour coder', 'openalix', '2019-04-28 17:08:43', 1, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tricks_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7CC7DA2C3B153154` (`tricks_id`)
) ENGINE=InnoDB AUTO_INCREMENT=649 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id`, `tricks_id`, `name`, `path`, `type`) VALUES
(569, 567, 'https://www.youtube.com/embed/t705_V-RDcQ', 'https://www.youtube.com/embed/t705_V-RDcQ', 'video'),
(570, 567, 'https://www.youtube.com/embed/he03dVkhLTM', 'https://www.youtube.com/embed/he03dVkhLTM', 'video'),
(571, 567, 'https://www.youtube.com/embed/t705_V-RDcQ', 'https://www.youtube.com/embed/t705_V-RDcQ', 'video'),
(572, 567, 'https://www.youtube.com/embed/FuZc3fTmUnc', 'https://www.youtube.com/embed/FuZc3fTmUnc', 'video'),
(573, 568, 'https://www.youtube.com/embed/he03dVkhLTM', 'https://www.youtube.com/embed/he03dVkhLTM', 'video'),
(574, 568, 'https://www.youtube.com/embed/msR60AGpvuk', 'https://www.youtube.com/embed/msR60AGpvuk', 'video'),
(575, 568, 'https://www.youtube.com/embed/t705_V-RDcQ', 'https://www.youtube.com/embed/t705_V-RDcQ', 'video'),
(576, 568, 'https://www.youtube.com/embed/msR60AGpvuk', 'https://www.youtube.com/embed/msR60AGpvuk', 'video'),
(577, 569, 'https://www.youtube.com/embed/UGdif-dwu-8', 'https://www.youtube.com/embed/UGdif-dwu-8', 'video'),
(578, 569, 'https://www.youtube.com/embed/V9xuy-rVj9w', 'https://www.youtube.com/embed/V9xuy-rVj9w', 'video'),
(579, 569, 'https://www.youtube.com/embed/msR60AGpvuk', 'https://www.youtube.com/embed/msR60AGpvuk', 'video'),
(580, 569, 'https://www.youtube.com/embed/FuZc3fTmUnc', 'https://www.youtube.com/embed/FuZc3fTmUnc', 'video'),
(581, 570, 'https://www.youtube.com/embed/FuZc3fTmUnc', 'https://www.youtube.com/embed/FuZc3fTmUnc', 'video'),
(582, 570, 'https://www.youtube.com/embed/R2Cp1RumorU', 'https://www.youtube.com/embed/R2Cp1RumorU', 'video'),
(583, 570, 'https://www.youtube.com/embed/aINlzgrOovI', 'https://www.youtube.com/embed/aINlzgrOovI', 'video'),
(584, 570, 'https://www.youtube.com/embed/t705_V-RDcQ', 'https://www.youtube.com/embed/t705_V-RDcQ', 'video'),
(585, 571, 'https://www.youtube.com/embed/UGdif-dwu-8', 'https://www.youtube.com/embed/UGdif-dwu-8', 'video'),
(586, 571, 'https://www.youtube.com/embed/R2Cp1RumorU', 'https://www.youtube.com/embed/R2Cp1RumorU', 'video'),
(587, 571, 'https://www.youtube.com/embed/UGdif-dwu-8', 'https://www.youtube.com/embed/UGdif-dwu-8', 'video'),
(588, 571, 'https://www.youtube.com/embed/V9xuy-rVj9w', 'https://www.youtube.com/embed/V9xuy-rVj9w', 'video'),
(589, 572, 'https://www.youtube.com/embed/aINlzgrOovI', 'https://www.youtube.com/embed/aINlzgrOovI', 'video'),
(590, 572, 'https://www.youtube.com/embed/UGdif-dwu-8', 'https://www.youtube.com/embed/UGdif-dwu-8', 'video'),
(591, 572, 'https://www.youtube.com/embed/1TJ08caetkw', 'https://www.youtube.com/embed/1TJ08caetkw', 'video'),
(592, 572, 'https://www.youtube.com/embed/UGdif-dwu-8', 'https://www.youtube.com/embed/UGdif-dwu-8', 'video'),
(593, 573, 'https://www.youtube.com/embed/he03dVkhLTM', 'https://www.youtube.com/embed/he03dVkhLTM', 'video'),
(594, 573, 'https://www.youtube.com/embed/UGdif-dwu-8', 'https://www.youtube.com/embed/UGdif-dwu-8', 'video'),
(595, 573, 'https://www.youtube.com/embed/1TJ08caetkw', 'https://www.youtube.com/embed/1TJ08caetkw', 'video'),
(596, 573, 'https://www.youtube.com/embed/t705_V-RDcQ', 'https://www.youtube.com/embed/t705_V-RDcQ', 'video'),
(597, 574, 'https://www.youtube.com/embed/R2Cp1RumorU', 'https://www.youtube.com/embed/R2Cp1RumorU', 'video'),
(598, 574, 'https://www.youtube.com/embed/msR60AGpvuk', 'https://www.youtube.com/embed/msR60AGpvuk', 'video'),
(599, 574, 'https://www.youtube.com/embed/1TJ08caetkw', 'https://www.youtube.com/embed/1TJ08caetkw', 'video'),
(600, 574, 'https://www.youtube.com/embed/1TJ08caetkw', 'https://www.youtube.com/embed/1TJ08caetkw', 'video'),
(601, 575, 'https://www.youtube.com/embed/he03dVkhLTM', 'https://www.youtube.com/embed/he03dVkhLTM', 'video'),
(602, 575, 'https://www.youtube.com/embed/V9xuy-rVj9w', 'https://www.youtube.com/embed/V9xuy-rVj9w', 'video'),
(603, 575, 'https://www.youtube.com/embed/he03dVkhLTM', 'https://www.youtube.com/embed/he03dVkhLTM', 'video'),
(604, 575, 'https://www.youtube.com/embed/FuZc3fTmUnc', 'https://www.youtube.com/embed/FuZc3fTmUnc', 'video'),
(605, 576, 'https://www.youtube.com/embed/aINlzgrOovI', 'https://www.youtube.com/embed/aINlzgrOovI', 'video'),
(606, 576, 'https://www.youtube.com/embed/FuZc3fTmUnc', 'https://www.youtube.com/embed/FuZc3fTmUnc', 'video'),
(607, 576, 'https://www.youtube.com/embed/FuZc3fTmUnc', 'https://www.youtube.com/embed/FuZc3fTmUnc', 'video'),
(608, 576, 'https://www.youtube.com/embed/UGdif-dwu-8', 'https://www.youtube.com/embed/UGdif-dwu-8', 'video'),
(609, 577, 'https://www.youtube.com/embed/FuZc3fTmUnc', 'https://www.youtube.com/embed/FuZc3fTmUnc', 'video'),
(610, 577, 'https://www.youtube.com/embed/V9xuy-rVj9w', 'https://www.youtube.com/embed/V9xuy-rVj9w', 'video'),
(611, 577, 'https://www.youtube.com/embed/FuZc3fTmUnc', 'https://www.youtube.com/embed/FuZc3fTmUnc', 'video'),
(612, 577, 'https://www.youtube.com/embed/1TJ08caetkw', 'https://www.youtube.com/embed/1TJ08caetkw', 'video'),
(613, 578, 'https://www.youtube.com/embed/1TJ08caetkw', 'https://www.youtube.com/embed/1TJ08caetkw', 'video'),
(614, 578, 'https://www.youtube.com/embed/t705_V-RDcQ', 'https://www.youtube.com/embed/t705_V-RDcQ', 'video'),
(615, 578, 'https://www.youtube.com/embed/msR60AGpvuk', 'https://www.youtube.com/embed/msR60AGpvuk', 'video'),
(616, 578, 'https://www.youtube.com/embed/msR60AGpvuk', 'https://www.youtube.com/embed/msR60AGpvuk', 'video'),
(617, 579, 'https://www.youtube.com/embed/V9xuy-rVj9w', 'https://www.youtube.com/embed/V9xuy-rVj9w', 'video'),
(618, 579, 'https://www.youtube.com/embed/t705_V-RDcQ', 'https://www.youtube.com/embed/t705_V-RDcQ', 'video'),
(619, 579, 'https://www.youtube.com/embed/msR60AGpvuk', 'https://www.youtube.com/embed/msR60AGpvuk', 'video'),
(620, 579, 'https://www.youtube.com/embed/V9xuy-rVj9w', 'https://www.youtube.com/embed/V9xuy-rVj9w', 'video'),
(621, 580, 'https://www.youtube.com/embed/aINlzgrOovI', 'https://www.youtube.com/embed/aINlzgrOovI', 'video'),
(622, 580, 'https://www.youtube.com/embed/UGdif-dwu-8', 'https://www.youtube.com/embed/UGdif-dwu-8', 'video'),
(623, 580, 'https://www.youtube.com/embed/1TJ08caetkw', 'https://www.youtube.com/embed/1TJ08caetkw', 'video'),
(624, 580, 'https://www.youtube.com/embed/he03dVkhLTM', 'https://www.youtube.com/embed/he03dVkhLTM', 'video'),
(625, 581, 'https://www.youtube.com/embed/msR60AGpvuk', 'https://www.youtube.com/embed/msR60AGpvuk', 'video'),
(626, 581, 'https://www.youtube.com/embed/1TJ08caetkw', 'https://www.youtube.com/embed/1TJ08caetkw', 'video'),
(627, 581, 'https://www.youtube.com/embed/0uGETVnkujA', 'https://www.youtube.com/embed/0uGETVnkujA', 'video'),
(628, 581, 'https://www.youtube.com/embed/R2Cp1RumorU', 'https://www.youtube.com/embed/R2Cp1RumorU', 'video'),
(629, 582, 'https://www.youtube.com/embed/he03dVkhLTM', 'https://www.youtube.com/embed/he03dVkhLTM', 'video'),
(630, 582, 'https://www.youtube.com/embed/R2Cp1RumorU', 'https://www.youtube.com/embed/R2Cp1RumorU', 'video'),
(631, 582, 'https://www.youtube.com/embed/0uGETVnkujA', 'https://www.youtube.com/embed/0uGETVnkujA', 'video'),
(632, 582, 'https://www.youtube.com/embed/UGdif-dwu-8', 'https://www.youtube.com/embed/UGdif-dwu-8', 'video'),
(633, 583, 'https://www.youtube.com/embed/1TJ08caetkw', 'https://www.youtube.com/embed/1TJ08caetkw', 'video'),
(634, 583, 'https://www.youtube.com/embed/V9xuy-rVj9w', 'https://www.youtube.com/embed/V9xuy-rVj9w', 'video'),
(635, 583, 'https://www.youtube.com/embed/0uGETVnkujA', 'https://www.youtube.com/embed/0uGETVnkujA', 'video'),
(636, 583, 'https://www.youtube.com/embed/t705_V-RDcQ', 'https://www.youtube.com/embed/t705_V-RDcQ', 'video'),
(637, 584, 'https://www.youtube.com/embed/1TJ08caetkw', 'https://www.youtube.com/embed/1TJ08caetkw', 'video'),
(638, 584, 'https://www.youtube.com/embed/msR60AGpvuk', 'https://www.youtube.com/embed/msR60AGpvuk', 'video'),
(639, 584, 'https://www.youtube.com/embed/msR60AGpvuk', 'https://www.youtube.com/embed/msR60AGpvuk', 'video'),
(640, 584, 'https://www.youtube.com/embed/msR60AGpvuk', 'https://www.youtube.com/embed/msR60AGpvuk', 'video'),
(641, 585, 'https://www.youtube.com/embed/he03dVkhLTM', 'https://www.youtube.com/embed/he03dVkhLTM', 'video'),
(642, 585, 'https://www.youtube.com/embed/aINlzgrOovI', 'https://www.youtube.com/embed/aINlzgrOovI', 'video'),
(643, 585, 'https://www.youtube.com/embed/0uGETVnkujA', 'https://www.youtube.com/embed/0uGETVnkujA', 'video'),
(644, 585, 'https://www.youtube.com/embed/UGdif-dwu-8', 'https://www.youtube.com/embed/UGdif-dwu-8', 'video'),
(645, 586, 'https://www.youtube.com/embed/V9xuy-rVj9w', 'https://www.youtube.com/embed/V9xuy-rVj9w', 'video'),
(646, 586, 'https://www.youtube.com/embed/1TJ08caetkw', 'https://www.youtube.com/embed/1TJ08caetkw', 'video'),
(647, 586, 'https://www.youtube.com/embed/he03dVkhLTM', 'https://www.youtube.com/embed/he03dVkhLTM', 'video'),
(648, 586, 'https://www.youtube.com/embed/R2Cp1RumorU', 'https://www.youtube.com/embed/R2Cp1RumorU', 'video');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C3B153154` FOREIGN KEY (`tricks_id`) REFERENCES `tricks` (`id`),
  ADD CONSTRAINT `FK_9474526CF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `FK_6A2CA10C3B153154` FOREIGN KEY (`tricks_id`) REFERENCES `tricks` (`id`);

--
-- Contraintes pour la table `tricks`
--
ALTER TABLE `tricks`
  ADD CONSTRAINT `FK_E1D902C169CCBE9A` FOREIGN KEY (`author_id_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tricks_category`
--
ALTER TABLE `tricks_category`
  ADD CONSTRAINT `FK_2656C26612469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_2656C2663B153154` FOREIGN KEY (`tricks_id`) REFERENCES `tricks` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `FK_7CC7DA2C3B153154` FOREIGN KEY (`tricks_id`) REFERENCES `tricks` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
