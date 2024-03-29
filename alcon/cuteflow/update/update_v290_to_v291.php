<?php
	if($_REQUEST['language'] == '')
	{
		$_REQUEST['language'] = 'en';
	}
	
	require_once '../config/config.inc.php';
	require_once '../install/new_ver.inc.php';
	require_once '../language_files/language.inc.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $DEFAULT_CHARSET ?>">
	<title></title>
   	<link rel="stylesheet" href="../install/inst_format.css" type="text/css">
</head>
<body>

	<center>
		<div class="border_content">
		
			<div class="top">
				<div class="top_left">
					Cuteflow Update
				</div>
							
				<div class="top_right">
					<a href="http://cuteflow.org" target="_blank"><img src="../images/cuteflow_logo_small.png" border="0" /></a><br>
					<strong style="font-size:8pt;font-weight:normal">Version 2.9.0</strong>
				</div>
			</div>
				
			<div class="step">
				<table width="100%" height="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<span class="small">updating cuteflow...<br>
							</span>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="content_border">
				<span class="underline">Updating Cuteflow V.2.9.0 to <?php echo $nNewVersion ?></span>
				<div class="content">
		
					<?php
					
					$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD) or die (mysql_error());
					if ($nConnection)
					{
						if (mysql_select_db($DATABASE_DB, $nConnection))
						{
							?>
							<div class="check">
								<?php echo $INSTALL_DB_TABLES ?>...
								
								<?php
								// ---------------------- fix the wrong/missing settings from V2.7.0/ V2.8.0 ----------------------
								$query	= "UPDATE cf_user SET strEmail_Format = 'HTML', strEmail_Values = 'IFRAME'";
								$result = @mysql_query($query, $nConnection) or die (mysql_error());
								
								// ---------------------- fix the wrong/missing settings from V2.7.0/ V2.8.0 ----------------------
								$query	= "UPDATE cf_config SET strEMail_Format = 'HTML', strEMail_Values = 'IFRAME', strVersion = '2.9.1'";
								$result = @mysql_query($query, $nConnection) or die (mysql_error());
								
								// ---------------------- add bDeleted to cf_circulationform ----------------------
								$query	= "ALTER TABLE `cf_circulationform` ADD `bDeleted` INT NOT NULL ;";
								$result = @mysql_query($query, $nConnection) or die (mysql_error());
								?>
								
								<span class="check_ok">OK</span>
							</div>
							
							<div class="check">
								<?php echo $INSTALL_DB_WRITECONFIG ?>...
								<span class="check_ok">OK</span>
							</div>
							<?php
						}
					}
					?>
				</div>
			</div>
			
			<form method="post" action="../index.php" name="right">
				<div class="bottom_right">
					<input type="submit" value="<?php echo $INSTALL_BUTT_SCF ?>" class="button_next">
					<input type="hidden" name="language" value=<?php echo $_REQUEST['language'] ?>>
				</div>
			</form>
				
		</div>
	</center>
	
</body>
</html>