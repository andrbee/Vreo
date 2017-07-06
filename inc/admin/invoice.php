<?php

require_once(dirname(__FILE__) . '/../../../../../wp-load.php');

$arg = array(
    'post_status' => "publish,completed"
);

$campaigns = get_posts($arg);

if (!empty($campaigns)) {
    ?>
    <select name="campaign" id="admin_invoice" style="display: block;margin-top: 30px;width: 100px;" onchange="">
        <?
        foreach ($campaigns as $camp) { ?>
            <option value="<?= $camp->ID ?>"><?= $camp->post_title ?></option>
        <? } ?>
    </select>
    <?
} else {
    echo "<h3>No campaigns !</h3>";
} ?>
<div class="payments"></div>

<script>

    $('#admin_invoice').change(function () {
        var val = $(this).val();
        $.ajax({
            url: '../wp-content/themes/metronic/inc/admin/invoice/payments.php',
            type: "POST",
            data: "id="+val,
        success
            :
            function (data) {
                $('.payments').html(data);
            }
    })
        ;
    });

</script>