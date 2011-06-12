<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div id="content">
    <div class="block">
        <h4><?php echo __('Reference No.'); ?> <?php echo $reference->id; ?></h4>
        <div class="content">
            <div class="form-row-long">
                <span class="tag"><?php echo __('Name'); ?></span>
                <?php echo $reference->name; ?>&nbsp;
            </div>
            <div class="form-row-long">
                <span class="tag"><?php echo __('Company'); ?></span>
                <?php echo $reference->company_name; ?>&nbsp;
            </div>
            <div class="form-row-long">
                <span class="tag"><?php echo __('Country, city, postcode'); ?></span>
                <?php echo $reference->country; ?>, <?php echo $reference->city; ?>, <?php echo $reference->postcode; ?>&nbsp;
            </div>
            <div class="form-row-long">
                <span class="tag"><?php echo __('Phone'); ?></span>
                <?php echo $reference->phone; ?>&nbsp;
            </div>
            <div class="form-row-long">
                <span class="tag"><?php echo __('Fax'); ?></span>
                <?php echo $reference->fax; ?>&nbsp;
            </div>
            <div class="form-row-long">
                <span class="tag"><?php echo __('E-mail'); ?></span>
                <a href="mailto: <?php echo $reference->e_mail; ?>"><?php echo $reference->e_mail; ?></a>&nbsp;
            </div>
            <div class="form-row-long">
                <span class="tag"><?php echo __('Website'); ?></span>
                <a href="<?php echo $reference->www; ?>"><?php echo $reference->www; ?></a>&nbsp;
            </div>
            <div class="form-row-long">
                <span class="tag"><?php echo __('Active'); ?></span>
                <?php echo ($reference->active==1) ? __('Yes') : __('No'); ?>&nbsp;
            </div>
            <div class="form-row-long">
                <span class="tag"><?php echo __('Created'); ?></span>
                <?php echo date("Y-m-d G:i:s", strtotime($reference->created)); ?>&nbsp;
            </div>
            <div class="form-row-long">
                <span class="tag"><?php echo __('Approved'); ?></span>
                <?php echo date("Y-m-d G:i:s", strtotime($reference->approved)); ?>&nbsp;
            </div>
            <div class="form-row-long">
                <p><?php
                if ($reference->file):
                    echo HTML::image_thumb($reference->file, 150, 60, TRUE);
                endif;
                ?></p>
                <p><?php echo $reference->reference_text; ?></p>
            </div>
        </div>
    </div>
</div>