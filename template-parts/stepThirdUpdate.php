<?php
$cur_user_id = get_current_user_id();
$user_info = get_userdata($cur_user_id);
$role = $user_info->roles;
$role = $role[0];
require TEMPLATEPATH . '/vendor/autoload.php';
$config = require TEMPLATEPATH . "/inc/config.php";
use Aws\S3\S3Client;

function getSize($inputSize)
{
    if (empty($inputSize)) {
        $size = 0;
    } else {
        $size = $inputSize;
    }

    if ($size < 1024) {
        $size .= " b";
    } elseif ($size < (1024 * 1024)) {
        $size = round(($size / 1024), 1) . " kb";
    } else {
        $size = round((($size / 1024) / 1024), 1) . " mb";
    }
    return $size;
}

// Instantiate the client.
$s3 = S3Client::factory([
    'key' => $config['s3']['key'],
    'secret' => $config['s3']['secret'],
    'region' => 'eu-central-1'
]);
?>
<div class="row">
    <div class="col-md-12">
        <p>
            To finalize ad implementation, please provide the ad you want to place within the software. The developer
            can adapt it to the softwares art style or implement it as it is. Once you have agreed upon a design, the
            final file will be uploaded onto our server and streamed to new players immediately.
        </p>
    </div>
</div>
<div class="row">
    <?php
    if ($approvedDeveloper):
        ?>
        <?php if ($user_info->roles[0] == 'developer'): ?>
        <div class="alert alert-success">
            <strong>Success!</strong> All files have been approved, now click the finish button to finalize the ad placement.
        </div>
    <?php endif; ?>
        <br>
        <form action="<?php echo get_stylesheet_directory_uri() . '/inc/place-step/thirdStepUpdate.php?formSet=finish'; ?>"
              method="post">
            <input type="hidden" name="idDevPlace" value="<?= $idDevPlace; ?>">
            <input type="hidden" name="postIdPlace" value="<?= $postIdPlace; ?>">
            <input type="hidden" name="curIdPlace" value="<?= $cur_user_id; ?>">
            <?php if ($user_info->roles[0] == 'developer'): ?>
                <button class="btn red" style="width: 150px; margin: 0 auto; display: block">Finish</button>
            <?php elseif ($user_info->roles[0] == 'brand'): ?>
                <button class="btn red" style="width: 150px; margin: 0 auto; display: block">Book advertisement</button>
            <?php endif; ?>
            <div class="stepCheck">
                <input type="checkbox" name="confirmStep" required style="margin: 0 auto;">By booking an advertisement you accept and agree to the
                <?php if ($user_info->roles[0] == 'developer'): ?>
                    <a href="<?= content_url('/uploads/docs/Publisher_AGB.PDF') ?>">GTC</a>
                <?php elseif ($user_info->roles[0] == 'brand'): ?>
                    <a href="<?= content_url('/uploads/docs/Advertiser_AGB.PDF') ?>">GTC</a>
                <?php endif; ?> of vreo.
            </div>
        </form>
        <?php
    endif;
    ?>
</div>
<br>
<div class="table-scrollable">
    <?php
    $resultStep = $wpdb->get_results("SELECT * FROM pl_step_files_update WHERE id_dev = $idDevPlace AND id_post = $postIdPlace");
    $resultRole = $wpdb->get_results("SELECT * FROM pl_step_files_update WHERE id_dev = $idDevPlace AND id_post = $postIdPlace ORDER BY id DESC");
    $lastRole = $resultRole[0];
    $lastRole = $lastRole->role;
    ?>
    <table class="table table-striped table-bordered table-advance table-hover">
        <thead>

        <tr>
            <th class="text-center">
                <span>Download</span>
            </th>
            <th class="text-center">
                <span>Files</span>
            </th>
            <th class="text-center">
                <span>Size</span>
            </th>
            <th class="text-center">
                <span>Type</span>
            </th>
            <th>
                <span class="sortFiles">Button</span>
            </th>
        </tr>

        </thead>
        <tbody class="sortable">
        <?php
        $resultSt = $wpdb->get_results("SELECT * FROM place_step_f WHERE id_campaign = $postIdPlace");

        $id_brand = $resultSt[0]->id_brand;
        $id_dev = $resultSt[0]->id_dev;
        $user_brand = get_userdata($id_brand);
        $path = __DIR__ . '/../../../uploads/' . $user_brand->user_login . '/';
        foreach ($resultStep as $key => $value):
            $info = new SplFileInfo($resultStep[$key]->path_file);
//            $amazonFile = $s3->getObject()
            if ($resultStep[$key]->approve == 1 && $resultStep[$key]->approve_brand == 1):
                ?>
                <tr style="background-color: rgba(38, 194, 129, 0.19);">
                    <?php elseif
                    ($resultStep[$key]->approve !== $resultStep[$key]->approve_brand): ?>
                <tr style="background-color: rgba(243, 208, 90, 0.21);">
                    <?php elseif($resultStep[$key]->approve == -1 && $resultStep[$key]->approve_brand == -1): ?>
                <tr style="background-color: rgba(255, 0, 0, 0.16);">
            <?php else: ?>
                <tr>
            <?php endif; ?>
            <td class="text-center"><a
                    href="<?php echo $config['s3']['cdnPath'] . "/" . $resultStep[$key]->url_file; ?>">
                    <button type="button" class="btn btn-success"><i class="icon-arrow-down"></i>&nbsp;Download</button>
                </a></td>
            <td class="text-left" data-sort="file" style=" max-width: 320px;" data-value="">
                <?php
                if ($info->getExtension() == 'mp4' || $info->getExtension() == 'avi' || $info->getExtension() == 'mkv'):
                    ?>
                    <video width="320" height="240" controls>
                        <source src="<?php echo $config['s3']['cdnPath'] . "/" . $resultStep[$key]->url_file; ?>">
                    </video>
                <?php elseif ($info->getExtension() == 'png' || $info->getExtension() == 'jpg' || $info->getExtension() == 'jpeg'): ?>
                    <a class="image-popup-vertical-fit"
                       href="<?php echo $config['s3']['cdnPath'] . "/" . $resultStep[$key]->url_file; ?>">
                        <img src="<?php echo $config['s3']['cdnPath'] . "/" . $resultStep[$key]->url_file; ?>"
                             width="250" alt="">
                    </a>
                <?php elseif ($info->getExtension() == 'mp3'): ?>
                    <audio controls>
                        <source src="<?php echo $config['s3']['cdnPath'] . "/" . $resultStep[$key]->url_file; ?>">
                    </audio>
                <?php endif; ?>
            </td>
            <td class="text-center" data-sort="size" data-value=""><?= getSize($resultStep[$key]->file_size) ?></td>
            <td class="text-center" data-sort="type" data-value=""><?php echo $info->getExtension(); ?></td>
            <td>

                <form
                    action="<?php echo get_stylesheet_directory_uri() . '/inc/place-step/thirdStepUpdate.php?formSet=approve'; ?>"
                    style="display: inline-block" method="post">
                    <input type="hidden" name="idDevPlace" value="<?= $idDevPlace; ?>">
                    <input type="hidden" name="postIdPlace" value="<?= $postIdPlace; ?>">
                    <input type="hidden" name="curIdPlace" value="<?= $cur_user_id; ?>">
                    <button class="btn blue" name="approveId" <?php
                    $disabled;
                    if ($role == 'developer') {
                        $disabled = $resultStep[$key]->approve;
                    } else {
                        $disabled = $resultStep[$key]->approve_brand;
                    }
                    if ($disabled) {
                        echo 'disabled';
                    } ?> value="<?php echo $resultStep[$key]->id; ?>"> <?php

                        if ($disabled) {
                            echo 'Approved';
                        } else {
                            echo 'Approve';
                        } ?></button>
                </form>
                <form
                    action="<?php echo get_stylesheet_directory_uri() . '/inc/place-step/thirdStepUpdate.php?formSet=decline'; ?>"
                    style="display: inline-block" method="post">
                    <input type="hidden" name="idDevPlace" value="<?= $idDevPlace; ?>">
                    <input type="hidden" name="postIdPlace" value="<?= $postIdPlace; ?>">
                    <input type="hidden" name="curIdPlace" value="<?= $cur_user_id; ?>">
                    <button class="btn blue" name="approveId" <?php
                    $disabled;
                    if ($role == 'developer') {
                        $disabled = $resultStep[$key]->approve;
                    } else {
                        $disabled = $resultStep[$key]->approve_brand;
                    }
                    if ($disabled) {
                        echo 'disabled';
                    } ?> value="<?php echo $resultStep[$key]->id; ?>"> <?php

                        if ($disabled) {
                            echo 'Declined';
                        } else {
                            echo 'Decline';
                        } ?></button>
                </form>

            </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php //if (!$status && $role!==$lastRole): ?>
<?php if (!$status): ?>
    <div class="row">

        <div class="form-group ">
            <label class="control-label ">Upload file</label>

            <form
                action="<?php echo get_stylesheet_directory_uri() . '/inc/place-brand_upload.php?idDev=' . $idDevPlace . '&pageId=' . $postIdPlace; ?>"
                method="post" enctype="multipart/form-data">

                <div class="fileinput fileinput-new " data-provides="fileinput">
                    <div class="input-group input-large">
                        <div class="form-control uneditable-input input-fixed input-medium"
                             data-trigger="fileinput">
                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                            <span class="fileinput-filename"> </span>
                        </div>
                        <span class="input-group-addon btn default btn-file">
                        <span class="fileinput-new"> Select file </span>
                        <span class="fileinput-exists"> Change </span>
                            <input type="hidden">
                            <input type="file" id="campaign_video" name="placeBrandVideo"
                                   accept="video/mp4,video/x-m4v,video/*,image/*,audio/*">
                         </span>
                        <a href="javascript:;"
                           class="input-group-addon btn red fileinput-exists"
                           data-dismiss="fileinput"> Remove </a>
                    </div>
                </div>

        </div>
        <input type="hidden" name="idDevPlace" value="<?= $idDevPlace; ?>">
        <input type="hidden" name="postIdPlace" value="<?= $postIdPlace; ?>">
        <button class="btn green " type="submit">Send</button>
        </form>

    </div>
<?php endif; ?>
