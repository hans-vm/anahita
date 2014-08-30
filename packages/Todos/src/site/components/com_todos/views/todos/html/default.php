<?php defined('KOOWA') or die; ?>

<module position="sidebar-b">
<ul class="nav nav-pills nav-stacked">
	<li class="nav-header">
       <?= @text('LIB-AN-SORT-TITLE') ?>
    </li>
    <?php $sorts = array('newest', 'priority', 'updated') ?>
    <?php foreach($sorts as $sort): ?>
	    <?php $active = ($sort == 'newest') ? 'active' : '' ?>
	    <li class="sort-option <?= $active ?>">
			<a data-trigger="Request" data-request-options="SortEntities" href="<?= @route('layout=list&sort='.$sort) ?>">
			<?= @text('LIB-AN-SORT-'.$sort) ?>
			</a>
		</li>
    <?php endforeach; ?>
</ul>
</module>

<?php if($actor): ?>
<div id="entity-add-wrapper" class="hide">
<?= @view('todo')->layout('form')->actor($actor) ?>
</div>
<?php endif; ?>

<?= @helper('ui.filterbox', @route('layout=list')) ?>

<div class="an-entities-wrapper" id="an-entities-main-wrapper">
	<?= @template('list') ?>
</div>