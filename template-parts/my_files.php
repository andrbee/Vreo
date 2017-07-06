<?php

// Include the AWS SDK using the Composer autoloader.
//
//$timezone = timezone_name_from_abbr("", intval($_COOKIE['timezone'])*60, 0);
//$date=new DateTime("",new DateTimeZone($timezone));
//$date=$date->format('Y-m-d H:i:s');
//echo $date;


if (in_array('developer', $user_info->roles)) {
    $rolePath = 'Developers';
} elseif (in_array('brand', $user_info->roles)) {
    $rolePath = 'Brands';
} else {
    $rolePath = 'Guests';
}
$rolePath .= "/";
$Path = $rolePath . $user_info->nickname . "/";
use Aws\S3\S3Client;


// Instantiate the client.
$s3 = S3Client::factory([
    'key' => $config['s3']['key'],
    'secret' => $config['s3']['secret'],
    'region' => 'eu-central-1'
]);


$objects = $s3->getIterator('ListObjects', array(
    'Bucket' => $config['s3']['bucket'],
    'Prefix' => $rolePath . $user_info->nickname
));
foreach ($objects as $object) {
    $size += $object['Size'];
}
$userSizeSpace = 0 . ' mb';
if ($size > 0) {
    $discSpace;
    if ($size < 1024) {
        $discSpace = $size . " b"; // Выводим байты
        $userSizeSpace = $discSpace;
    } elseif ($size < (1024 * 1024)) {
        $discSpace = round(($size / 1024), 1) . " kb"; // Выводим килобайты
        $userSizeSpace = $discSpace;
    } else {
        $discSpace = round((($size / 1024) / 1024), 1) . " mb"; // Выводим мегабайты
        $userSizeSpace = $discSpace;
    }
//    echo "<h3>You are using $discSpace of 500 mb disk space</h3>";
}
////Put object.
//$params = [
//    'Bucket' => $config['s3']['bucket'],
//    'Key' => $Path . $user_info->nickname . '.txt',
//    'Body' => $user_info->nickname,
//    'ACL' => 'public-read'
//];
//
//$result = $s3->putObject($params);
//print_r($result);

// Get an object.
$iterator = $s3->getIterator('ListObjects', array(
    'Bucket' => $config['s3']['bucket'],
    'Prefix' => $Path

));

?>
<h3>You have used <?php echo $userSizeSpace; ?> of 500 mb available storage space</h3>
<div class="table-scrollable">

    <table class="table table-striped table-bordered table-advance table-hover">
        <thead>
        <tr>
            <th class="text-center">
                <span data-sort="file" class="sortFiles">Thumbnails</span>
            </th>
            <th>
                <span data-sort="date" class="sortFiles">Date added</span>
            </th>
            <th class="text-center">
                <span data-sort="type" class="sortFiles">Type</span>
            </th>
            <th class="text-center">
                <span data-sort="size" class="sortFiles">Size</span>
            </th>
            <th class="text-center">
                <span></span>
            </th>
        </tr>
        </thead>

        <tbody class="sortable">


        <?
        foreach ($iterator as $object) {
            //    print_r($object);
            $url = $config['s3']['cdnPath'] . "/" . $object['Key'];
            $size = $object['Size'];
            $nameFile = esc_html(basename(urldecode($url)));

//            var_dump($object['LastModified']);
            $timezone = timezone_name_from_abbr("", intval($_COOKIE['timezone']) * 60, 0);
            $date=new DateTime($object['LastModified']);
            $date->setTimezone(new DateTimeZone($timezone))->format(DATE_ATOM);
            $dateObject = $date;

            $info = new SplFileInfo($url);
            $extFile = strtolower($info->getExtension());
            if ($extFile == 'jpeg' || $extFile == 'jpg' || $extFile == 'png' || $extFile == 'gif' || $extFile == 'tif') {
                $extFile = 'image';
            } elseif ($extFile == 'mp4' || $extFile == 'x-m4v' || $extFile == 'mpeg' || $extFile == 'avi' || $extFile == 'asf' || $extFile == 'flv' || $extFile == '3gp') {
                $extFile = 'video';
            } else {
                $extFile;
            }

            ?>

            <tr>

                <td class="text-center" data-sort="file" data-value="<?= $extFile ?>">
                    <? if ($extFile == 'image') {
                        echo "<a href=\"$url\"><img title='$nameFile' src='{$url}' width='50'></a>";
                    } elseif ($extFile == 'video') {
                        echo "<a href=\"$url\"><img title='$nameFile' src='" . get_template_directory_uri() . "/assets/img/my_files_icons/youtube.png' width='50'></a>";
                    } elseif ($extFile == 'pdf') {
                        echo "<a href=\"$url\"><img title='$nameFile' src='" . get_template_directory_uri() . "/assets/img/my_files_icons/pdf.png' width='50'></a>";
                    } elseif ($extFile == 'doc' || $extFile == 'docx' || $extFile == 'docm' || $extFile == 'dotx' || $extFile == 'dotm') {
                        echo "<a href=\"$url\"><img title='$nameFile' src='" . get_template_directory_uri() . "/assets/img/my_files_icons/word.png' width='50'></a>";
                    } elseif ($extFile == 'rar' || $extFile == 'zip' || $extFile == 'tar' || $extFile == 'arj' || $extFile == 'gz' || $extFile == 'lha' || $extFile == 'tgz' || $extFile == 'ace') {
                        echo "<a href=\"$url\"><img title='$nameFile' src='" . get_template_directory_uri() . "/assets/img/my_files_icons/archive.jpg' width='50'></a>";
                    } else {
                        echo "<a href=\"$url\"><img title='$nameFile' src='" . get_template_directory_uri() . "/assets/img/my_files_icons/file.png' width='50'></a>";
                    }
                    ?>
                </td>
                <td data-sort="date" data-value="<?= $dateObject->format("YmdHis") ?>">
                    <?
                    echo $dateObject->format("Y-m-d H:i:s");
                    ?>
                </td>
                <td class="text-center" data-sort="type" data-value="<?= $extFile ?>">
                    <?= $extFile ?>
                </td>
                <td class="text-center" data-sort="size" data-value="<?= $size ?>">
                    <? if ($size < 1024) {
                        echo $size;
                    } elseif ($size < (1024 * 1024)) {
                        echo round(($size / 1024), 1) . " kb";
                    } else {
                        echo round((($size / 1024) / 1024), 1) . " mb";
                    } ?>
                </td>
                <td class="text-center">
                    <a href="javascript:;" onclick="deleteFile(this,'<?= $object['Key'] ?>')"
                       class="btn btn-xs red-haze">
                        <i class="fa fa-times"></i> Delete </a>
                </td>
            </tr>


            <?
        }
        ?>

        </tbody>
    </table>
</div>
<script>
    $(document).ready()
    {
        $('.sortFiles').on('click', function () {
            var sorttType = $(this).data('sort');
            var butSort = $(this);
            if (sorttType === "size" || sorttType === "date") {
                if (butSort.hasClass('usort')) {
                    $(".sortable tr").sort(function (a, b) { // сортируем
                            return +$(b).find('[data-sort=' + sorttType + ']').attr('data-value') - +$(a).find('[data-sort=' + sorttType + ']').attr('data-value');
                        })
                        .appendTo(".sortable");// возвращаем в контейнер
                    $('.sortFiles').removeClass('usort');
                } else {
                    $(".sortable tr").sort(function (a, b) { // сортируем
                            return +$(a).find('[data-sort=' + sorttType + ']').attr('data-value') - +$(b).find('[data-sort=' + sorttType + ']').attr('data-value');
                        })
                        .appendTo(".sortable");// возвращаем в контейнер
                    butSort.addClass('usort');
                }
            }
            else {
                if (butSort.hasClass('usort')) {
                    $(".sortable tr").sort(function (a, b) {
                        return $(b).find('[data-sort=' + sorttType + ']').attr('data-value').toLowerCase().localeCompare($(a).find('[data-sort=' + sorttType + ']').attr('data-value'));

                    }).appendTo(".sortable");// возвращаем в контейнер
                    $('.sortFiles').removeClass('usort');
                } else {
                    $(".sortable tr").sort(function (a, b) {
                        return $(a).find('[data-sort=' + sorttType + ']').attr('data-value').toLowerCase().localeCompare($(b).find('[data-sort=' + sorttType + ']').attr('data-value'));

                    }).appendTo(".sortable");// возвращаем в контейнер
                    butSort.addClass('usort');
                }
            }
        });
        function deleteFile(obj, Key) {
            var Key = Key;
            var deleteBut = obj;
            deleteBut.closest('tr').classList.add("pulse");
            $.post('<?=get_template_directory_uri()?>/inc/deleteFileAmazon.php', {
                Key: Key
            }, function (data) // отправляем GET запрос на href, указанный в ссылке
            {
                var response = Boolean(data);
//                console.log(response);

                if (response==true) {
                    console.log("Response " + response);
                    deleteBut.closest('tr').remove();
                } else {
                    console.log("Response " + response);
                    deleteBut.closest('tr').classList.remove("pulse");
                }
            });
        }
    }
</script>