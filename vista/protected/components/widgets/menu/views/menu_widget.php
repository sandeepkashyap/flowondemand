<div id="menu">
<?php if ($_menu && count($_menu->groups)):?>
<?php foreach ($_menu->groups as $_menu_group_name => $_menu_group):?>
	<ul class="group" id="menu_group_<?=$_menu_group_name?>">
  	<?php $i = 0; foreach ($_menu_group->items as $_menu_item): $i++?>
    	<?php if ($i == 1):?>
      	<li class="item <?=$_menu_group->items && count($_menu_group->items) == 1 ? 'single' : 'first';?><?=Yii::app()->wireframe->current_menu_item == $_menu_item->name ? 'active': ''?>" id="menu_item_<?=$_menu_item->name?>"><?=$_menu_item->render()?></li>
    	<?php elseif ($i == count($_menu_group->items)):?>
      	<li class="item <?=Yii::app()->wireframe->current_menu_item == $_menu_item->name? 'active' : ''?> last" id="menu_item_<?=$_menu_item->name?>"><?=$_menu_item->render()?></li>
    	<?php else:?>
      	<li class="item middle<?=Yii::app()->wireframe->current_menu_item == $_menu_item->name ? 'active' : ''?>" id="menu_item_<?=$_menu_item->name?>"><?=$_menu_item->render()?></li>
    	<?php endif;?>
  	<?php endforeach;?>
  	</ul>
<?php endforeach;?>
<?php endif;?>
</div>
<script type="text/javascript">
	App.MainMenu.init('menu');
</script>