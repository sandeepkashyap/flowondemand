<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<?php
	/** Copyright (c) Timo Haberkern. All rights reserved.
	*
	* Redistribution and use in source and binary forms, with or without 
	* modification, are permitted provided that the following conditions are met:
	* 
	*  o Redistributions of source code must retain the above copyright notice, 
	*    this list of conditions and the following disclaimer. 
	*     
	*  o Redistributions in binary form must reproduce the above copyright notice, 
	*    this list of conditions and the following disclaimer in the documentation 
	*    and/or other materials provided with the distribution. 
	*     
	*  o Neither the name of Timo Haberkern nor the names of 
	*    its contributors may be used to endorse or promote products derived 
	*    from this software without specific prior written permission. 
	*     
	* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
	* AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, 
	* THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR 
	* PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR 
	* CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, 
	* EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, 
	* PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; 
	* OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, 
	* WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR 
	* OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, 
	* EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
	*/
	
	include_once ("../language_files/language.inc.php");
	include ("../config/config.inc.php");
		
	//--- open database
   	$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
   	
   	if ($nConnection)
   	{
   		if (mysql_select_db($DATABASE_DB, $nConnection))
   		{
			//-----------------------------------------------
    		//--- get all fields
            //-----------------------------------------------
            $arrFields = array();
    		$strQuery = "SELECT * FROM cf_inputfield ORDER BY strName ASC";
    		$nResult = mysql_query($strQuery, $nConnection);
    		if ($nResult)
    		{
    			if (mysql_num_rows($nResult) > 0)
    			{
    				while (	$arrRow = mysql_fetch_array($nResult))
    				{
    					$arrFields[$arrRow["nID"]] = $arrRow;						
    				}
    			}
    		}
			
			//-----------------------------------------------
    		//--- get all slots for the given template
            //-----------------------------------------------
			$arrSlots = array();
            $strQuery = "SELECT * FROM cf_formslot WHERE nTemplateID=".$_REQUEST["templateid"]."  ORDER BY nSlotNumber ASC";
    		$nResult = mysql_query($strQuery, $nConnection);
    		if ($nResult)
    		{
    			if (mysql_num_rows($nResult) > 0)
    			{
    				while (	$arrRow = mysql_fetch_array($nResult))
    				{
    					$arrSlots[] = $arrRow;
    				}
    			}
    		}
			
	
			if (-1 != $listid)
			{
				//-----------------------------------------------
				//--- get the mailing list
				//-----------------------------------------------
				$query = "select * from cf_mailinglist WHERE nID=".$_REQUEST["listid"];
				$nResult = mysql_query($query, $nConnection);
				if ($nResult)
				{
					if (mysql_num_rows($nResult) > 0)
					{
						$arrMailingList = mysql_fetch_array($nResult);				
					}
				}		
			}
		}
	}
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $DEFAULT_CHARSET ?>">
	<title></title>	
	<link rel="stylesheet" href="format.css" type="text/css">
	<script language="JavaScript">
	<!--
		function back()
		{
			document.location.href="edittemplate_step2.php?language=<?php echo $_REQUEST["language"];?>&start=<?php echo $_REQUEST["start"];?>&sortby=<?php echo $_REQUEST["sortby"];?>&templateid=<?php echo $_REQUEST["templateid"];?>&reload=1";
		}
	
		function up(SlotId, nPosition)
		{
			if (nPosition > 1)
			{
				swapPosition (SlotId, nPosition-1, nPosition);
			}
		}
		
		function down(SlotId, nPosition)
		{
			strDestinationId = "AttachedFields_"+SlotId;
			objDestinationTable = document.getElementById(strDestinationId);		
			nLastPos = getLastPosition(objDestinationTable);
			
			if (nPosition < nLastPos)
			{
				swapPosition (SlotId, nPosition+1, nPosition);
			}
		}
		
		//--- swapping nPos2 in front of nPos1
		function swapPosition (SlotId, nPos1, nPos2)
		{
			strDestinationId = "AttachedFields_"+SlotId;
			objTable = document.getElementById(strDestinationId);			
			
			//--- copy the pos2 in front of pos1
			objRow1 = findRow(objTable, nPos1);
			objRow2 = findRow(objTable, nPos2);
			
			if (objRow1)
			{
				objRow1.swapNode(objRow2);
			
				changePosition(objRow1, nPos2, SlotId);
				changePosition(objRow2, nPos1, SlotId);
			}
		}
		
		function changePosition(objRow, nPosNumber, SlotId)
		{
			nPosTd = getPosOfType(objRow.childNodes, "TD", 1);
			nHrefTd = getPosOfType(objRow.childNodes, "TD", 4);
			
			objRow.childNodes[nPosTd].innerHTML = nPosNumber;

			//--- change "remove"-href
			nHref3Pos = getPosOfType(objRow.childNodes[nHrefTd].childNodes, "A", 1);
			objHref3 = objRow.childNodes[nHrefTd].childNodes[nHref3Pos];
			strUrl = "javascript:remove("+SlotId+","+nPosNumber+")";
			objHref3.setAttribute("href", strUrl);
			
			//--- change the hidden input field
			nInputPos = getPosOfType(objRow.childNodes[nHrefTd].childNodes, "INPUT", 1);
			objInput = objRow.childNodes[nHrefTd].childNodes[nInputPos];
			
			strCurValue = objInput.getAttribute("value");
			
			Ids = strCurValue.split("_");
			strNewId = SlotId+"_"+Ids[1]+"_"+nPosNumber;
			objInput.setAttribute("id", strNewId);
			objInput.setAttribute("name", strNewId);
			objInput.setAttribute("value", strNewId);					
		}
		
		function remove(SlotId, nPosition)
		{
			strDestinationId = "AttachedFields_"+SlotId;
			objTable = document.getElementById(strDestinationId);
			
			//--- remove row
			objRowDelete = findRow(objTable, nPosition);
			objTable.removeChild(objRowDelete);
			
			//--- renumber all following rows
			nLastPos = getLastPosition(objTable);
			for (nCurPos = nPosition+1; nCurPos <= nLastPos; nCurPos++)
			{
				objCurRow = findRow(objTable, nCurPos);
				changePosition(objCurRow, nCurPos-1, SlotId);											
			}
		}
	
	
		function addFields(SlotId)
		{
			strDestinationId = "AttachedFields_"+SlotId;
			strSourceId = "AvailableFields_"+SlotId;
			
			objSourceTable = document.getElementById(strSourceId);
			objDestinationTable = document.getElementById(strDestinationId);
			
			//--- get last position in destination table
			nLastPos = getLastPosition(objDestinationTable);
			for (i=0; i <objSourceTable.childNodes.length; i++)
			{
				nCheckboxPos = getPosOfType(objSourceTable.childNodes[i].childNodes, "TD", 1);
				if (-1 != nCheckboxPos)
				{
					if (objSourceTable.childNodes[i].childNodes[nCheckboxPos])
					{
						if (objSourceTable.childNodes[i].childNodes[nCheckboxPos].firstChild.checked)
						{
							nID = objSourceTable.childNodes[i].childNodes[nCheckboxPos].firstChild.getAttribute("id");
							nNamePos = getLastOfType(objSourceTable.childNodes[i].childNodes, "TD");
							strFieldName = objSourceTable.childNodes[i].childNodes[nNamePos].innerHTML;
							
							bAddElement 	= true;
							var nMyLastPos 	= nLastPos;
							var nMyIndex 	= 0;
							do {
								strMyId = SlotId+"_"+nID+"_"+nMyLastPos;
								var test = document.getElementById(strMyId);
								
								if (test != null)
								{
									bAddElement = false;
								}							
								
								nMyLastPos--;
								nMyIndex++;
							} while (nMyLastPos > -1);
							
							if (bAddElement)
							{	
								//--- add element to table (as last item)
								nLastPos++;
								
								new_row=document.createElement("TR");
									first_cell=document.createElement("TD");
										first_cell.setAttribute("style", "border-top:1px solid Silver;");
										first_cell.setAttribute("width", "20px");
										first_cell.appendChild(document.createTextNode(nLastPos));
									new_row.appendChild(first_cell);
									
									second_cell=document.createElement("TD");
										second_cell.appendChild(createImage("../images/textfield_rename.gif", 16, 16));
										second_cell.setAttribute("style", "border-top:1px solid Silver;");
										second_cell.setAttribute("width", "20px");
									new_row.appendChild(second_cell);
									
									third_cell=document.createElement("TD");
										third_cell.appendChild(document.createTextNode(strFieldName));							
										third_cell.setAttribute("style", "border-top:1px solid Silver;");
									new_row.appendChild(third_cell);
									
									forth_cell=document.createElement("TD");
										forth_cell.setAttribute("style", "border-top:1px solid Silver;");
										forth_cell.setAttribute("align", "right");
										forth_cell.setAttribute("width", "80px");								
										
										strUrl = "javascript:remove("+SlotId+","+nLastPos+")";
										href = createHref(strUrl, "", "");
										href.appendChild(createImage("../images/edit_remove.gif", 16, 16));
										forth_cell.appendChild(href);
										
										strNewId = SlotId+"_"+nID+"_"+nLastPos;
										hidden_field = document.createElement("INPUT");
											hidden_field.setAttribute("type", "hidden");
											hidden_field.setAttribute("id", strNewId);
											hidden_field.setAttribute("name", strNewId);
											hidden_field.setAttribute("value", strNewId);
										forth_cell.appendChild(hidden_field);
									new_row.appendChild(forth_cell);
									
								objDestinationTable.appendChild(new_row);								
							}
							else
							{
								alert ('<?php echo str_replace("'", "\'", $WARNING_FIELD_ALREADY_ADDED); ?>');
							}
							
							//new: deselects the checkbox after adding it to the field
							objSourceTable.childNodes[i].childNodes[nCheckboxPos].firstChild.checked = false;
						}
					}
				}
			}
							
		}
		
		function createHref(strUrl, strTarget, strAlt)
		{
			href = document.createElement("A");
			href.setAttribute("href", strUrl);
			href.setAttribute("target", strTarget);
			href.setAttribute("alt", strAlt);
			
			return href;
		}
		
		function createImage(strPath, nWidth, nHeight)
		{
			img = document.createElement("IMG");
			img.setAttribute("src", strPath);
			img.setAttribute("height", nHeight);
			img.setAttribute("width", nWidth);		
			img.setAttribute("border", 0);
				
			return img;
		}
		
		function getLastPosition(objTable)
		{	
			nLastPos = 0;		
			nTrPos = getLastOfType(objTable.childNodes, "TR");
			
			if (-1 != nTrPos)
			{
				nTdPos = getPosOfType(objTable.childNodes[nTrPos].childNodes, "TD", 1); 
				
				if (-1 != nTdPos)
				{
					nLastPos = parseInt(objTable.childNodes[nTrPos].childNodes[nTdPos].innerHTML);
				}
			}
			
			return nLastPos;
		}
		
		function findRow (objTable, nPosition)
		{
			
			for (x = 0; x < objTable.childNodes.length; x++)
			{
				if (objTable.childNodes[x].nodeName == "TR")
				{
					nPos = getPosOfType(objTable.childNodes[x].childNodes, "TD", 1);
					objTd = objTable.childNodes[x].childNodes[nPos];
					
					if (objTd.innerHTML == nPosition)
					{
						return objTable.childNodes[x];
					}
				}
			}
			
			
		}
		
		function getPosOfType(objCollection, strTag, Pos)
		{
			nTempPos = 0;
			for (iPos = 0; iPos < objCollection.length; iPos++)
			{
				if (objCollection[iPos].nodeName == strTag)
				{
					nTempPos++;
					
					if (nTempPos == Pos)
					{		
						return iPos;
					}
				}		
			}
			
			return -1;
		}
		
		function getLastOfType(objCollection, strTag)
		{
			for (ilPos = objCollection.length-1; ilPos >= 0; ilPos--)
			{
				if (objCollection[ilPos].nodeName == strTag)
				{
					return ilPos;
				}
			}
			
			return -1;
		}
	//-->
	</script>
	
	<script type="text/javascript; version=1.5">
		Node.prototype.swapNode = function (node) 
		{
  			var nextSibling = this.nextSibling;
  		  	var parentNode = this.parentNode;
			node.parentNode.replaceChild(this, node);
			parentNode.insertBefore(node, nextSibling);  
		}
	</script>
</head>
<body><br>
<span style="font-size: 14pt; color: #ffa000; font-family: Verdana; font-weight: bold;">
	<?php echo $MENU_TEMPLATE;?>
</span><br><br>

	<form action="edittemplate_write.php" id="EditTemplate" name="EditTemplate">
		<table width="80%" cellspacing="0" cellpadding="3">
			<tr>
				<td>
					<?php echo $TEMPLATE_EDIT3_HEADER;?>
				</td>
			</tr>
    	</table>
		
		<table width="620" style="border: 1px solid #c8c8c8; background: #efefef;" cellspacing="0" cellpadding="3">
			<?php
				$nSlotNumber = 1;
				foreach ($arrSlots as $arrSlot)
				{
					?>
					<tr>
						<td colspan="5" style="background-color:gray; color:White; font-weight: bold;">
							<?php echo $MAILLIST_EDIT_FORM_SLOT." $nSlotNumber: ".$arrSlot["strName"]; ?>
						</td>
					</tr>
					<tr>
						<td>
						<table>
							<td valign="top" width="300px">
								<?php echo $TEMPLATE_EDIT3_ASSIGNED_FIELDS;?>								
								<table cellpadding="2" cellspacing="0" class="BorderSilver" style="background-color:white;" width="100%">
									<thead style="background-color:Silver;">
										<td width="47px"><?php echo $TEMPLATE_EDIT3_POS;?></td>
										<td colspan="2"><?php echo $TEMPLATE_EDIT3_NAME;?></td>
										<td>&nbsp;</td>
									</thead>
								</table>
								<div style="height:100px;overflow:auto;">
									<table cellpadding="2" cellspacing="0" class="BorderSilver" style="background-color:white;" width="100%">
										<tbody id="AttachedFields_<?php echo $arrSlot["nID"];?>">
											<?php
												//--- open database
   												$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
   												if ($nConnection)
   												{
													//--- get maximum count of users
	   												if (mysql_select_db($DATABASE_DB, $nConnection))
		   											{
														$strQuery = "SELECT * FROM cf_slottofield WHERE nSlotId=".$arrSlot["nID"];
											    		$nResult = mysql_query($strQuery, $nConnection);
											    		if ($nResult)
											    		{
											    			if (mysql_num_rows($nResult) > 0)
											    			{
																$nRunningNumber = 1;
											    				while (	$arrRow = mysql_fetch_array($nResult))
											    				{
																	$arrField = $arrFields[$arrRow["nFieldId"]];
																	echo "<tr>\n";
																	
																	echo "<td width=\"20px\" style=\"border-top:1px solid Silver;\">".$nRunningNumber."</td>\n";
																	echo "<td width=\"20px\" style=\"border-top:1px solid Silver;\"><img src=\"../images/textfield_rename.gif\" height=\"16\" width=\"16\"></td>\n";
																	echo "<td style=\"border-top:1px solid Silver;\">".$arrField["strName"]."</td>\n";
																	
																	$s2uid = $arrSlot["nID"]."_".$arrField["nID"]."_".$nRunningNumber;
																	echo" <td style=\"border-top:1px solid Silver;\" width=\"80px\" align=\"right\">";
																	echo "<a href=\"javascript:remove(".$arrSlot["nID"].", ".$nRunningNumber.")\"><img border=\"0\" src=\"../images/edit_remove.gif\" height=\"16\" width=\"16\"></a>";
																	echo "<input type=\"hidden\" name=\"$s2uid\" id=\"$s2uid\" value=\"$s2uid\">";
																	echo "</td>\n";
																	echo "</tr>\n";
																	
																	$nRunningNumber++;
																}
															}
														}
													}
												}
											?>											
										</tbody>
									</table>								
								</div>
							</td>
							<td valign="top">
								<br>
								<br>	
								<input type="button" class="Button" value="<?php echo $BTN_ADD;?>" onclick="addFields('<?php echo $arrSlot["nID"];?>')">
							</td>
							<td valign="top" width="300px">
								<?php echo $TEMPLATE_EDIT3_AVAILABLE_FIELDS;?>
								<table cellpadding="2" cellspacing="0" class="BorderSilver" style="background-color:white;" width="100%">
									<thead style="background-color:Silver;">
										<td colspan>&nbsp;</td>
										<td colspan>&nbsp;</td>
										<td colspan><?php echo $TEMPLATE_EDIT3_NAME;?>:</td>
									</thead>
								</table>
								<div style="height:100px;overflow:auto;">
									<table cellpadding="2" cellspacing="0" class="BorderSilver" style="background-color:white;" width="100%">
										<tbody id="AvailableFields_<?php echo $arrSlot["nID"];?>">
										<?php
											foreach ($arrFields as $arrField)
											{
												$sid = $arrField["nID"];
												echo "<tr>\n";
												echo "<td width=\"16px\" style=\"border-top:1px solid Silver;\" valign=\"middle\"><input type=\"checkbox\" id=\"$sid\" name=\"$sid\" value=\"$sid\"></td>\n";
												echo "<td width=\"20px\" style=\"border-top:1px solid Silver;\" valign=\"middle\"><img src=\"../images/textfield_rename.gif\" height=\"16\" width=\"16\"></td>\n";
												echo "<td style=\"border-top:1px solid Silver;\" valign=\"middle\">".$arrField["strName"]."</td>\n";
												echo "</tr>\n";
											}
										?>
										</tbody>
									</table>
								</div>
							</td>
						</table>							
					<?php
					
					echo "</tr>\n";
					$nSlotNumber++;
				}
			?>
		</table>
		<table cellspacing="0" cellpadding="3" align="left" width="620">
		<tr>
			<td align="left">
				<input type="button" class="Button" value="<?php echo $BTN_BACK;?>" onclick="back()">
			</td>
			<td align="right">
				<input type="submit" value="<?php echo $BTN_OK;?>" class="Button">
			</td>
		</tr>
		</table>		
		
	<input type="hidden" value="<?php echo $_REQUEST["language"];?>" id="language" name="language">
	<input type="hidden" value="<?php echo $_REQUEST["sort"];?>" id="sort" name="sort">
	<input type="hidden" value="<?php echo $_REQUEST["start"];?>" id="start" name="start">
	<input type="hidden" value="<?php echo $_REQUEST["templateid"];?>" id="templateid" name="templateid">
	</form>

</body>
</html>