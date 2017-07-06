CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `login_token` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `can_edit_admins` tinyint(1) NOT NULL DEFAULT '0',
  `can_edit_system` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admin` (`id`, `username`, `password_hash`, `login_token`, `can_edit_admins`, `can_edit_system`) VALUES
(1, 'admin', '$2y$10$Lbd188cO/BgGcAGy6aYAre.1IwpI25Upkp2B/YMX3hIG4pLtaMOem', 'W7nN7o64EsarTPF9GqdTnKTUOLiUkVv6Mc9du5htkwwACZWLcr', 1, 1);

CREATE TABLE `advertiser` (
  `id` int(10) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `login_token` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `score_remaining` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `advertiser_ad` (
  `id` int(10) NOT NULL,
  `advertiser_id` int(10) NOT NULL,
  `type_media_format_id` int(10) NOT NULL,
  `country_filter_excludes` tinyint(1) NOT NULL DEFAULT '1',
  `media_url` varchar(255) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `advertiser_ad_country_filter_list` (
  `advertiser_ad_id` int(10) NOT NULL,
  `country_code` varchar(10) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `advertiser_ad_developer_games` (
  `advertiser_ad_id` int(10) NOT NULL,
  `developer_game_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `advertiser_statistics` (
  `advertiser_id` int(10) NOT NULL,
  `unique_hits` bigint(10) NOT NULL DEFAULT '0',
  `unique_views` bigint(10) NOT NULL DEFAULT '0',
  `unique_hears` bigint(10) NOT NULL DEFAULT '0',
  `total_hits` bigint(10) NOT NULL DEFAULT '0',
  `total_views` bigint(10) NOT NULL DEFAULT '0',
  `total_hears` bigint(10) NOT NULL DEFAULT '0',
  `total_hit_time` double NOT NULL DEFAULT '0',
  `total_view_time` double NOT NULL DEFAULT '0',
  `total_hear_time` double NOT NULL DEFAULT '0',
  `total_score` double NOT NULL DEFAULT '0',
  `total_screen_percentage` double NOT NULL DEFAULT '0',
  `total_screen_position_x` double NOT NULL DEFAULT '0',
  `total_screen_position_y` double NOT NULL DEFAULT '0',
  `total_blocked_percentage` double NOT NULL DEFAULT '0',
  `total_volume_percent` double NOT NULL DEFAULT '0',
  `unique_hits_platform_windows` bigint(10) NOT NULL DEFAULT '0',
  `unique_hits_platform_mac` bigint(10) NOT NULL DEFAULT '0',
  `unique_hits_platform_linux` bigint(10) NOT NULL DEFAULT '0',
  `unique_hits_platform_android` bigint(10) NOT NULL DEFAULT '0',
  `unique_hits_platform_ios` bigint(10) NOT NULL DEFAULT '0',
  `unique_hits_platform_xboxone` bigint(10) NOT NULL DEFAULT '0',
  `unique_hits_platform_ps4` bigint(10) NOT NULL DEFAULT '0',
  `unique_hits_platform_web` bigint(10) NOT NULL DEFAULT '0',
  `unique_hits_vr` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_platform_windows` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_platform_mac` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_platform_linux` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_platform_android` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_platform_ios` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_platform_xboxone` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_platform_ps4` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_platform_web` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_vr` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `advertiser_statistics_logged_ips` (
  `advertiser_id` int(10) NOT NULL,
  `ip` varchar(100) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `advertiser_statistics_per_country` (
  `advertiser_id` int(10) NOT NULL,
  `country_code` varchar(10) CHARACTER SET utf8mb4 NOT NULL,
  `unique_hits` bigint(10) NOT NULL DEFAULT '0',
  `total_hits` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `developer` (
  `id` int(10) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `login_token` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `access_token` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `score_earned` double NOT NULL DEFAULT '0',
  `score_paid_out` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `developer_game` (
  `id` int(10) NOT NULL,
  `developer_id` int(10) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `type_age_restriction_id` int(10) NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `developer_mode` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `developer_game_game_genres` (
  `developer_game_id` int(10) NOT NULL,
  `type_game_genre_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `developer_game_statistics` (
  `developer_game_id` int(10) NOT NULL,
  `unique_hits` bigint(10) NOT NULL DEFAULT '0',
  `unique_views` bigint(10) NOT NULL DEFAULT '0',
  `unique_hears` bigint(10) NOT NULL DEFAULT '0',
  `total_hits` bigint(10) NOT NULL DEFAULT '0',
  `total_views` bigint(10) NOT NULL DEFAULT '0',
  `total_hears` bigint(10) NOT NULL DEFAULT '0',
  `total_hit_time` double NOT NULL DEFAULT '0',
  `total_view_time` double NOT NULL DEFAULT '0',
  `total_hear_time` double NOT NULL DEFAULT '0',
  `total_score` double NOT NULL DEFAULT '0',
  `total_screen_percentage` double NOT NULL DEFAULT '0',
  `total_screen_position_x` double NOT NULL DEFAULT '0',
  `total_screen_position_y` double NOT NULL DEFAULT '0',
  `total_blocked_percentage` double NOT NULL DEFAULT '0',
  `total_volume_percent` double NOT NULL DEFAULT '0',
  `unique_hits_platform_windows` bigint(10) NOT NULL DEFAULT '0',
  `unique_hits_platform_mac` bigint(10) NOT NULL DEFAULT '0',
  `unique_hits_platform_linux` bigint(10) NOT NULL DEFAULT '0',
  `unique_hits_platform_android` bigint(10) NOT NULL DEFAULT '0',
  `unique_hits_platform_ios` bigint(10) NOT NULL DEFAULT '0',
  `unique_hits_platform_xboxone` bigint(10) NOT NULL DEFAULT '0',
  `unique_hits_platform_ps4` bigint(10) NOT NULL DEFAULT '0',
  `unique_hits_platform_web` bigint(10) NOT NULL DEFAULT '0',
  `unique_hits_vr` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_platform_windows` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_platform_mac` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_platform_linux` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_platform_android` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_platform_ios` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_platform_xboxone` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_platform_ps4` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_platform_web` bigint(10) NOT NULL DEFAULT '0',
  `total_hits_vr` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `developer_game_statistics_logged_ips` (
  `developer_game_id` int(10) NOT NULL,
  `ip` varchar(100) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `developer_game_statistics_per_country` (
  `developer_game_id` int(10) NOT NULL,
  `country_code` varchar(10) CHARACTER SET utf8mb4 NOT NULL,
  `unique_hits` bigint(10) NOT NULL DEFAULT '0',
  `total_hits` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `logged_ips` (
  `ip` varchar(100) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `type_age_restriction` (
  `id` int(10) NOT NULL,
  `minimum_age` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `type_game_genre` (
  `id` int(10) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `type_media` (
  `id` int(10) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `type_media` (`id`, `name`) VALUES
(1, 'Image'),
(3, 'Sound'),
(2, 'Video');

CREATE TABLE `type_media_format` (
  `id` int(10) NOT NULL,
  `type_media_id` int(10) NOT NULL,
  `type_media_format_duration_id` int(10) DEFAULT NULL,
  `aspect_ratio` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `type_media_format_duration` (
  `id` int(10) NOT NULL,
  `duration_seconds_min` double DEFAULT NULL,
  `duration_seconds_max` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `advertiser`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `advertiser_ad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advertiser_id` (`advertiser_id`),
  ADD KEY `type_media_format_id` (`type_media_format_id`);

ALTER TABLE `advertiser_ad_country_filter_list`
  ADD PRIMARY KEY (`advertiser_ad_id`,`country_code`);

ALTER TABLE `advertiser_ad_developer_games`
  ADD PRIMARY KEY (`advertiser_ad_id`,`developer_game_id`),
  ADD KEY `developer_game_id` (`developer_game_id`);

ALTER TABLE `advertiser_statistics`
  ADD PRIMARY KEY (`advertiser_id`);

ALTER TABLE `advertiser_statistics_logged_ips`
  ADD PRIMARY KEY (`advertiser_id`,`ip`);

ALTER TABLE `advertiser_statistics_per_country`
  ADD PRIMARY KEY (`advertiser_id`,`country_code`);

ALTER TABLE `developer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `developer_game`
  ADD PRIMARY KEY (`id`),
  ADD KEY `developer_id` (`developer_id`),
  ADD KEY `type_age_restriction_id` (`type_age_restriction_id`);

ALTER TABLE `developer_game_game_genres`
  ADD PRIMARY KEY (`developer_game_id`,`type_game_genre_id`),
  ADD KEY `type_game_genre_id` (`type_game_genre_id`);

ALTER TABLE `developer_game_statistics`
  ADD PRIMARY KEY (`developer_game_id`);

ALTER TABLE `developer_game_statistics_logged_ips`
  ADD PRIMARY KEY (`developer_game_id`,`ip`);

ALTER TABLE `developer_game_statistics_per_country`
  ADD PRIMARY KEY (`developer_game_id`,`country_code`);

ALTER TABLE `logged_ips`
  ADD PRIMARY KEY (`ip`);

ALTER TABLE `type_age_restriction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `minimum_age` (`minimum_age`);

ALTER TABLE `type_game_genre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `genre` (`name`);

ALTER TABLE `type_media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`name`);

ALTER TABLE `type_media_format`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_media_id` (`type_media_id`),
  ADD KEY `type_media_format_duration_id` (`type_media_format_duration_id`);

ALTER TABLE `type_media_format_duration`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `advertiser`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `advertiser_ad`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `developer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `developer_game`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `type_age_restriction`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `type_game_genre`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `type_media`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `type_media_format`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
ALTER TABLE `type_media_format_duration`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `advertiser_ad`
  ADD CONSTRAINT `advertiser_ad__advertiser_id` FOREIGN KEY (`advertiser_id`) REFERENCES `advertiser` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `advertiser_ad__type_media_format_id` FOREIGN KEY (`type_media_format_id`) REFERENCES `type_media_format` (`id`) ON UPDATE CASCADE;

ALTER TABLE `advertiser_ad_country_filter_list`
  ADD CONSTRAINT `advertiser_ad_country_filter_list__advertiser_ad_id` FOREIGN KEY (`advertiser_ad_id`) REFERENCES `advertiser_ad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `advertiser_ad_developer_games`
  ADD CONSTRAINT `advertiser_ad_developer_games__advertiser_ad_id` FOREIGN KEY (`advertiser_ad_id`) REFERENCES `advertiser_ad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `advertiser_ad_developer_games__developer_game_id` FOREIGN KEY (`developer_game_id`) REFERENCES `developer_game` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `advertiser_statistics`
  ADD CONSTRAINT `advertiser_statistics__advertiser_id` FOREIGN KEY (`advertiser_id`) REFERENCES `advertiser` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `advertiser_statistics_logged_ips`
  ADD CONSTRAINT `advertiser_statistics_logged_ips__advertiser_id` FOREIGN KEY (`advertiser_id`) REFERENCES `advertiser` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `advertiser_statistics_per_country`
  ADD CONSTRAINT `advertiser_statistics_per_country__advertiser_id` FOREIGN KEY (`advertiser_id`) REFERENCES `advertiser` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `developer_game`
  ADD CONSTRAINT `developer_game__developer_id` FOREIGN KEY (`developer_id`) REFERENCES `developer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `developer_game__type_age_restriction_id` FOREIGN KEY (`type_age_restriction_id`) REFERENCES `type_age_restriction` (`id`) ON UPDATE CASCADE;

ALTER TABLE `developer_game_game_genres`
  ADD CONSTRAINT `developer_game_game_genres__developer_game_id` FOREIGN KEY (`developer_game_id`) REFERENCES `developer_game` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `developer_game_game_genres__type_game_genre_id` FOREIGN KEY (`type_game_genre_id`) REFERENCES `type_game_genre` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `developer_game_statistics`
  ADD CONSTRAINT `developer_game_statistics__developer_game_id` FOREIGN KEY (`developer_game_id`) REFERENCES `developer_game` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `developer_game_statistics_logged_ips`
  ADD CONSTRAINT `developer_game_statistics_logged_ips__developer_game_id` FOREIGN KEY (`developer_game_id`) REFERENCES `developer_game` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `developer_game_statistics_per_country`
  ADD CONSTRAINT `developer_game_statistics_per_country__developer_game_id` FOREIGN KEY (`developer_game_id`) REFERENCES `developer_game` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `type_media_format`
  ADD CONSTRAINT `type_media_format__type_media_format_duration_id` FOREIGN KEY (`type_media_format_duration_id`) REFERENCES `type_media_format_duration` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `type_media_format__type_media_id` FOREIGN KEY (`type_media_id`) REFERENCES `type_media` (`id`) ON UPDATE CASCADE;
