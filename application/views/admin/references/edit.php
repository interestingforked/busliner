<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript" src="/media/js/jquery.datepicker.ui.lv.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#created').datepicker($.datepicker.regional[ "lv" ]);
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
        <h4 onclick="tb(1)"><?php echo __('Reference'); ?><span></span></h4>
        <div class="content" id="block1">
            <div class="form-row-long">
                <?php echo Form::label('name', __('Name'), NULL, TRUE) ?>
                <?php echo Form::input('name', $reference->name, array('size' => 40)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('company_name', __('Company name'), NULL, TRUE) ?>
                <?php echo Form::input('company_name', $reference->company_name, array('size' => 40)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('country', __('Country'), NULL, TRUE) ?>
                <?php echo Form::input('country', $reference->country, array('size' => 40)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('city', __('City'), NULL, TRUE) ?>
                <?php echo Form::input('city', $reference->city, array('size' => 30)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('postcode', __('Postcode'), NULL, TRUE) ?>
                <?php echo Form::input('postcode', $reference->postcode, array('size' => 15)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('phone', __('Phone'), NULL, TRUE) ?>
                <?php echo Form::input('phone', $reference->phone, array('size' => 15)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('fax', __('Fax'), NULL, TRUE) ?>
                <?php echo Form::input('fax', $reference->fax, array('size' => 15)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('e_mail', __('E-mail'), NULL, TRUE) ?>
                <?php echo Form::input('e_mail', $reference->e_mail, array('size' => 30)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('www', __('Website'), NULL, TRUE) ?>
                <?php echo Form::input('www', $reference->www, array('size' => 30)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('created', __('Datums')) ?>
                <?php echo Form::input('created', (($reference->created)?date('Y-m-d', strtotime($reference->created)):NULL)) ?>
                <span><?php echo __('(yyyy-mm-dd)'); ?></span>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('active', __('Active')) ?>
                <?php echo Form::checkbox('active', 1, $reference->active==1) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('reference_text', __('Reference')) ?>
                <?php echo Form::textarea('reference_text', $reference->reference_text, array('rows' => 10, 'cols' => 60)) ?>
            </div>
            
            <div class="form-row-long">
                <?php echo Form::label('file', __('Logo')) ?>
                <?php
                if ($reference->file):
                    echo HTML::image_thumb($reference->file, 150, 60, TRUE);
                endif;
                ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <?php echo Form::close(); ?>
</div>