<?php
global $wpdb;

require TEMPLATEPATH . '/vendor/autoload.php';
$config = require TEMPLATEPATH . '/inc/config.php';
use Aws\S3\S3Client;


// Instantiate the client.
$s3 = S3Client::factory([
    'key' => $config['s3']['key'],
    'secret' => $config['s3']['secret'],
    'region' => 'eu-central-1'
]);

if (isset($_POST['uploadPlugin'])) {
    if ((isset($_POST['platformPlugin']) && !empty($_POST['platformPlugin'])) && (isset($_POST['namePlugin']) &&
            !empty($_POST['namePlugin'])) && (isset($_POST['versionPlugin']) && !empty($_POST['versionPlugin'])) &&
        isset($_FILES['filePlugin']) && (!empty($_FILES['filePlugin'])) && $_FILES['filePlugin']['error'] == 0
    ) {
        $name = "Plugins/" . $_FILES['filePlugin']['name'];
        try {
            $params = [
                'Bucket' => $config['s3']['bucket'],
                'Key' => $name,
                'Body' => fopen($_FILES['filePlugin']['tmp_name'], "rb"),
                'ACL' => 'public-read'
            ];

            $result = $s3->putObject($params);
            if ($s3->doesObjectExist($config['s3']['bucket'], $name)) {
                $args = [
                    'platform' => $_POST['platformPlugin'],
                    'name' => $_POST['namePlugin'],
                    'version' => $_POST['versionPlugin'],
                    'url' => $name,
                    'size' => $_FILES['filePlugin']['size']
                ];
                $wpdb->insert('vreo_plugins', $args);
            }

        } catch (S3_Exception $message) {
            die($message);
        }

    } else {
        echo "Download failed";
    }
}
$resPlugins = $wpdb->get_results('SELECT * FROM vreo_plugins');
function getSize($inputSize)
{
    $size = $inputSize;

    if ($size < 1024) {
        $size .= " b";
    } elseif ($size < (1024 * 1024)) {
        $size = round(($size / 1024), 1) . " kb";
    } else {
        $size = round((($size / 1024) / 1024), 1) . " mb";
    }
    return $size;
}

if (!empty($resPlugins)) {
    ?>
    <div class="table-scrollable">
        <table class="table table-striped table-bordered table-advance table-hover">
            <thead>
            <tr>
                <th class="text-center">
                    <span data-sort="platform" class="sortFiles">Platform </span>
                </th>
                <th>
                    <span data-sort="name" class="sortFiles">Name</span>
                </th>
                <th class="text-center">
                    <span data-sort="version" class="sortFiles">Version</span>
                </th>
                <th class="text-center">
                    <span data-sort="size" class="sortFiles">Size</span>
                </th>
                <th class="text-center">
                    <span>Download</span>
                </th>
                <th class="text-center">
                    <span></span>
                </th>
            </tr>
            </thead>
            <tbody class="sortable">
            <? foreach ($resPlugins as $plugin) {
                $platform = $plugin->platform;
                $name = $plugin->name;
                $version = $plugin->version;
                $url = $config['s3']['cdnPath'] . "/" . $plugin->url;
                $size = $plugin->size;
                $Key = $plugin->url;
                ?>
                <tr>
                    <td class="text-center" data-sort="platform" data-value="<?= $platform ?>"><?= $platform ?></td>
                    <td data-sort="name" data-value="<?= $name ?>"><?= $name ?></td>
                    <td class="text-center" data-sort="version" data-value="<?= $version ?>"><?= $version ?></td>
                    <td class="text-center" data-sort="size" data-value="<?= $size ?>"><?= getSize($size) ?></td>
                    <td class="text-center"><a href="<?= $url ?>">download</a></td>
                    <td class="text-center"><a href="" onclick="event.preventDefault(); delPlugin(this)"
                                               data-key="<?= $Key ?>">Delete</a></td>
                </tr>
            <? } ?>
            </tbody>
        </table>
    </div>
<? } ?>
<h2>Upload new plugin</h2>
<form action="" method="post" enctype="multipart/form-data" class="vreo__plugins">
    <select name="platformPlugin" onchange="emptyElemsForm(this);">
        <option value="windows">Windows</option>
        <option value="mac">Mac OS</option>
    </select>
    <input type="text" name="namePlugin" placeholder="Name plugin" onkeyup="emptyElemsForm(this);">
    <input type="text" name="versionPlugin" placeholder="Version" onkeyup="emptyElemsForm(this);">
    <input type="file" name="filePlugin" onchange="emptyElemsForm(this);">
    <button type="submit" name="uploadPlugin" disabled>Upload</button>
</form>
<script>
    function emptyElemsForm(el) {
        var element = el;
        if (element.closest('.vreo__plugins')) {
            var platformPlugin = document.querySelector(".vreo__plugins select[name='platformPlugin']").value;
            var namePlugin = document.querySelector(".vreo__plugins input[name = 'namePlugin']").value;
            var versionPlugin = document.querySelector(".vreo__plugins input[name = 'versionPlugin']").value;
            var filePlugin = document.querySelector(".vreo__plugins input[name = 'filePlugin']").value;
            var submit = document.querySelector(".vreo__plugins button[name = 'uploadPlugin']");
            if (platformPlugin !== "" && namePlugin !== "" && versionPlugin !== "" && filePlugin !== "") {
                if (submit.hasAttribute('disabled')) {
                    submit.removeAttribute('disabled');
                }
            } else {
                if (!submit.hasAttribute('disabled')) {
                    submit.setAttribute('disabled', true);
                }
            }
        }
    }
    function delPlugin(obj) {
        var tbody = obj.closest("tbody");
        var tr = obj.closest("tr");
        var key = obj.getAttribute('data-key');
        var all = $("body");
        $.ajax({
            type: 'POST',
            url: "<?=get_stylesheet_directory_uri()?>/inc/deletePlugin.php",
            data: "Key=" + key,
            success: function (data) {
                console.log(data)
                if (Boolean(data)) {
                    if (tbody.children.length == 1) {
                        tbody.closest('table').remove();
                    } else {
                        tr.remove();
                    }
                }
            },
            error: function () {
                console.log("Файл не удалось удалить !");
            }
        });
    }
</script>