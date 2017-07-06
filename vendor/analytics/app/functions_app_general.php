<?php



function getGameGenres()
{
    global $database;
    $statement = prepareStatement("
 SELECT id, name
 FROM type_game_genre
 ORDER BY name
    ");
    return getStatementResultsWithCustomKey($statement, "id");
}

function deleteGameGenre($id)
{
    global $database;
    $statement = prepareStatement("
 DELETE
 FROM type_game_genre
 WHERE (id=?)
    ");
    $statement->bind_param("i", $id);
    executeAndCloseStatement($statement);
}

function changeGameGenre($id, $name)
{
    global $database;
    $statement = prepareStatement("
 UPDATE type_game_genre
 SET name = ?
 WHERE (id=?)
    ");
    $statement->bind_param("si", $name, $id);
    executeAndCloseStatement($statement);
}

function addGameGenre($name)
{
    global $database;
    $statement = prepareStatement("
 INSERT INTO type_game_genre (name)
 VALUES (?)
    ");
    $statement->bind_param("s", $name);
    executeAndCloseStatement($statement);
}

function replaceGameGenreIds($gameGenreIds, $gameGenres)
{
    $result = array();
    foreach($gameGenreIds as $gameGenreId)
    {
        if(!isset($gameGenres[$gameGenreId]))
        {
            continue;
        }
        $gameGenre = $gameGenres[$gameGenreId];
        if(!isset($gameGenre['name']))
        {
            continue;
        }
        $result[] = $gameGenre['name'];
    }
    return array_unique($result);
}



function getAgeRestrictions()
{
    global $database;
    $statement = prepareStatement("
 SELECT id, minimum_age
 FROM type_age_restriction
 ORDER BY minimum_age
    ");
    return getStatementResultsWithCustomKey($statement, "id");
}

function deleteAgeRestriction($id)
{
    global $database;
    $statement = prepareStatement("
 DELETE
 FROM type_age_restriction
 WHERE (id=?)
    ");
    $statement->bind_param("i", $id);
    executeAndCloseStatement($statement);
}

function changeAgeRestriction($id, $minimumAge)
{
    global $database;
    $statement = prepareStatement("
 UPDATE type_age_restriction
 SET minimum_age = ?
 WHERE (id=?)
    ");
    $statement->bind_param("ii", $minimumAge, $id);
    executeAndCloseStatement($statement);
}

function addAgeRestriction($minimumAge)
{
    global $database;
    $statement = prepareStatement("
 INSERT INTO type_age_restriction (minimum_age)
 VALUES (?)
    ");
    $statement->bind_param("i", $minimumAge);
    executeAndCloseStatement($statement);
}



function mediaFormatDurationToString($mediaFormatDuration)
{
    $min = $mediaFormatDuration['duration_seconds_min'];
    $max = $mediaFormatDuration['duration_seconds_max'];
    $hasMin = !empty($min);
    $hasMax = !empty($max);
    if(!$hasMin && !$hasMax)
    {
        return "";
    }
    if(!$hasMax)
    {
        return $min."+";
    }
    else if(!$hasMin)
    {
        return "<".$max;
    }
    else
    {
        return $min." - ".$max;
    }
}

function getMediaFormatDurations()
{
    global $database;
    $statement = prepareStatement("
 SELECT id, duration_seconds_min, duration_seconds_max
 FROM type_media_format_duration
 ORDER BY duration_seconds_min, duration_seconds_max DESC
    ");
    return getStatementResultsWithCustomKey($statement, "id");
}

function deleteMediaFormatDuration($id)
{
    global $database;
    $statement = prepareStatement("
 DELETE
 FROM type_media_format_duration
 WHERE (id=?)
    ");
    $statement->bind_param("i", $id);
    executeAndCloseStatement($statement);
}

function changeMediaFormatDuration($id, $durationSecondsMin, $durationSecondsMax)
{
    global $database;
    $statement = prepareStatement("
 UPDATE type_media_format_duration
 SET duration_seconds_min = ?, duration_seconds_max = ?
 WHERE (id=?)
    ");
    if(empty($durationSecondsMin))
    {
        $durationSecondsMin = null;
    }
    if(empty($durationSecondsMax))
    {
        $durationSecondsMax = null;
    }
    $statement->bind_param("ddi", $durationSecondsMin, $durationSecondsMax, $id);
    executeAndCloseStatement($statement);
}

function addMediaFormatDuration($durationSecondsMin, $durationSecondsMax)
{
    global $database;
    $statement = prepareStatement("
 INSERT INTO type_media_format_duration (duration_seconds_min, duration_seconds_max)
 VALUES (?, ?)
    ");
    if(empty($durationSecondsMin))
    {
        $durationSecondsMin = null;
    }
    if(empty($durationSecondsMax))
    {
        $durationSecondsMax = null;
    }
    $statement->bind_param("dd", $durationSecondsMin, $durationSecondsMax);
    executeAndCloseStatement($statement);
}



function getMediaTypes()
{
    global $database;
    $statement = prepareStatement("
 SELECT id, name
 FROM type_media
 ORDER BY id
    ");
    return getStatementResultsWithCustomKey($statement, "id");
}



function mediaFormatToString($mediaFormat, $requirement_mediaTypes, $requirement_mediaFormatDurations)
{
    $mediaTypeId = $mediaFormat['type_media_id'];
    if($mediaTypeId == 1) // image
    {
        return "Image (aspect ratio: ".$mediaFormat['aspect_ratio'].")";
    }
    else if($mediaTypeId == 2) // video
    {
        $duration = $mediaFormat['type_media_format_duration_id'];
        if(isset($duration))
        {
            $duration = $requirement_mediaFormatDurations[$duration];
        }
        if(isset($duration))
        {
            $duration = mediaFormatDurationToString($duration);
        }
        if(!empty($duration))
        {
            return "Video (aspect ratio: ".$mediaFormat['aspect_ratio'].") (".$duration." seconds)";
        }
        else
        {
            return "Video (aspect ratio: ".$mediaFormat['aspect_ratio'].")";
        }
    }
    else if($mediaTypeId == 3) // sounds
    {
        $duration = $mediaFormat['type_media_format_duration_id'];
        if(isset($duration))
        {
            $duration = $requirement_mediaFormatDurations[$duration];
        }
        if(isset($duration))
        {
            $duration = mediaFormatDurationToString($duration);
        }
        if(!empty($duration))
        {
            return "Sound (".$duration." seconds)";
        }
        else
        {
            return "Sound";
        }
    }
    else // other
    {
        return $requirement_mediaTypes[$mediaTypeId]['name'];
    }
}

function getMediaFormats()
{
    global $database;
    $statement = prepareStatement("
 SELECT id, type_media_id, type_media_format_duration_id, aspect_ratio
 FROM type_media_format
 ORDER BY type_media_id, aspect_ratio, type_media_format_duration_id
    ");
    return getStatementResultsWithCustomKey($statement, "id");
}

function deleteMediaFormat($id)
{
    global $database;
    $statement = prepareStatement("
 DELETE
 FROM type_media_format
 WHERE (id=?)
    ");
    $statement->bind_param("i", $id);
    executeAndCloseStatement($statement);
}

function changeMediaFormat($id, $typeMediaId, $typeMediaFormatDurationId, $aspectRatio)
{
    global $database;
    $statement = prepareStatement("
 UPDATE type_media_format
 SET type_media_id = ?, type_media_format_duration_id = ?, aspect_ratio = ?
 WHERE (id=?)
    ");
    if(empty($typeMediaFormatDurationId) || ($typeMediaId == 1)) // image
    {
        $typeMediaFormatDurationId = null;
    }
    if(empty($aspectRatio) || ($typeMediaId == 3)) // sound
    {
        $aspectRatio = null;
    }
    $statement->bind_param("iidi", $typeMediaId, $typeMediaFormatDurationId, $aspectRatio, $id);
    executeAndCloseStatement($statement);
}

function addMediaFormat($typeMediaId, $typeMediaFormatDurationId, $aspectRatio)
{
    global $database;
    $statement = prepareStatement("
 INSERT INTO type_media_format (type_media_id, type_media_format_duration_id, aspect_ratio)
 VALUES (?, ?, ?)
    ");
    if(empty($typeMediaFormatDurationId) || ($typeMediaId == 1)) // image
    {
        $typeMediaFormatDurationId = null;
    }
    if(empty($aspectRatio) || ($typeMediaId == 3)) // sound
    {
        $aspectRatio = null;
    }
    $statement->bind_param("iid", $typeMediaId, $typeMediaFormatDurationId, $aspectRatio);
    executeAndCloseStatement($statement);
}



function isDeveloperGameFromDeveloper($developerGameId, $developerId)
{
    global $database;
    $statement = prepareStatement("
 SELECT COUNT(*)
 FROM developer_game
 WHERE (id=?) AND (developer_id=?)
    ");
    $statement->bind_param("ii", $developerGameId, $developerId);
    return getCountAboveZeroStatementResult($statement);
}

function getDeveloperGamesFromDeveloper($developerId)
{
    global $database;
    $games = array();
    
    {// get game >>
        $statement = prepareStatement("
 SELECT id, name, type_age_restriction_id, available, developer_mode
 FROM developer_game
 WHERE (developer_id=?)
 ORDER BY id
        ");
        $statement->bind_param("i", $developerId);
        $games = getStatementResultsWithCustomKey($statement, "id");
    }// get game <<
    
    {// get genres >>
        foreach($games as $gameId => $game)
        {
            $statement = prepareStatement("
 SELECT type_game_genre_id
 FROM developer_game_game_genres
 WHERE (developer_game_id=?)
 ORDER BY type_game_genre_id
            ");
            $statement->bind_param("i", $gameId);
            $genreIds = array();
            foreach(getStatementResults($statement) as $genreIdRow)
            {
                $genreIds[] = $genreIdRow['type_game_genre_id'];
            }
            $games[$gameId]['genre_ids'] = $genreIds;
        }
    }// get genres <<
    
    return $games;
}

function deleteDeveloperGame($id)
{
    global $database;
    $statement = prepareStatement("
 DELETE
 FROM developer_game
 WHERE (id=?)
    ");
    $statement->bind_param("i", $id);
    executeAndCloseStatement($statement);
}

function changeDeveloperGame($id, $name, $typeAgeRestrictionId, $available, $developerMode, $genreIds)
{
    // a transaction, because if updating the game genres failed, we want the update of the game and the deletion of the old game genres to fail too
    global $database;
    startTransaction();
    {
        {// delete old game genres >>
            $statement = prepareStatement("
 DELETE
 FROM developer_game_game_genres
 WHERE (developer_game_id=?)
            ");
            $statement->bind_param("i", $id);
            executeAndCloseStatement($statement);
        }// delete old game genres <<
        
        {// update game >>
            $statement = prepareStatement("
 UPDATE developer_game
 SET name = ?, type_age_restriction_id = ?, available = ?, developer_mode = ?
 WHERE (id=?)
            ");
            $statement->bind_param("siiii", $name, $typeAgeRestrictionId, $available, $developerMode, $id);
            executeAndCloseStatement($statement);
        }// update game <<
        
        {// insert new game genres >>
            if(isset($genreIds))
            {
                foreach($genreIds as $genreId)
                {
                    $statement = prepareStatement("
 INSERT INTO developer_game_game_genres (developer_game_id, type_game_genre_id)
 VALUES (?, ?)
                    ");
                    $statement->bind_param("ii", $id, $genreId);
                    executeAndCloseStatement($statement);
                }
            }
        }// insert new game genres <<
    }
    endTransaction(true);
}

function addDeveloperGame($developerId, $name, $typeAgeRestrictionId, $available, $developerMode, $genreIds)
{
    // a transaction, because if inserting the game genres failed, we want the insert of the game to fail too
    global $database;
    startTransaction();
    {
        {// insert new game >>
            $statement = prepareStatement("
 INSERT INTO developer_game (developer_id, name, type_age_restriction_id, available, developer_mode)
 VALUES (?, ?, ?, ?, ?)
            ");
            $statement->bind_param("isiii", $developerId, $name, $typeAgeRestrictionId, $available, $developerMode);
            executeAndCloseStatement($statement);
        }// insert new game <<
        
        $developerGameId = getLastInsertedId();
        
        {// insert game genres >>
            if(isset($genreIds))
            {
                foreach($genreIds as $genreId)
                {
                    $statement = prepareStatement("
 INSERT INTO developer_game_game_genres (developer_game_id, type_game_genre_id)
 VALUES (?, ?)
                    ");
                    $statement->bind_param("ii", $developerGameId, $genreId);
                    executeAndCloseStatement($statement);
                }
            }
        }// insert game genres <<
    }
    endTransaction(true);
}



function isAdvertiserAdFromAdvertiser($advertiserAdId, $advertiserId)
{
    global $database;
    $statement = prepareStatement("
 SELECT COUNT(*)
 FROM advertiser_ad
 WHERE (id=?) AND (advertiser_id=?)
    ");
    $statement->bind_param("ii", $advertiserAdId, $advertiserId);
    return getCountAboveZeroStatementResult($statement);
}

function getAdvertiserAdsFromAdvertiser($advertiserId)
{
    global $database;
    $ads = array();
    
    {// get ads >>
        $statement = prepareStatement("
 SELECT id, type_media_format_id, country_filter_excludes, media_url
 FROM advertiser_ad
 WHERE (advertiser_id=?)
 ORDER BY id
        ");
        $statement->bind_param("i", $advertiserId);
        $ads = getStatementResultsWithCustomKey($statement, "id");
    }// get ads <<
    
    {// get country filter list >>
        foreach($ads as $adId => $ad)
        {
            $statement = prepareStatement("
 SELECT country_code
 FROM advertiser_ad_country_filter_list
 WHERE (advertiser_ad_id=?)
 ORDER BY country_code
            ");
            $statement->bind_param("i", $adId);
            $countryFilterList = array();
            foreach(getStatementResults($statement) as $countryFilterListRow)
            {
                $countryFilterList[] = $countryFilterListRow['country_code'];
            }
            $ads[$adId]['country_filter_list'] = $countryFilterList;
        }
    }// get country filter list <<
    
    return $ads;
}

function deleteAdvertiserAd($id)
{
    global $database;
    $statement = prepareStatement("
 DELETE
 FROM advertiser_ad
 WHERE (id=?)
    ");
    $statement->bind_param("i", $id);
    executeAndCloseStatement($statement);
}

function changeAdvertiserAd($id, $typeMediaFormatId, $countryFilterExcludes, $mediaUrl, $countryFilterList)
{
    // a transaction, because if updating the country filter list failed, we want the update of the ad and the deletion of the old country filter list to fail too
    global $database;
    startTransaction();
    {
        {// delete country filter list >>
            $statement = prepareStatement("
 DELETE
 FROM advertiser_ad_country_filter_list
 WHERE (advertiser_ad_id=?)
            ");
            $statement->bind_param("i", $id);
            executeAndCloseStatement($statement);
        }// delete country filter list <<
        
        {// update ad >>
            $statement = prepareStatement("
 UPDATE advertiser_ad
 SET type_media_format_id = ?, country_filter_excludes = ?, media_url = ?
 WHERE (id=?)
            ");
            $statement->bind_param("iisi", $typeMediaFormatId, $countryFilterExcludes, $mediaUrl, $id);
            executeAndCloseStatement($statement);
        }// update ad <<
        
        {// insert new country filter list >>
            if(isset($countryFilterList))
            {
                foreach($countryFilterList as $country)
                {
                    $statement = prepareStatement("
 INSERT INTO advertiser_ad_country_filter_list (advertiser_ad_id, country_code)
 VALUES (?, ?)
                    ");
                    $statement->bind_param("is", $id, $country);
                    executeAndCloseStatement($statement);
                }
            }
        }// insert new country filter list <<
    }
    endTransaction(true);
}

function addAdvertiserAd($advertiserId, $typeMediaFormatId, $countryFilterExcludes, $mediaUrl, $countryFilterList)
{
    // a transaction, because if inserting the country filter list failed, we want the insert of the ad to fail too
    global $database;
    startTransaction();
    {
        {// insert new ad >>
            $statement = prepareStatement("
 INSERT INTO advertiser_ad (advertiser_id, type_media_format_id, country_filter_excludes, media_url)
 VALUES (?, ?, ?, ?)
            ");
            $statement->bind_param("iiis", $advertiserId, $typeMediaFormatId, $countryFilterExcludes, $mediaUrl);
            executeAndCloseStatement($statement);
        }// insert new ad <<
        
        $advertiserAdId = getLastInsertedId();
        
        {// insert ad country filter list >>
            if(isset($countryFilterList))
            {
                foreach($countryFilterList as $country)
                {
                    $statement = prepareStatement("
 INSERT INTO advertiser_ad_country_filter_list (advertiser_ad_id, country_code)
 VALUES (?, ?)
                    ");
                    $statement->bind_param("is", $advertiserAdId, $country);
                    executeAndCloseStatement($statement);
                }
            }
        }// insert ad country filter list <<
    }
    endTransaction(true);
}



function getAdvertisersStatistics()
{
    global $database;
    $advertiserStatisticsArray = array();
    {
        $statement = prepareStatement("
 SELECT advertiser_id, unique_hits, unique_views, unique_hears, total_hits, total_views, total_hears, total_hit_time, total_view_time, total_hear_time, total_score, total_screen_percentage, total_screen_position_x, total_screen_position_y, total_blocked_percentage, total_volume_percent, unique_hits_platform_windows, unique_hits_platform_mac, unique_hits_platform_linux, unique_hits_platform_android, unique_hits_platform_ios, unique_hits_platform_xboxone, unique_hits_platform_ps4, unique_hits_platform_web, unique_hits_vr, total_hits_platform_windows, total_hits_platform_mac, total_hits_platform_linux, total_hits_platform_android, total_hits_platform_ios, total_hits_platform_xboxone, total_hits_platform_ps4, total_hits_platform_web, total_hits_vr
 FROM advertiser_statistics
 ORDER BY advertiser_id
        ");
        $advertiserStatisticsArray = getStatementResultsWithCustomKey($statement, "advertiser_id");
    }
    foreach($advertiserStatisticsArray as $advertiserId => $statistics)
    {
        $statement = prepareStatement("
 SELECT country_code, unique_hits, total_hits
 FROM advertiser_statistics_per_country
 WHERE (advertiser_id=?)
 ORDER BY country_code
        ");
        $statement->bind_param("i", $advertiserId);
        $perCountry = getStatementResultsWithCustomKey($statement, "country_code");
        $advertiserStatisticsArray[$advertiserId]['per_country'] = $perCountry;
    }
    return $advertiserStatisticsArray;
}

function getAdvertisersStatisticsOfAdvertiser($advertiserId)
{
    global $database;
    $advertiserStatisticsArray = array();
    {
        $statement = prepareStatement("
 SELECT advertiser_id, unique_hits, unique_views, unique_hears, total_hits, total_views, total_hears, total_hit_time, total_view_time, total_hear_time, total_score, total_screen_percentage, total_screen_position_x, total_screen_position_y, total_blocked_percentage, total_volume_percent, unique_hits_platform_windows, unique_hits_platform_mac, unique_hits_platform_linux, unique_hits_platform_android, unique_hits_platform_ios, unique_hits_platform_xboxone, unique_hits_platform_ps4, unique_hits_platform_web, unique_hits_vr, total_hits_platform_windows, total_hits_platform_mac, total_hits_platform_linux, total_hits_platform_android, total_hits_platform_ios, total_hits_platform_xboxone, total_hits_platform_ps4, total_hits_platform_web, total_hits_vr
 FROM advertiser_statistics
 WHERE (advertiser_id=?)
 ORDER BY advertiser_id
        ");
        $statement->bind_param("i", $advertiserId);
        $advertiserStatisticsArray = getStatementResultsWithCustomKey($statement, "advertiser_id");
    }
    foreach($advertiserStatisticsArray as $advertiserId => $statistics)
    {
        $statement = prepareStatement("
 SELECT country_code, unique_hits, total_hits
 FROM advertiser_statistics_per_country
 WHERE (advertiser_id=?)
 ORDER BY country_code
        ");
        $statement->bind_param("i", $advertiserId);
        $perCountry = getStatementResultsWithCustomKey($statement, "country_code");
        $advertiserStatisticsArray[$advertiserId]['per_country'] = $perCountry;
    }
    return $advertiserStatisticsArray;
}

function getAdvertisersStatisticsForAdmins()
{
    global $database;
    $advertiserStatisticsArray = array();
    {
        $statement = prepareStatement("
 SELECT advertiser_id, unique_hits, unique_views, unique_hears, total_hits, total_views, total_hears, total_hit_time, total_view_time, total_hear_time, total_score, total_screen_percentage, total_screen_position_x, total_screen_position_y, total_blocked_percentage, total_volume_percent, unique_hits_platform_windows, unique_hits_platform_mac, unique_hits_platform_linux, unique_hits_platform_android, unique_hits_platform_ios, unique_hits_platform_xboxone, unique_hits_platform_ps4, unique_hits_platform_web, unique_hits_vr, total_hits_platform_windows, total_hits_platform_mac, total_hits_platform_linux, total_hits_platform_android, total_hits_platform_ios, total_hits_platform_xboxone, total_hits_platform_ps4, total_hits_platform_web, total_hits_vr
 FROM advertiser_statistics
 ORDER BY advertiser_id
        ");
        $advertiserStatisticsArray = getStatementResultsWithCustomKey($statement, "advertiser_id");
    }
    foreach($advertiserStatisticsArray as $advertiserId => $statistics)
    {
        $statement = prepareStatement("
 SELECT country_code, unique_hits, total_hits
 FROM advertiser_statistics_per_country
 WHERE (advertiser_id=?)
 ORDER BY country_code
        ");
        $statement->bind_param("i", $advertiserId);
        $perCountry = getStatementResultsWithCustomKey($statement, "country_code");
        $advertiserStatisticsArray[$advertiserId]['per_country'] = $perCountry;
    }
    foreach($advertiserStatisticsArray as $advertiserId => $statistics)
    {
        $ads = array();
        $statement = prepareStatement("
 SELECT id, type_media_format_id, country_filter_excludes, media_url
 FROM advertiser_ad
 WHERE (advertiser_id=?)
 ORDER BY id
        ");
        $statement->bind_param("i", $advertiserId);
        $ads = getStatementResultsWithCustomKey($statement, "id");
        foreach($ads as $adId => $ad)
        {
            $statement = prepareStatement("
 SELECT country_code
 FROM advertiser_ad_country_filter_list
 WHERE (advertiser_ad_id=?)
 ORDER BY country_code
            ");
            $statement->bind_param("i", $adId);
            $countryFilterList = array();
            foreach(getStatementResults($statement) as $countryFilterListRow)
            {
                $countryFilterList[] = $countryFilterListRow['country_code'];
            }
            $ads[$adId]['country_filter_list'] = $countryFilterList;
        }
        $advertiserStatisticsArray[$advertiserId]['ads'] = $ads;
    }
    return $advertiserStatisticsArray;
}



function getDeveloperGamesStatistics()
{
    global $database;
    $developerGameStatisticsArray = array();
    {
        $statement = prepareStatement("
 SELECT developer_game_id, unique_hits, unique_views, unique_hears, total_hits, total_views, total_hears, total_hit_time, total_view_time, total_hear_time, total_score, total_screen_percentage, total_screen_position_x, total_screen_position_y, total_blocked_percentage, total_volume_percent, unique_hits_platform_windows, unique_hits_platform_mac, unique_hits_platform_linux, unique_hits_platform_android, unique_hits_platform_ios, unique_hits_platform_xboxone, unique_hits_platform_ps4, unique_hits_platform_web, unique_hits_vr, total_hits_platform_windows, total_hits_platform_mac, total_hits_platform_linux, total_hits_platform_android, total_hits_platform_ios, total_hits_platform_xboxone, total_hits_platform_ps4, total_hits_platform_web, total_hits_vr
 FROM developer_game_statistics
 ORDER BY developer_game_id
        ");
        $developerGameStatisticsArray = getStatementResultsWithCustomKey($statement, "developer_game_id");
    }
    foreach($developerGameStatisticsArray as $developerGameId => $statistics)
    {
        $statement = prepareStatement("
 SELECT country_code, unique_hits, total_hits
 FROM developer_game_statistics_per_country
 WHERE (developer_game_id=?)
 ORDER BY country_code
        ");
        $statement->bind_param("i", $developerGameId);
        $perCountry = getStatementResultsWithCustomKey($statement, "country_code");
        $developerGameStatisticsArray[$developerGameId]['per_country'] = $perCountry;
    }
    return $developerGameStatisticsArray;
}

function getDeveloperGamesStatisticsOfDeveloper($developerId)
{
    global $database;
    $developerGameStatisticsArray = array();
    {
        $statement = prepareStatement("
 SELECT stat.developer_game_id, stat.unique_hits, stat.unique_views, stat.unique_hears, stat.total_hits, stat.total_views, stat.total_hears, stat.total_hit_time, stat.total_view_time, stat.total_hear_time, stat.total_score, stat.total_screen_percentage, stat.total_screen_position_x, stat.total_screen_position_y, stat.total_blocked_percentage, stat.total_volume_percent, stat.unique_hits_platform_windows, stat.unique_hits_platform_mac, stat.unique_hits_platform_linux, stat.unique_hits_platform_android, stat.unique_hits_platform_ios, stat.unique_hits_platform_xboxone, stat.unique_hits_platform_ps4, stat.unique_hits_platform_web, stat.unique_hits_vr, stat.total_hits_platform_windows, stat.total_hits_platform_mac, stat.total_hits_platform_linux, stat.total_hits_platform_android, stat.total_hits_platform_ios, stat.total_hits_platform_xboxone, stat.total_hits_platform_ps4, stat.total_hits_platform_web, stat.total_hits_vr
 FROM developer_game_statistics stat
 INNER JOIN developer_game game ON (game.id=stat.developer_game_id) AND (game.developer_id=?)
 ORDER BY stat.developer_game_id
        ");
        $statement->bind_param("i", $developerId);
        $developerGameStatisticsArray = getStatementResultsWithCustomKey($statement, "developer_game_id");
    }
    foreach($developerGameStatisticsArray as $developerGameId => $statistics)
    {
        $statement = prepareStatement("
 SELECT country_code, unique_hits, total_hits
 FROM developer_game_statistics_per_country
 WHERE (developer_game_id=?)
 ORDER BY country_code
        ");
        $statement->bind_param("i", $developerGameId);
        $perCountry = getStatementResultsWithCustomKey($statement, "country_code");
        $developerGameStatisticsArray[$developerGameId]['per_country'] = $perCountry;
    }
    return $developerGameStatisticsArray;
}

function getDeveloperGamesStatisticsForAdmins()
{
    global $database;
    $developerGameStatisticsArray = array();
    {
        $statement = prepareStatement("
 SELECT game.developer_id, game.name, game.type_age_restriction_id, game.available, game.developer_mode, game.id AS `developer_game_id`, stat.unique_hits, stat.unique_views, stat.unique_hears, stat.total_hits, stat.total_views, stat.total_hears, stat.total_hit_time, stat.total_view_time, stat.total_hear_time, stat.total_score, stat.total_screen_percentage, stat.total_screen_position_x, stat.total_screen_position_y, stat.total_blocked_percentage, stat.total_volume_percent, stat.unique_hits_platform_windows, stat.unique_hits_platform_mac, stat.unique_hits_platform_linux, stat.unique_hits_platform_android, stat.unique_hits_platform_ios, stat.unique_hits_platform_xboxone, stat.unique_hits_platform_ps4, stat.unique_hits_platform_web, stat.unique_hits_vr, stat.total_hits_platform_windows, stat.total_hits_platform_mac, stat.total_hits_platform_linux, stat.total_hits_platform_android, stat.total_hits_platform_ios, stat.total_hits_platform_xboxone, stat.total_hits_platform_ps4, stat.total_hits_platform_web, stat.total_hits_vr
 FROM developer_game game
 LEFT JOIN developer_game_statistics stat ON (stat.developer_game_id=game.id)
 ORDER BY game.developer_id, game.id
        ");
        $developerGameStatisticsArray = getStatementResultsWithCustomKey($statement, "developer_game_id");
    }
    foreach($developerGameStatisticsArray as $developerGameId => $statistics)
    {
        $statement = prepareStatement("
 SELECT country_code, unique_hits, total_hits
 FROM developer_game_statistics_per_country
 WHERE (developer_game_id=?)
 ORDER BY country_code
        ");
        $statement->bind_param("i", $developerGameId);
        $perCountry = getStatementResultsWithCustomKey($statement, "country_code");
        $developerGameStatisticsArray[$developerGameId]['per_country'] = $perCountry;
    }
    foreach($developerGameStatisticsArray as $developerGameId => $statistics)
    {
        $statement = prepareStatement("
 SELECT type_game_genre_id
 FROM developer_game_game_genres
 WHERE (developer_game_id=?)
 ORDER BY type_game_genre_id
        ");
        $statement->bind_param("i", $developerGameId);
        $genreIds = array();
        foreach(getStatementResults($statement) as $genreIdRow)
        {
            $genreIds[] = $genreIdRow['type_game_genre_id'];
        }
        $developerGameStatisticsArray[$developerGameId]['genre_ids'] = $genreIds;
    }
    return $developerGameStatisticsArray;
}

function getDeveloperGamesStatisticsForAdvertisers()
{
    global $database;
    $developerGameStatisticsArray = array();
    {
        $statement = prepareStatement("
 SELECT game.developer_id, game.name, game.type_age_restriction_id, game.available, game.developer_mode, game.id AS `developer_game_id`, stat.unique_hits, stat.unique_views, stat.unique_hears, stat.total_hits, stat.total_views, stat.total_hears, stat.total_hit_time, stat.total_view_time, stat.total_hear_time, stat.total_score, stat.total_screen_percentage, stat.total_screen_position_x, stat.total_screen_position_y, stat.total_blocked_percentage, stat.total_volume_percent, stat.unique_hits_platform_windows, stat.unique_hits_platform_mac, stat.unique_hits_platform_linux, stat.unique_hits_platform_android, stat.unique_hits_platform_ios, stat.unique_hits_platform_xboxone, stat.unique_hits_platform_ps4, stat.unique_hits_platform_web, stat.unique_hits_vr, stat.total_hits_platform_windows, stat.total_hits_platform_mac, stat.total_hits_platform_linux, stat.total_hits_platform_android, stat.total_hits_platform_ios, stat.total_hits_platform_xboxone, stat.total_hits_platform_ps4, stat.total_hits_platform_web, stat.total_hits_vr
 FROM developer_game game
 LEFT JOIN developer_game_statistics stat ON (stat.developer_game_id=game.id)
 WHERE available=1
 ORDER BY game.developer_id, game.id
        ");
        $developerGameStatisticsArray = getStatementResultsWithCustomKey($statement, "developer_game_id");
    }
    foreach($developerGameStatisticsArray as $developerGameId => $statistics)
    {
        $statement = prepareStatement("
 SELECT country_code, unique_hits, total_hits
 FROM developer_game_statistics_per_country
 WHERE (developer_game_id=?)
 ORDER BY country_code
        ");
        $statement->bind_param("i", $developerGameId);
        $perCountry = getStatementResultsWithCustomKey($statement, "country_code");
        $developerGameStatisticsArray[$developerGameId]['per_country'] = $perCountry;
    }
    foreach($developerGameStatisticsArray as $developerGameId => $statistics)
    {
        $statement = prepareStatement("
 SELECT type_game_genre_id
 FROM developer_game_game_genres
 WHERE (developer_game_id=?)
 ORDER BY type_game_genre_id
        ");
        $statement->bind_param("i", $developerGameId);
        $genreIds = array();
        foreach(getStatementResults($statement) as $genreIdRow)
        {
            $genreIds[] = $genreIdRow['type_game_genre_id'];
        }
        $developerGameStatisticsArray[$developerGameId]['genre_ids'] = $genreIds;
    }
    foreach($developerGameStatisticsArray as $developerGameId => $statistics)
    {
        $statement = prepareStatement("
 SELECT advertiser_ad_id
 FROM advertiser_ad_developer_games
 WHERE (developer_game_id=?)
 ORDER BY advertiser_ad_id
        ");
        $statement->bind_param("i", $developerGameId);
        $adIds = array();
        foreach(getStatementResults($statement) as $adRow)
        {
            $adIds[] = $adRow['advertiser_ad_id'];
        }
        $developerGameStatisticsArray[$developerGameId]['ad_ids'] = $adIds;
    }
    return $developerGameStatisticsArray;
}



function changeAdvertiserAdDeveloperGames($advertiserId, $developerGameId, $advertiserAdIds)
{
    // a transaction, because if anything failed, we want it all to fail
    global $database;
    startTransaction();
    {
        {// unbind all ads >>
            $statement = prepareStatement("
 DELETE bind
 FROM advertiser_ad_developer_games bind
 INNER JOIN advertiser_ad ad ON (ad.id=bind.advertiser_ad_id) AND (ad.advertiser_id=?)
 WHERE (bind.developer_game_id=?)
            ");
            $statement->bind_param("ii", $advertiserId, $developerGameId);
            executeAndCloseStatement($statement);
        }// unbind all ads <<
        
        {// bind given ads >>
            if(isset($advertiserAdIds))
            {
                foreach($advertiserAdIds as $advertiserAdId)
                {
                    $statement = prepareStatement("
 INSERT INTO advertiser_ad_developer_games (developer_game_id, advertiser_ad_id)
 VALUES (?, ?)
                    ");
                    $statement->bind_param("ii", $developerGameId, $advertiserAdId);
                    executeAndCloseStatement($statement);
                }
            }
        }// bind given ads <<
    }
    endTransaction(true);
}












