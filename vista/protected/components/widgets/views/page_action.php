<?php if ($print_button || count($page_actions) > 0): ?>
<ul id="page_actions">
	<?php if (count($page_actions) > 0): ?>
		<?php $i = 0; foreach ($page_actions as $page_action_name => $page_action): $i++?>
	  	    <?php if (count($page_actions) == 1):?>
	  	        <li id="<?=$page_action_name . '_page_action'?>" class="single <?=count($page_action['subitems']) > 0 ? 'with_subitems hoverable' : 'without_subitems'?>">
	  	    <?php else:?>
	    	      <li id="<?=$page_action_name . '_page_action'?>" class="<?=$i == 1? 'first' : ($i = count($page_actions) ? 'last' : '');?> <?=count($page_action['subitems']) > 0 ? 'with_subitems hoverable' : 'without_subitems'?>">
	  	    <?php endif;?>
	  	        <?php echo Html::openTag('a', array('id' => $page_action['id'], 'href'=> $page_action['url'], 'method' => $page_action['method'], 'confirm' => $page_action['confirm'], 'not_lang' => true)); echo '<span>' . $page_action['text'] . (count($page_action['subitems']) > 0 ? '<img src="dropdown_arrow.gif" alt="" />' : '') . '</span>'; echo Html::closeTag('a');?>
	  	    <?php if (count($page_action['subitems'])):?>
	  	        <ul>
	  	        <?php foreach ($page_action['subitems'] as $page_action_subaction_name => $page_action_subaction):?>
	  	          	<?php if ($page_action_subaction['text'] && isset($page_action_subaction['url'])):?>
	  	        	<li id="<?=$page_action_subaction_name . '_page_action'?>" class="subaction">
	  	        		<?php echo Html::openTag('a', array('id' => $page_action_subaction['id'], 'method' => $page_action_subaction['method'], 'confirm' => $page_action_subaction['confirm'], 'not_lang' => true)); echo '<span>' . $page_action['text'] . (count($page_action_subaction['text']) > 0 ? '<img src="dropdown_arrow.gif" alt="" />' : '') . '</span>'; echo Html::closeTag('a');?>
	  	          	</li>
	  	          	<?php else:?>
	  	          	<li id="<?=$page_action_subaction_name . '_page_action'?>" class="separator">
	  	          	<?php endif;?>
				<?php endforeach;?>
	  	        </ul>
			<?php endif;?>
	  	      </li>
		<?php unset($i); endforeach;?>
	<?php endif;?>
</ul>
<?php endif;?>