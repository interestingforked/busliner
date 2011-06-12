<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript" src="/media/js/jquery.datepicker.ui.lv.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#start_date').datepicker($.datepicker.regional[ "lv" ]);
    $('#created').datepicker($.datepicker.regional[ "lv" ]);
/*    var elrteOptions = {cssClass:'el-rte',lang:'lv',height:300,styleWithCss:false,toolbar:'kfcms',cssfiles :['/media/css/elrte-inner.css'],
        fmOpen : function(callback) {$('<div />').elfinder({url:'/vendor/connector.php',
                lang:'en',dialog:{width:700,modal:true},closeOnEditorCallback:true,editorCallback:callback})
        }}
    $('.editor').elrte(elrteOptions); */
    $('.view').fancybox();
});
</script>
<script type="text/javascript">
$(function() {
    $('.select_buttons').click(function(){
        var arr = $(this).attr("name").split("2");
        var from = arr[0];
        var to = arr[1];
        $("#" + from + " option:selected").each(function(){
            $("#" + to).append($(this).clone());
            $(this).remove();
        });
    });
    $('#submit').click(function() {
        $('#user_roles option').each(function(index) {
            $(this).attr('selected',true);
        });
        return true;
    });
});
</script>

<div id="content">
    <?php echo Form::open(); ?>
    <div class="form-action">
        <?php echo Form::submit('submit', __('Save')); ?>
    </div>
    <?php
        if (!empty($errors)) {
            echo HTML::flash_message($errors);
            echo '<br/>';
        }
    ?>
    <div class="block">
        <h4 onclick="tb(1)"><?php echo __('Article info'); ?><span></span></h4>
        <div class="content" id="block1">
            <div class="form-row-long">
                <?php echo Form::label('title', __('Title'), NULL, TRUE) ?>
                <?php echo Form::input('title', $values->title, array('size' => 40)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('category_id', __('Category'), NULL, FALSE) ?>
                <?php echo Form::select('category_id', $categories, $values->category_id) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('language_id', __('Language'), NULL, TRUE) ?>
                <?php echo Form::select('language_id', $languages, $values->language_id) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('status', __('Status'), NULL, TRUE) ?>
                <?php echo Form::select('status', $status, $values->status) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('created', __('Datums')) ?>
                <?php echo Form::input('created', (($values->created)?date('Y-m-d', strtotime($values->created)):NULL)) ?>
                <span><?php echo __('(yyyy-mm-dd)'); ?></span>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('event', __('Add to events')) ?>
                <?php echo Form::checkbox('event', 1, FALSE) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('start_date', __('Start date')) ?>
                <?php echo Form::input('start_date') ?>
                <span><?php echo __('(yyyy-mm-dd)'); ?></span>
            </div>
        </div>
    </div>
    <div class="block">
        <h4 onclick="tb(2)"><?php echo __('Article content'); ?><span></span></h4>
        <div class="content" id="block2">
            <div class="form-row-long">
                <h5><?php echo __('Intro'); ?></h5>
                <?php echo Form::textarea('intro', $values->intro, array('rows' => 4, 'cols' => 60, 'style' => 'width:95%;')) ?>
            </div>
            <div class="form-row-long">
                <h5><?php echo __('Body'); ?></h5>
                <?php echo Form::textarea('body', ((empty($values->body))?'<p>'.$values->body.'</p>':$values->body), array('class' => 'editor')) ?>
            </div>
        </div>
    </div>
    <div class="block">
        <h4 onclick="tb(3)"><?php echo __('Article options'); ?><span></span></h4>
        <div class="content" id="block3">
            <div class="form-row-long">
                <?php echo Form::label('dontshow', __('Dont show mainpage')) ?>
                <?php echo Form::checkbox('dontshow', 1, ($values->dontshow==1)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('new', __('Hot article')) ?>
                <?php echo Form::checkbox('new', 1, ($values->new==1)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('actual', __('Actual article')) ?>
                <?php echo Form::checkbox('actual', 1, ($values->actual==1)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('competition', __('Konkurss')) ?>
                <?php echo Form::checkbox('competition', 1, ($values->competition==1)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('rss_enabled', __('Show in RSS')) ?>
                <?php echo Form::checkbox('rss_enabled', 1, ($values->rss_enabled==1)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('comments_enabled', __('Article comments')) ?>
                <?php echo Form::checkbox('comments_enabled', 1, ($values->comments_enabled==1)) ?>
            </div>
        </div>
    </div>
    <div class="block">
        <h4 onclick="tb(4)"><?php echo __('Article media'); ?><span></span></h4>
        <div class="content" id="block4">
            <div class="form-row-long">
                <h5><?php echo __('Photos'); ?></h5>
                <div id="photo-uploader">
                    <noscript><p>Please enable JavaScript to use file uploader.</p></noscript>
                </div>
                <ul id="photos-list"></ul>
            </div>
            <div class="border"></div>
            <?php if (isset($photos)) { ?>
            <div class="form-row-long">
                <h6><?php echo __('Uploaded photos'); ?></h6>
                <ul class="media-list">
                    <?php foreach ($photos AS $file) { ?>
                    <li id="file<?php echo $file->id; ?>">
                        <a href="<?php echo DS.$file->path.DS.$file->filename.'.'.$file->extension; ?>" class="view"><img src="/vendor/thumb.php?src=<?php echo $file->path.DS.$file->filename.'.'.$file->extension; ?>&w=50&h=35&zc=1" alt="<?php echo $file->filename; ?>" /></a>
                        <br/><a href="javascript:deleteMedia(<?php echo $file->id; ?>);"><?php echo __('Delete'); ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="border"></div>
            <?php } ?>
            <div class="form-row-long">
                <h5><?php echo __('Documents'); ?></h5>
                <div id="document-uploader">
                    <noscript><p>Please enable JavaScript to use file uploader.</p></noscript>
                </div>
                <ul id="documents-list"></ul>
            </div>
            <div class="border"></div>
            <?php if (isset($documents)) { ?>
            <div class="form-row-long">
                <h6><?php echo __('Uploaded documents'); ?></h6>
                <ul class="media-list">
                    <?php foreach ($documents AS $file) { ?>
                    <li class="not-floated" id="file<?php echo $file->id; ?>">
                        <a href="<?php echo DS.$file->path.DS.$file->filename.'.'.$file->extension; ?>"><?php echo $file->filename.'.'.$file->extension; ?></a>
                        &nbsp (<a href="javascript:deleteMedia(<?php echo $file->id; ?>);"><?php echo __('Delete'); ?></a>)</li>
                    <?php } ?>
                </ul>
            </div>
            <div class="border"></div>
            <?php } ?>
        </div>
    </div>
    <?php echo Form::close(); ?>
</div>
<script src="/media/js/fileuploader.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(createUploader('photo-uploader'));
$(document).ready(createUploader('document-uploader'));
if ($('.media-list li').length == 0) {
    $(document).ready(tb(4));
}
</script>
