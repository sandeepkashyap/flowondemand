<ul id="breadcrumbs">
	<li class="first"><a href="#">Dashboard</a>&raquo;</li>
    	<?php foreach($bread_crumbs as $bread_crumb): ?>
	<li>
    	<?php if (isset($bread_crumb['url'])):?>
    	<a href="<?=$bread_crumb['url']?>" title="<?=$bread_crumb['text']?>}"><?=$bread_crumb['text']?></a>&raquo;
    <?php else:?>
    	<span class="current"><?=$bread_crumb['text']?></span>
    <?php endif;?>
    </li>
   		<?php endforeach;?>
</ul>