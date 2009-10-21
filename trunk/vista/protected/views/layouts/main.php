<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2000/REC-xhtml1-200000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="language" content="en" />
<?php
/*echo CHtml::cssFile(Yii::app()->request->baseUrl.'/css/reset.css');
echo CHtml::cssFile(Yii::app()->request->baseUrl.'/css/typography.css');
echo CHtml::cssFile(Yii::app()->request->baseUrl.'/css/main.css');
echo CHtml::cssFile(Yii::app()->request->baseUrl.'/css/form.css');*/
//echo CHtml::cssFile(Yii::app()->request->baseUrl.'/css/ie.css');
echo CHtml::cssFile(ROOT_URL . '/css.php');
echo CHtml::cssFile(ASSETS_URL . '/themes/access/theme.css');
//echo CHtml::scriptFile(ROOT_URL . '/js.php');

$this->widget('JavascriptRegister');

$module_name = $this->getModule()->getId();
$controller_name = $this->getId();
$action_name = $this->getAction()->getId();
$run_controller_action = "if(App.{$module_name} && App.{$module_name}.controllers.{$controller_name}) {
        		if(typeof(App.{$module_name}.controllers.{$controller_name}.{$action_name}) == 'function') {
          			App.{$module_name}.controllers.{$controller_name}.{$action_name}();
        		}
			}";
Yii::app()->clientScript->registerScript('module.controller.action', $run_controller_action, 4);
?>

<!--[if IE]>
      <link rel="stylesheet" href="<?=ASSETS_URL?>/stylesheets/iefix.css" type="text/css" />
      <link rel="stylesheet" href="<?=ASSETS_URL?>/themes/access/iefix.css" type="text/css" media="screen"/>
<![endif]-->
<title>
<?php
	echo 'Pictomobile::' . Yii::app()->wireframe->getPageTitle();
?>
</title>



</head>

<body>
<!-- Print Preview -->
    <div id="print_preview_header">
      <ul>
        <li><button type="button" id="print_preview_print">{lang}Print{/lang}</button></li>
        <li><button type="button" id="print_preview_close">{lang}Close Preview{/lang}</button></li>
      </ul>
      <h2>{lang}Print Preview{/lang}</h2>
    </div>

    <!-- Top block -->
    <div id="top">
		<div class="container">
    	  <!--
    	  {if $logged_user->getFirstName()}
    	    {assign var=_welcome_name value=$logged_user->getFirstName()}
    	  {else}
    	    {assign var=_welcome_name value=$logged_user->getDisplayName()}
    	  {/if}
    	    <span class="inner">
      	    {lang name=$_welcome_name}Welcome back :name{/lang} | {if $logged_user->isAdministrator()}<a href="{assemble route=admin}" class="{if $wireframe->current_menu_item == 'admin'}active{/if}">{lang}Admin{/lang}</a> | {/if} <a href="{$logged_user->getViewUrl()}" class="{if $wireframe->current_menu_item == 'profile'}active{/if}">{lang}Profile{/lang}</a> | {link href='?route=logout'}{lang}Logout{/lang}{/link}
    	    </span>
    	  -->
			<?php $this->widget('UserStatus'); ?>			
			<!--
			<div id="header">
	        	<p id="site_log">
	        	  <a href="{assemble route=homepage}" class="site_logo"><img src="{brand what=logo}" alt="{$owner_company->getName()|clean} logo" title="{lang}Back to start page{/lang}" /></a>
	        	</p>
	        	<div id="menu">
	  <ul id="menu_group_main" class="group">
	            <li id="menu_item_people" class="item first"><a class="main" href="http://dev.vista.com/index.php?path_info=people"><span class="outer"><span style="background-image: url(http://dev.vista.com/assets/images/navigation/people.gif);" class="inner">People</span></span></a></li>
	                <li id="menu_item_projects" class="item middle"><a class="main" href="http://dev.vista.com/index.php?path_info=projects"><span class="outer"><span style="background-image: url(http://dev.vista.com/assets/images/navigation/projects.gif);" class="inner">Projects</span></span></a><span class="additional"><a href="http://dev.vista.com/index.php?path_info=jump-to-project"><span>Jump to Project</span></a></span></li>
	                <li id="menu_item_documents" class="item middle active"><a class="main" href="http://dev.vista.com/index.php?path_info=documents"><span class="outer"><span style="background-image: url(http://dev.vista.com/assets/modules/documents/images/icon.gif);" class="inner">Docs</span></span></a></li>
	                <li id="menu_item_calendar" class="item middle"><a class="main" href="http://dev.vista.com/index.php?path_info=dashboard%2Fcalendar"><span class="outer"><span style="background-image: url(http://dev.vista.com/assets/images/navigation/calendar.gif);" class="inner">Calendar</span></span></a></li>
	                <li id="menu_item_time" class="item last"><a class="main" href="http://dev.vista.com/index.php?path_info=time"><span class="outer"><span style="background-image: url(http://dev.vista.com/assets/images/navigation/time.gif);" class="inner">Time</span></span></a></li>
	        </ul>
	  <ul id="menu_group_folders" class="group">
	            <li id="menu_item_assignments" class="item first"><a class="main" href="http://dev.vista.com/index.php?path_info=assignments"><span class="outer"><span style="background-image: url(http://dev.vista.com/assets/images/navigation/assignments.gif);" class="inner">Assignmt.</span></span></a></li>
	                <li id="menu_item_search" class="item middle"><a class="main" href="http://dev.vista.com/index.php?path_info=quick-search"><span class="outer"><span style="background-image: url(http://dev.vista.com/assets/images/navigation/search.gif);" class="inner">Search</span></span></a></li>
	                <li id="menu_item_starred_folder" class="item middle"><a class="main" href="http://dev.vista.com/index.php?path_info=starred"><span class="outer"><span style="background-image: url(http://dev.vista.com/assets/images/navigation/starred.gif);" class="inner">Starred</span></span></a></li>
	                <li id="menu_item_trash" class="item middle"><a class="main" href="http://dev.vista.com/index.php?path_info=trash"><span class="outer"><span style="background-image: url(http://dev.vista.com/assets/images/navigation/trash.gif);" class="inner">Trash</span></span></a></li>
	                <li id="menu_item_quick_add" class="item last"><a accesskey="+" class="main" href="http://dev.vista.com/index.php?path_info="><span class="outer"><span style="background-image: url(http://dev.vista.com/assets/images/navigation/quick_add.gif);" class="inner">Quick Add</span></span></a></li>
	        </ul>
	</div>
        	<script type="text/javascript">
        	   App.MainMenu.init('menu');
        	</script>
        	-->

        </div>
      </div>
    </div>

    <?php if (isset($this->page_tabs)):?>
    <div id="tabs">
    	<div class="container">
      	<ul>
      	<?php $i = 0; foreach($this->page_tabs->data as $current_tab_name => $current_tab): ?>
      	  <li <?=$i++ == 1? 'class="first"' : ''?> id="page_tab_<?=$current_tab_name?>"><a href="<?=$current_tab['url']?>" <?=$current_tab_name == $this->page_tab ? 'class="current"' :''?>><span><?=Html::clean($current_tab['text'])?></span></a></li>
      	<?php unset($i); endforeach;?>
        </ul>
      </div>
    </div>
    <?php endif;?>
    <!--
    {if isset($page_tabs)}
    <div id="tabs">
    	<div class="container">
      	<ul>
      	{foreach from=$page_tabs->data key=current_tab_name item=current_tab name=page_tabs}
      	  <li {if $smarty.foreach.page_tabs.iteration == 1}class="first"{/if} id="page_tab_{$current_tab_name}"><a href="{$current_tab.url}" {if $current_tab_name == $page_tab}class="current"{/if}><span>{$current_tab.text|clean}</span></a></li>
      	{/foreach}
        </ul>
      </div>
    </div>
    {/if}
    <div id="tabs">
    	<div class="container">
      	<ul>
      	  <li class="first" id="page_tab_1"><a href="{$current_tab.url}" class="current"><span>Overview</span></a></li>
      	  <li id="page_tab_2"><a href="{$current_tab.url}"><span>Milestones</span></a></li>
      	  <li class="last" id="page_tab_3"><a href="{$current_tab.url}"><span>Checklists</span></a></li>
        </ul>
      </div>
    </div>
    -->

    <div id="page_header_container">
    	<div class="container">
        <div id="page_header" class="<?=$wireframe->details ? 'with_page_details' : 'without_page_details'?>">
	      	<div class="page_info_container">
	        	<h1 id="page_title"><?php echo Yii::app()->wireframe->getPageTitle()?></h1>
  					<?php if (Yii::app()->wireframe->getDetails()):?>
  						<p id="page_details"><?php echo Yii::app()->wireframe->getDetails()?></p>
  					<?php endif;?>
			</div>
			<?php $this->widget('PageAction'); ?>
 		  	<div class="clear"></div>
		  </div>
      </div>
    </div>

    <div id="page">
    	<div class="container">
    	  <div class="container_inner">
    	  <?php if (is_array(Yii::app()->wireframe->page_messages)):?>
    	    <div id="page_messages">
    		    <?php foreach (Yii::app()->wireframe->page_messages as $k => $page_message):?>
  		      <div class="page_message <?php echo $page_message['class']?> <?php if ($key === 0):?>first<?php endif;?>" style="background-image: url('<?php echo $page_message['icon']?>')">
  		        <p><?php echo $page_message['body']?></p>
  		      </div>
    		    <?php endforeach;?>
  		      <script type="text/javascript">
  		        $('#javascript_required').hide();
  		      </script>
    		  </div>
    		<?php endif;?>
    		  <ul id="breadcrumbs">
    		    <li class="first"><a href="<?php echo Yii::app()->createUrl('apps/application/index')?>">Applications</a>&raquo;</li>
    		    <?php foreach(Yii::app()->wireframe->bread_crumbs as $name => $bread_crumb):?>
    		    <li>
    		    <?php if (isset($bread_crumb['url'])):?>
    		      <a href="<?php echo $bread_crumb['url']?>" title="<?php echo $bread_crumb['url']?>"><?php echo $bread_crumb['text']?></a>&raquo;
    		    <?php else:?>
    		      <span class="current"><?php echo $bread_crumb['text']?></span>
    		    <?php endif;?>
    		    </li>
    		    <?php endforeach;?>
    		  </ul>

    		  <!--{flash_box}-->
    		  <?php if (Yii::app()->user->hasFlash('success')):?>
    		  <p id="<?php echo Yii::app()->user->getFlash('success')?>" class="flash"><span class="flash_inner"><?php echo Yii::app()->user->getFlash('success')?></span></p>
    		  <?php elseif (Yii::app()->user->hasFlash('error')):?>
    		  <p id="<?php echo Yii::app()->user->getFlash('success')?>" class="flash"><span class="flash_inner"><?php echo Yii::app()->user->getFlash('success')?></span></p>
    		  <?php endif;?>
    		  <div id="page_content">
    		    <!--{$content_for_layout}-->
    		    <?php echo $content; ?>
    		    <div class="clear"></div>
    		  </div>
    		  <div class="content_fix"></div>
        </div>
      </div>
    </div>

    <div id="footer">
      <p id="copyright">&copy;2009 by Pictomobile</p>
    </div>
</body>

</html>