<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
$(document).ready(function() {
    $.ajaxSetup({cache: false});
    $('.block h4').click(function() {
        $(this).parent().find('div.content').toggle();
    });
    $('.view').fancybox();
    $('#module').change(function() {
        var module = $(this).val();
        if (module == 'news' || module == 'events') {
            $.get('/admin/ajax/loadoptions/category', null, function(response) {
                if (response != 'false') {$('#module_id').html(response).show();}
            }, 'html');
        } else {
            $('#module_id').html('').hide();
        }
    });
    $('#file_browser').click(function () {
        $('body').append($('<div/>').attr('id', 'elfinder'));
        $('#elfinder').elfinder({
            url : '/vendor/connector.php',
            lang: 'lv',
            dialog : { width: 700, modal: true, title: 'Files', zIndex: 400001 }, // open in dialog window
            editorCallback: function(url) {
                var fullUrl = '<?php echo URL::site('', TRUE); ?>';
                $('#url').val(fullUrl + url.substring(1));
            },
            closeOnEditorCallback: true
        });
    });
});
function deleteMedia(id) {
    if (confirm('<?php echo __('Are you sure you want to delete this file!'); ?>') == true) {
        $.ajaxSetup({cache: false});
        $.get('/admin/ajax/deletemedia/' + id, null, function(responseText) {
            if (responseText=='true') {$('#file' + id).remove();}
            else {alert('<?php echo __('Cannot delete file!'); ?>');}
        }, 'html');
    }
}
</script>

<div id="content">
    <?php echo Form::open(); ?>
    <div class="form-action">
        <?php echo Form::submit('submit', __('Save page')); ?>
    </div>
    <?php
        if (!empty($errors)) {
            echo HTML::flash_message($errors);
            echo '<br/>';
        }
    ?>
    <div class="block">
        <h4 onclick="tb(1)"><?php echo __('Page info'); ?><span></span></h4>
        <div class="content" id="block1">
            <div class="form-row-long">
                <?php echo Form::label('parent_id', __('Parent page')) ?>
                <?php echo Form::select('parent_id', $pages, $page->parent_id, $translation) ?>
                <?php
                if (count($translation) > 0) {
                        echo Form::hidden('parent_id', $page->parent_id);
                }
                ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('language_id', __('Page language'), NULL, TRUE) ?>
                <?php echo Form::select('language_id', $languages, $title->language_id) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('slug', __('Page slug')) ?>
                <?php echo Form::input('slug', $title->slug, array('size' => 40)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('title', __('Page title'), NULL, TRUE) ?>
                <?php echo Form::input('title', $title->title, array('size' => 50)) ?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="block">
        <h4 onclick="tb(8)"><?php echo __('Advanced options'); ?><span></span></h4>
        <div class="content" id="block8">
            <div class="form-row-long" id="type_url">
                <?php echo Form::label('url', __('URL')) ?>
                <?php echo Form::input('url', $title->url, array('size' => 35)) ?>
                <?php
                $targets = array(
                    '_blank' => __('Blank target'),
                    '_self' => __('Self target'),
                    '_parent' => __('Parent target'),
                    '_top' => __('Top target'),
                );
                echo Form::select('url_target', $targets, $title->url_target);
                ?>
                <input type="button" name="file_browser" id="file_browser" value="Select file"/>
            </div>
            <div class="form-row-long" id="type_module">
                <?php echo Form::label('module', __('Module')) ?>
                <?php echo Form::select('module', $modules, $page->module) ?>
		<?php
		$module = FALSE;
		if (!empty($modules_list)) {
			$module = TRUE;
		} 
		?>
                <select id="module_id" name="module_id" <?php echo (($module) ? '' : 'style="display:none;"'); ?>><?php echo $modules_list; ?></select>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="block">
        <h4 onclick="tb(2)"><?php echo __('Page content'); ?><span></span></h4>
        <div class="content" id="block2">
            <div class="form-row-long">
                <?php echo Form::label('content_title', __('Content title')) ?>
                <?php echo Form::input('content_title', $content->content_title, array('size' => 50)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::textarea('body', ((empty($content->body))?'<p>'.$content->body.'</p>':$content->body), array('class' => 'editor')) ?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="block">
        <h4 onclick="tb(3)"><?php echo __('Page options'); ?><span></span></h4>
        <div class="content" id="block3">
            <div class="form-row-long">
                <?php echo Form::label('rss_enabled', __('Show in RSS')) ?>
                <?php echo Form::checkbox('rss_enabled', 1, ($page->rss_enabled == 1)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('comments_enabled', __('Page comments')) ?>
                <?php echo Form::checkbox('comments_enabled', 1, ($page->comments_enabled == 1)) ?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="block">
        <h4 onclick="tb(4)"><?php echo __('Page meta'); ?><span></span></h4>
        <div class="content" id="block4">
            <div class="form-row-long">
                <?php echo Form::label('meta_title', __('Meta title')); ?>
                <?php echo Form::input('meta_title', $content->meta_title, array('size' => 40)); ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('meta_keywords', __('Meta keywords')); ?>
                <?php echo Form::input('meta_keywords', $content->meta_keywords, array('size' => 40)); ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('meta_description', __('Meta description')); ?>
                <?php echo Form::textarea('meta_description', $content->meta_description, array('rows' => 5, 'cols' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="block">
        <h4 onclick="tb(5)"><?php echo __('Page media'); ?><span></span></h4>
        <div class="content" id="block5">
            <div class="form-row-long">
                <h5><?php echo __('Photos'); ?></h5>
                <div id="photo-uploader">
                    <noscript><p>Please enable JavaScript to use file uploader.</p></noscript>
                </div>
                <ul id="photos-list"></ul>
                <div class="clear"></div>
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
                <div class="clear"></div>
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
    <div class="clear"></div>
    <div class="block">
        <h4 onclick="tb(6)"><?php echo __('Page style'); ?><span></span></h4>
        <div class="content" id="block6">
            <div class="form-row-long">
                <?php echo Form::textarea('page_css', $content->page_css, array('rows' => 7, 'cols' => 60)); ?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="block">
        <h4 onclick="tb(7)"><?php echo __('Page scripts'); ?><span></span></h4>
        <div class="content" id="block7">
            <div class="form-row-long">
                <?php echo Form::textarea('page_js', $content->page_js, array('rows' => 7, 'cols' => 60)); ?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="block">
        <h4 onclick="tb(9)"><?php echo __('Page sidebar'); ?><span></span></h4>
        <div class="content" id="block9">
            <div class="form-row-long">
                <?php echo Form::textarea('sidebar', $content->sidebar, array('class' => 'editor')) ?>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>
</div>

<script src="/media/js/fileuploader.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(createUploader('photo-uploader'));
$(document).ready(createUploader('document-uploader'));
if ($('#url').val() == '' && $('#url').val() == 0 && $('#module').val() == '' && $('#module').val() == 0) {
    $(document).ready(tb(8));
} else {
    $(document).ready(tb(2));
}
$(document).ready(tb(3));
$(document).ready(tb(4));
if ($('.media-list li').length == 0) {
    $(document).ready(tb(5));
}
$(document).ready(tb(6));
$(document).ready(tb(7));
$(document).ready(tb(9));
</script>
