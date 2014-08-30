<?php defined('KOOWA') or die('Restricted access');?>

<div class="btn-toolbar clearfix">
    <div class="pull-right btn-group">
        <a class="btn <?= ($sort != 'top') ? 'disabled' : '' ?>" href="<?= @route(array('sort'=>'trending')) ?>">
            <i class="icon-time"></i>
            <?= @text('COM-HASHTAGS-SORT-TRENDING') ?>
        </a>
        <a class="btn <?= ($sort == 'top') ? 'disabled' : '' ?>" href="<?= @route(array('sort'=>'top')) ?>">
            <i class="icon-fire"></i>
            <?= @text('LIB-AN-SORT-TOP') ?>
        </a> 
    </div>
</div>