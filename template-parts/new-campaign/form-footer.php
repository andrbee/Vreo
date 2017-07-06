<div class="row">
    <div class="col-md-6">
        <h4 style="margin-left: 15px;">Additional information</h4>
        <div class="compaign-info-form">
            <div class="col-md-9">
                <div class="form-group form-md-line-input form-md-floating-label has-success">
                    <input type="text" name="campaign-desc-addition" class="form-control " placeholder="">
                    <label>Title for additional information</label>

                </div>
            </div>

        </div>
    </div>
    <div class="col-md-6">
        <h4>Slider with placement Ads <span class="required" style="color:red;"
                                            aria-required="true">*</span></h4>
        <div class="form-group form-md-line-input form-md-floating-label has-success">
            <input type="text" name="slider-title" class="form-control " placeholder="">
            <label>Title of slider</label>
        </div>
    </div>
</div>
<div class="row dropbox-editor-wrap">
     <div class="col-md-6"> 
        <textarea name="editor2" id="editor2" rows="10" cols="80"></textarea>
        <script>
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('editor2', {
                'filebrowserBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=files',
                'filebrowserImageBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=images',
                'filebrowserFlashBrowseUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/browse.php?type=flash',
                'filebrowserUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=files',
                'filebrowserImageUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=images',
                'filebrowserFlashUploadUrl': '<?=get_stylesheet_directory_uri()?>/plugins/ckeditor/kcfinder/upload.php?type=flash'
            });

        </script>
    </div>
    <div class="col-md-6">        
        <div id="dropbox">
            <span class="message">Drop files here</span>
        </div>
    </div>
</div>