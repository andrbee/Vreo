<div class="main-compaing">
    <div class="row">
        <div class="col-md-6">
            <div class="compaign-info-form">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><strong>Intro text</strong> <span class="required"
                                                                 aria-required="true">*</span><span
                                style="color:red" id="intro-text"></span></label>
                                    <textarea name="campaign-description" id="editor7" class="required" rows="10"
                                              cols="80" minlength="5" required></textarea>

                        <script>
                            // Replace the <textarea id="editor1"> with a CKEditor
                            // instance, using default configuration.
                            CKEDITOR.replace('editor7', {
                                    'customConfig': 'config_introtext.js',
                                    'filebrowserBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=files',
                                    'filebrowserImageBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=images',
                                    'filebrowserFlashBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=flash',
                                    'filebrowserUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=files',
                                    'filebrowserImageUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=images',
                                    'filebrowserFlashUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=flash'
                                }
                            );
                        </script>

                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <label><strong>Content</strong></label>
                <textarea name="editor1" id="editor1" rows="10" cols="80"></textarea>
                <script>
                    // Replace the <textarea id="editor1"> with a CKEditor
                    // instance, using default configuration.
                    CKEDITOR.replace('editor1', {
                        'filebrowserBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=files',
                        'filebrowserImageBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=images',
                        'filebrowserFlashBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=flash',
                        'filebrowserUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=files',
                        'filebrowserImageUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=images',
                        'filebrowserFlashUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=flash'
                    });

                </script>
            </div>
        </div>
        <div class="col-md-6">
            <div class="compaign-info-form">
                 <label class="control-label col-md-12">Upload video</label>
                 <div class="col-md-11">
                    <div class="form-group form-md-line-input form-md-floating-label has-success">
                        <input type="text" name="campaign-yt-title" class="form-control " placeholder="">
                        <label>Video title</label>

                    </div>
                </div>
                <div class="compaign-info-form--wrap">
                    <div class="col-md-5">
                        <div class="form-group form-md-line-input form-md-floating-label has-success">
                            <input type="text" name="campaign-yt-url" class="form-control">
                            <label>Video url</label>

                        </div>
                    </div>
                    <div class="col-md-1">OR</div>
                    <div class="col-md-6">
                        <div class="form-group">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
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
                                                                        <input type="file" id="campaign_video"
                                                                               name="campaign_video"
                                                                               onchange="uploadFilesSize()"
                                                                               accept="video/mp4,video/x-m4v,video/*">
                                                                    </span>
                                        <a href="javascript:;"
                                           class="input-group-addon btn red fileinput-exists"
                                           data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                           
                        </div>
                    </div>
            </div>


            </div>
            <div class="row">
                <div id="player-youtube"></div>
            </div>
            <script>
                $("input[name='campaign-yt-url']").keyup(function () {
                    var value = $("input[name='campaign-yt-url']").val();
                    var getvalue = value.split("v=")[1];
                    var player = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' + getvalue + '" frameborder="0" allowfullscreen></iframe>';
                    $('#player-youtube').html(player);
                });
            </script>
            <div class="row image-game__form">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                    <div class="image-game">
                        <br><label><strong>Promo-Screenshot</strong></label><br>
                        <div class="form-group last compaign-info__photo">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail compaign-info__setting">
                                    <img id="imgImageBg"
                                         src="http://www.placehold.it/600x600/EFEFEF/AAAAAA&amp;text=no+image"
                                         alt="">
                                </div>
                                <div id="imgImageNew"
                                     class="fileinput-preview fileinput-exists thumbnail"></div>
                                <div>
                                                        <span class="btn default btn-file compaign-info__btn">
                                                            <span class="fileinput-new"> Select image </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <?php wp_nonce_field('campaign-image', 'campaign-image-Upload'); ?>
                                                            <input type="file" name="campaign-image" id="campaign-image"
                                                                   onchange="uploadFilesSize()"
                                                                   accept="image/jpeg,image/png,image/gif">
                                                        </span>
                                    <a href="javascript:;"
                                       class="btn red fileinput-exists compaign-info__reset"
                                       data-dismiss="fileinput"> Remove </a>

                                </div>

                            </div>
                            <div class="clearfix margin-top-10"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="image-game">
                        <label><strong>Campaigns background</strong></label><br>
                        <div class="form-group last compaign-info__photo">

                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail compaign-info__setting">
                                    <img id="imgBg"
                                         src="http://www.placehold.it/600x600/EFEFEF/AAAAAA&amp;text=no+image"
                                         alt=""></div>
                                <div id="imgBgNew"
                                     class="fileinput-preview fileinput-exists thumbnail"></div>
                                <div>
                                                            <span class="btn default btn-file compaign-info__btn">
                                                                <span class="fileinput-new"> Select image </span>
                                                                <span class="fileinput-exists"> Change </span>
                                                                <?php wp_nonce_field('campaign-bg', 'campaign-bg-Upload'); ?>
                                                                <input type="file" name="campaign-bg" id="campaign-bg"
                                                                       onchange="uploadFilesSize()"
                                                                       accept="image/jpeg,image/png,image/gif">
                                                            </span>
                                    <a href="javascript:;"
                                       class="btn red fileinput-exists compaign-info__reset"
                                       data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                            <div class="clearfix margin-top-10"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row image-game__form">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                    <div class="image-game">
                        <br><label><strong>Placeholder for ad-area</strong> <span data-toggle="tooltip"
                                                                                  data-placement="top"
                                                                                  title=""
                                                                                  data-original-title="When no ads are bound to the campaign, this placeholder will be shown instead.">?</span></label><br>
                        <div class="form-group last compaign-info__photo">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail compaign-info__setting">
                                    <img id="imgImageBg"
                                         src="http://www.placehold.it/600x600/EFEFEF/AAAAAA&amp;text=no+image"
                                         alt="">
                                </div>
                                <div id="imgImageNew"
                                     class="fileinput-preview fileinput-exists thumbnail"></div>
                                <div>
                                                        <span class="btn default btn-file compaign-info__btn">
                                                            <span class="fileinput-new"> Select image </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <?php wp_nonce_field('placeholder-plugin', 'placeholder-plugin-Upload'); ?>
                                                            <input type="file" name="placeholder-plugin"
                                                                   id="placeholder-plugin"
                                                                   onchange="uploadFilesSize()"
                                                                   accept="image/jpeg,image/png,image/gif">
                                                        </span>
                                    <a href="javascript:;"
                                       class="btn red fileinput-exists compaign-info__reset"
                                       data-dismiss="fileinput"> Remove </a>

                                </div>

                            </div>
                            <div class="clearfix margin-top-10"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>