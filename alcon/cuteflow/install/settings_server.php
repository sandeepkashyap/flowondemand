<?php
	require_once '../language_files/language.inc.php';
	require_once '../pages/version.inc.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $DEFAULT_CHARSET ?>">
   	<link rel="stylesheet" href="inst_format.css" type="text/css">
</head>
<body>

	<center>
		<div class="border_content">
		
			<div class="top">
				<div class="top_left">
					<?php echo $INSTALL_HEAD ?>
				</div>
							
				<div class="top_right">
					<a href="http://cuteflow.org" target="_blank"><img src="../images/cuteflow_logo_small.png" border="0" /></a><br>
					<strong style="font-size:8pt;font-weight:normal">Version <?php echo $CUTEFLOW_VERSION ?></strong>
				</div>
			</div>
				
			<div class="step">
				
				<table width="100%" height="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<span class="small"><?php echo $INSTALL_STEP ?> 3/5<br>
						<?php echo $INSTALL_STEP1 ?> >> <?php echo $INSTALL_STEP2 ?> >> <span class="mandatory"><?php echo $INSTALL_STEP3 ?></span>
						</span>
					</td>
				</tr>
				</table>
			</div>
			
			<div class="content_border">
				<span class="underline"><?php echo $INSTALL_HEAD3_3 ?></span>
				<div class="content">
				
					<form action="writeserversettings.php" method="post" name="install_1">
					
					<?php
					$style = "background-color: #F0F0F0;";
					$style2 = $style;
					
					echo "<br><table width=\"500\" align=\"center\" bgcolor=\"white\" style=\"border: 1px solid grey;\" cellpadding=\"5\">";
					echo "<tr><td colspan =\"2\" class=\"table_header\">$CONFIG_HEADCATEGORY_SERVER</td><tr>";
					
						echo "<tr valign=\"top\" style=\"$style\">";
							echo "<td nowrap>$CONFIG_SERVER_CFSERVER</td>";
							echo "<td><input name=\"strIN_CF_Server\" type=\"text\" class=\"FormInput\" style=\"width:200px;\" value=\"".$_REQUEST["strIN_CF_Server"]."\">";
							echo "<div class=\"small\">$CONFIG_SERVER_CFSERVER_INFO</div>";
							echo"</td>";
							
						echo "</tr>";
						echo "<tr valign=\"top\" style=\"$style2\">";
							echo "<td nowrap>$CONFIG_SERVER_SMTPSEVER</td>";
							echo "<td><input name=\"strIN_SMTP_Server\" type=\"text\" class=\"FormInput\" style=\"width:200px;\" value=\"".$_REQUEST["strIN_SMTP_Server"]."\">";
							echo "<div class=\"small\">$CONFIG_SERVER_SMTPSEVER_INFO</div>";
							echo "</td>";
							
						echo "</tr>";
						echo "<tr valign=\"top\" style=\"$style\">";
							echo "<td nowrap>$CONFIG_SERVER_SMTPPORT</td>";
							echo "<td><input name=\"strIN_SMTP_port\" type=\"text\" class=\"FormInput\" style=\"width:200px;\" value=\"".$_REQUEST["strIN_SMTP_port"]."\">";
							echo "<div class=\"small\">$CONFIG_SERVER_SMTPPORT_INFO</div>";
							echo "</td>";
							
						echo "</tr>";
						echo "<tr valign=\"top\" style=\"$style2\">";
							echo "<td nowrap>$CONFIG_SERVER_SMTPUSERID</td>";
							echo "<td><input name=\"strIN_SMTP_userid\" type=\"text\" class=\"FormInput\" style=\"width:200px;\" value=\"".$_REQUEST["strIN_SMTP_userid"]."\">";
							echo "<div class=\"small\">$CONFIG_SERVER_SMTPUSERID_INFO</div>";
							echo "</td>";
							
						echo "</tr>";
						echo "<tr valign=\"top\" style=\"$style\">";
							echo "<td nowrap>$CONFIG_SERVER_SMTPPWD</td>";
							echo "<td><input name=\"strIN_SMTP_pwd\" type=\"password\" class=\"FormInput\" style=\"width:200px;\" value=\"".$_REQUEST["strIN_SMTP_pwd"]."\">";
							echo "<div class=\"small\">$CONFIG_SERVER_SMTPPWD_INFO</div>";
							echo "</td>";
							
						echo "</tr>";
						echo "<tr valign=\"top\" style=\"$style2\">";
							echo "<td nowrap>$CONFIG_SERVER_USEAUTH</td>";		
							if ($_REQUEST["bRB_SMTP_use_auth"]=="y")
							{
								echo "<td nowrap valign=\"top\"><input type=\"checkbox\" id=\"SMTP_use_auth\" name=\"bRB_SMTP_use_auth\" value=\"y\" checked>";
								echo "<div class=\"small\">$CONFIG_SERVER_USEAUTH_INFO</div>";
								echo "</td>";
							}
							else
							{
								echo "<td nowrap valign=\"top\"><input type=\"checkbox\" id=\"SMTP_use_auth\" name=\"bRB_SMTP_use_auth\" value=\"y\">";
								echo "<div class=\"small\">$CONFIG_SERVER_USEAUTH_INFO</div>";
								echo "</td>";
							}
							
						echo "</tr>";
					echo "</table>";
					?>
		
			</div>
			</div>	
			
			<div class="bottom_right">
				<input type="submit" value="<?php echo $INSTALL_BUTT_CON ?>" class="button_next"><input type="hidden" name="language" value="<?php echo $_REQUEST['language'] ?>">
			</div></form>
			
			<form action="writedatabase.php" method="post">
			<div class="bottom_left">
				<?php
				echo "<input type=\"hidden\" name=\"strIN_Host\" value=\"".$_REQUEST["strIN_Host"]."\">";
				echo "<input type=\"hidden\" name=\"strIN_DB\" value=\"".$_REQUEST["strIN_DB"]."\">";
				echo "<input type=\"hidden\" name=\"strIN_Pwd\" value=\"".$_REQUEST["strIN_Pwd"]."\">";
				echo "<input type=\"hidden\" name=\"strIN_UserID\" value=\"".$_REQUEST["strIN_UserID"]."\">";
				?>
				<input type="submit" value="<?php echo $INSTALL_BUTT_BAC ?>" class="button_prev"><input type="hidden" name="language" value="<?php echo $_REQUEST['language'] ?>">
			</div></form>	
		
		</div>
	</center>

</body>
</html>