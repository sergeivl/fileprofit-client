CREATE TABLE `fp_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `title_seo` varchar(255) DEFAULT NULL,
  `meta_d` varchar(255) DEFAULT NULL,
  `text` text,
  `alias` varchar(255) NOT NULL,
  `status` enum('published','not_published') NOT NULL DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `fp_games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `meta_d` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `alias` text NOT NULL,
  `date_release` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `more_info` text,
  `system_requirements` text,
  `trailer` varchar(255) DEFAULT NULL,
  `developer` varchar(255) NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `review` text,
  `torrent` varchar(255) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `screenshots` text,
  `status` enum('published','not_published') NOT NULL DEFAULT 'published',
  `operatingSystem` varchar(255) DEFAULT NULL,
  `processorRequirements` varchar(255) DEFAULT NULL,
  `memoryRequirements` varchar(255) DEFAULT NULL,
  `storagerequirements` varchar(255) DEFAULT NULL,
  `videocard` varchar(255) DEFAULT NULL,
  `fileSize` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `fp_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `title_seo` varchar(255) NOT NULL,
  `meta_d` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `alias` varchar(255) NOT NULL,
  `status` enum('not_published','published') NOT NULL DEFAULT 'not_published',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `fp_taxonomy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_taxonomy` (`game_id`,`category_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `fp_taxonomy_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `fp_games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fp_taxonomy_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `fp_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `fp_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role` enum('author','moder','admin') NOT NULL DEFAULT 'author',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;