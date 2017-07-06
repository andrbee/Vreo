CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `login_token` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `can_edit_admins` tinyint(1) NOT NULL DEFAULT '0',
  `can_edit_system` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admin` (`id`, `username`, `password_hash`, `login_token`, `can_edit_admins`, `can_edit_system`) VALUES
(1, 'admin', '$2y$10$Lbd188cO/BgGcAGy6aYAre.1IwpI25Upkp2B/YMX3hIG4pLtaMOem', 'W7nN7o64EsarTPF9GqdTnKTUOLiUkVv6Mc9du5htkwwACZWLcr', 1, 1),
(2, 'test', '$2y$10$OHHrn69FJiyiVPL143rSSuc45RmEFSsbjroBohz4tMqn4lUwer7Jq', 'HjXrPoBpnGR89ammviagi2TBRTDz2NXUaeZO6ai1b4ZJgUEGF8', 1, 1),
(18, 'test2', '$2y$10$XgtPIv6Z/7tEiW1jsMx5c.J.Tb4mi52lRXOu2SRXD5L58SdTJMhJa', 'qBZfItOgyS2u02vUGHyYG21FBOhrwe8i2ZXFflAxKYmnC879tw', 0, 1),
(19, 'test3', '$2y$10$u3wNN0XlQBN.We3dP2s64u.if/8eaoMURFHOfRb7CCHaYLw0dztWy', 'dkomuSZmhgkLrt1gjX95JGjX28C66gEdfyuxjXKMEXva7wnp17', 0, 1);

CREATE TABLE `advertiser` (
  `id` int(10) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `login_token` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `score_remaining` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `advertiser` (`id`, `username`, `password_hash`, `login_token`, `score_remaining`) VALUES
(1, 'test', '$2y$10$OHHrn69FJiyiVPL143rSSuc45RmEFSsbjroBohz4tMqn4lUwer7Jq', 'sdfsdfdsf', 99990),
(2, 'test2', '$2y$10$LsDTIafT5WKaMdXDYlUSou22HuwW4rOnuPVNH.HWND1khJZqrSo9S', '1U70Uezj2iHkaqZbtvoqIQoc6iX3ldy7Eq9XLicGSEHSJQ5DxI', 0);

CREATE TABLE `advertiser_ad` (
  `id` int(10) NOT NULL,
  `advertiser_id` int(10) NOT NULL,
  `type_media_format_id` int(10) NOT NULL,
  `country_filter_excludes` tinyint(1) NOT NULL DEFAULT '1',
  `media_url` varchar(255) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `advertiser_ad` (`id`, `advertiser_id`, `type_media_format_id`, `country_filter_excludes`, `media_url`) VALUES
(1, 1, 1, 1, 'https://public.lowentry.com/files/test_data/TestImagePng.png'),
(2, 1, 2, 1, 'https://public.lowentry.com/files/test_data/TestVideoMp4.mp4'),
(3, 1, 3, 1, 'https://public.lowentry.com/files/test_data/TestAudioMp3.mp3');

CREATE TABLE `advertiser_ad_country_filter_list` (
  `advertiser_ad_id` int(10) NOT NULL,
  `country_code` varchar(10) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `advertiser_ad_country_filter_list` (`advertiser_ad_id`, `country_code`) VALUES
(2, 'EN'),
(2, 'FR');

CREATE TABLE `advertiser_ad_developer_games` (
  `advertiser_ad_id` int(10) NOT NULL,
  `developer_game_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `advertiser_ad_developer_games` (`advertiser_ad_id`, `developer_game_id`) VALUES
(1, 1),
(2, 1),
(3, 1);

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

INSERT INTO `advertiser_statistics` (`advertiser_id`, `unique_hits`, `unique_views`, `unique_hears`, `total_hits`, `total_views`, `total_hears`, `total_hit_time`, `total_view_time`, `total_hear_time`, `total_score`, `total_screen_percentage`, `total_screen_position_x`, `total_screen_position_y`, `total_blocked_percentage`, `total_volume_percent`, `unique_hits_platform_windows`, `unique_hits_platform_mac`, `unique_hits_platform_linux`, `unique_hits_platform_android`, `unique_hits_platform_ios`, `unique_hits_platform_xboxone`, `unique_hits_platform_ps4`, `unique_hits_platform_web`, `unique_hits_vr`, `total_hits_platform_windows`, `total_hits_platform_mac`, `total_hits_platform_linux`, `total_hits_platform_android`, `total_hits_platform_ios`, `total_hits_platform_xboxone`, `total_hits_platform_ps4`, `total_hits_platform_web`, `total_hits_vr`) VALUES
(1, 1, 1, 1, 1, 1, 1, 3.0000360012054443, 3.0000360012054443, 3.0000360012054443, 10, 57.747459411621094, 150.140869140625, 133.37789916992188, 3.452397346496582, 202.76222229003906, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0);

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

INSERT INTO `advertiser_statistics_per_country` (`advertiser_id`, `country_code`, `unique_hits`, `total_hits`) VALUES
(1, 'NL', 1, 1);

CREATE TABLE `developer` (
  `id` int(10) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `login_token` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `access_token` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `score_earned` double NOT NULL DEFAULT '0',
  `score_paid_out` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `developer` (`id`, `username`, `password_hash`, `login_token`, `access_token`, `score_earned`, `score_paid_out`) VALUES
(1, 'test', '$2y$10$OHHrn69FJiyiVPL143rSSuc45RmEFSsbjroBohz4tMqn4lUwer7Jq', 'sdfsdfsdf', 'mi5drXyH9ngm4gzGkSiCuTNEEyUKqzYnTaQuD3SzLsSBS6e12b', 10, 0),
(2, 'test2', '$2y$10$EC0o5wcPw8VneWJqzZzj1Ov2GReRapQbpv63mrMSNTXGjRfb9blWC', 'WBPtrF01o4KOnvnkucKwkScRYLAl3zepCv01ijeGabLkORWsmx', 'B0mX6tWkiNGmutGiyswPPdjb9JD5SsBLQnMUoWhLn8H27q7WtL', 0, 0),
(3, 'test5', '$2y$10$6TxkrOpcmaeQxV5M3SkOb.Ckz1zT4luJ/IVs0ej2HmKaP/t0VsUJa', '3zP6yNcemHZZ52xPO1IJ9lRaafN6usS0aaWQQ7m5zwWHY53972', 'wpD6HXzvrKyW4gFDrsvjTOacghe0VlOXHYuKVClCsh0iDoxYiW', 0, 0);

CREATE TABLE `developer_game` (
  `id` int(10) NOT NULL,
  `developer_id` int(10) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `type_age_restriction_id` int(10) NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `developer_mode` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `developer_game` (`id`, `developer_id`, `name`, `type_age_restriction_id`, `available`, `developer_mode`) VALUES
(1, 1, 'test', 1, 1, 0),
(10, 1, 'test2', 3, 0, 1),
(11, 1, 'test3', 4, 0, 1);

CREATE TABLE `developer_game_game_genres` (
  `developer_game_id` int(10) NOT NULL,
  `type_game_genre_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `developer_game_game_genres` (`developer_game_id`, `type_game_genre_id`) VALUES
(1, 2),
(1, 4),
(1, 7),
(10, 7);

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

INSERT INTO `developer_game_statistics` (`developer_game_id`, `unique_hits`, `unique_views`, `unique_hears`, `total_hits`, `total_views`, `total_hears`, `total_hit_time`, `total_view_time`, `total_hear_time`, `total_score`, `total_screen_percentage`, `total_screen_position_x`, `total_screen_position_y`, `total_blocked_percentage`, `total_volume_percent`, `unique_hits_platform_windows`, `unique_hits_platform_mac`, `unique_hits_platform_linux`, `unique_hits_platform_android`, `unique_hits_platform_ios`, `unique_hits_platform_xboxone`, `unique_hits_platform_ps4`, `unique_hits_platform_web`, `unique_hits_vr`, `total_hits_platform_windows`, `total_hits_platform_mac`, `total_hits_platform_linux`, `total_hits_platform_android`, `total_hits_platform_ios`, `total_hits_platform_xboxone`, `total_hits_platform_ps4`, `total_hits_platform_web`, `total_hits_vr`) VALUES
(1, 1, 1, 1, 1, 1, 1, 3.0000360012054443, 3.0000360012054443, 3.0000360012054443, 10, 57.747459411621094, 150.140869140625, 133.37789916992188, 3.452397346496582, 202.76222229003906, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 1, 1, 1, 1, 1, 1, 3.0000360012054443, 3.0000360012054443, 3.0000360012054443, 10, 57.747459411621094, 150.140869140625, 133.37789916992188, 3.452397346496582, 202.76222229003906, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0);

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

INSERT INTO `developer_game_statistics_per_country` (`developer_game_id`, `country_code`, `unique_hits`, `total_hits`) VALUES
(1, 'NL', 1, 1);

CREATE TABLE `logged_ips` (
  `ip` varchar(100) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `type_age_restriction` (
  `id` int(10) NOT NULL,
  `minimum_age` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `type_age_restriction` (`id`, `minimum_age`) VALUES
(1, 0),
(2, 8),
(3, 12),
(4, 18),
(5, 21);

CREATE TABLE `type_game_genre` (
  `id` int(10) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `type_game_genre` (`id`, `name`) VALUES
(2, 'Action'),
(7, 'Horror'),
(4, 'Sc-Fi');

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

INSERT INTO `type_media_format` (`id`, `type_media_id`, `type_media_format_duration_id`, `aspect_ratio`) VALUES
(1, 1, NULL, 1.7778),
(2, 2, NULL, 1.5),
(3, 3, NULL, NULL);

CREATE TABLE `type_media_format_duration` (
  `id` int(10) NOT NULL,
  `duration_seconds_min` double DEFAULT NULL,
  `duration_seconds_max` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `type_media_format_duration` (`id`, `duration_seconds_min`, `duration_seconds_max`) VALUES
(1, NULL, 10),
(2, 10, 20),
(3, 20, 30),
(4, 30, NULL);


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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
ALTER TABLE `advertiser`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `advertiser_ad`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `developer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `developer_game`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
ALTER TABLE `type_age_restriction`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `type_game_genre`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
ALTER TABLE `type_media`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `type_media_format`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `type_media_format_duration`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
