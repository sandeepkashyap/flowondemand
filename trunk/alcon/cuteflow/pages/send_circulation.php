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
	
	include ("../lib/htmlMimeMail.php");
	include_once ("../config/config.inc.php");
	include ("../lib/mimetype.php");
	include ("../pages/version.inc.php");
	include_once ("../language_files/language.inc.php");
	
	
	function getNextUserInList($nCurUserId, $nMailingListId, $nSlotId)
	{
		global $DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD, $DATABASE_DB;
		
		$arrUserInfo = array();
		
		$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
		$nConnection2 = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
		
		if ( ($nConnection) && ($nConnection2) ) 
		{
			if (mysql_select_db($DATABASE_DB, $nConnection))
			{
				mysql_select_db($DATABASE_DB, $nConnection2);
				
				$strQuery = "SELECT * FROM cf_slottouser INNER JOIN cf_formslot ON cf_slottouser.nSlotId  = cf_formslot.nID WHERE cf_slottouser.nMailingListId=$nMailingListId ORDER BY cf_formslot.nSlotNumber ASC, cf_slottouser.nPosition ASC";
				$nResult = mysql_query($strQuery, $nConnection);
				
        		if ($nResult)
        		{
        			if (mysql_num_rows($nResult) > 0)
        			{
						$bFoundOne == false;
        				while (	$arrRow = mysql_fetch_array($nResult))
        				{
        					if ($nCurUserId == -1)
							{
								//--- lets take the first user
								$arrUserInfo[0] = $arrRow["nUserId"];
								$arrUserInfo[1] = $arrRow["nSlotId"];
								
								return $arrUserInfo;
							}
							else if ($bFoundOne == true)
							{
								$arrUserInfo[0] = $arrRow["nUserId"];
								$arrUserInfo[1] = $arrRow["nSlotId"];
								
								return $arrUserInfo;
							}
							else
							{
								if ( ($arrRow["nUserId"] == $nCurUserId) && 
										($arrRow["nSlotId"] == $nSlotId))
								{
									$bFoundOne = true; //--- next loop returns user	
								}
							}
						}
					}
				}
			}
		}
		
		return $arrUserInfo;
	}

	function sendToUser($nUserId, $nCirculationId, $nSlotId, $nCirculationProcessId, $nCirculationHistoryId, $tsDateInProcessSince = '')
	{
		global $DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD, $DATABASE_DB, $MAIL_HEADER_PRE, $CUTEFLOW_SERVER;
		global $SMTP_SERVER, $SMTP_PORT, $SMTP_USERID, $SMTP_PWD, $SMTP_USE_AUTH;
		global $SYSTEM_REPLY_ADDRESS, $CUTEFLOW_VERSION, $TStoday, $objURL;
		
		global $CUTEFLOW_SERVER, $CUTEFLOW_VERSION, $EMAIL_BROWSERVIEW, $MAIL_LINK_DESCRIPTION, $MAIL_HEADER_PRE;
		global $CIRCULATION_DONE_MESSSAGE_REJECT, $CIRCULATION_DONE_MESSSAGE_SUCCESS, $CIRCDETAIL_SENDER, $CIRCDETAIL_SENDDATE, $MAIL_ADDITION_INFORMATIONS;
		
		$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
		if ($nConnection)
		{
			if (mysql_select_db($DATABASE_DB, $nConnection))
			{	
				$mail = new htmlMimeMail();
				$mail->setSMTPParams($SMTP_SERVER, $SMTP_PORT, NULL, $SMTP_USE_AUTH, $SMTP_USERID, $SMTP_PWD);
				
				//------------------------------------------------------
				//--- get the needed informations
				//------------------------------------------------------
				
				//--- circulation form
				$arrForm = array();
				$strQuery = "SELECT * FROM cf_circulationform WHERE nID=$nCirculationId";
				$nResult = mysql_query($strQuery, $nConnection);
				if ($nResult)
	    		{
	    			if (mysql_num_rows($nResult) > 0)
	    			{
	    				$arrForm = mysql_fetch_array($nResult);
					}
				}
				
				//--- circulation history
				$arrHistory = array();
				$strQuery = "SELECT * FROM cf_circulationhistory WHERE nID=$nCirculationHistoryId";
				$nResult = mysql_query($strQuery, $nConnection);
				if ($nResult)
	    		{
	    			if (mysql_num_rows($nResult) > 0)
	    			{
	    				$arrHistory = mysql_fetch_array($nResult);
					}
				}
				
				//--- the attachments
				$strQuery = "SELECT * FROM cf_attachment WHERE nCirculationHistoryId=$nCirculationHistoryId";
				$nResult = mysql_query($strQuery, $nConnection);
	    		if ($nResult)
	    		{
	    			if (mysql_num_rows($nResult) > 0)
	    			{
	    				while (	$arrRow = mysql_fetch_array($nResult))
	    				{
							$attachment = $mail->getFile($arrRow["strPath"]);
							
							$arrPathParts = split("[/\]", $arrRow["strPath"]);        
					        $strFileName = $arrPathParts[sizeof($arrPathParts)-1];
							
							$mimetype = new mimetype();
					      	$filemime = $mimetype->getType($strFileName);
							
							$mail->addAttachment($attachment, $strFileName, $filemime);							
						}
					}
				}
				
				//------------------------------------------------------
				//--- update status in circulationprocess table
				//------------------------------------------------------				
				if ($tsDateInProcessSince == '')
				{
					$strQuery = "INSERT INTO cf_circulationprocess values (null, $nCirculationId, $nSlotId, $nUserId, $TStoday, 0, 0, $nCirculationProcessId, $nCirculationHistoryId)";
					mysql_query($strQuery, $nConnection) or die ($strQuery.mysql_error());
				}
				else
				{
									//( `nID` , `nCirculationFormId` , `nSlotId`, `nUserId` , `dateInProcessSince` , `nDecissionState`, `dateDecission` , `nIsSubstitiuteOf` , `nCirculationHistoryId`)
					$strQuery = "INSERT INTO cf_circulationprocess values (null, $nCirculationId, $nSlotId, $nUserId, $tsDateInProcessSince, 0, 0, 0, $nCirculationHistoryId)";
					mysql_query($strQuery, $nConnection) or die ($strQuery.mysql_error());
				}
				
				//------------------------------------------------------
				//--- generate email message
				//------------------------------------------------------				
				$strQuery = "SELECT nID FROM cf_circulationprocess WHERE nSlotId=$nSlotId AND nUserId=$nUserId AND nCirculationFormId=$nCirculationId AND nCirculationHistoryId=$nCirculationHistoryId";
				$nResult = mysql_query($strQuery, $nConnection);
	    		if ($nResult)
	    		{
	    			if (mysql_num_rows($nResult) > 0)
	    			{
	    				$arrLastRow = array();
	    				
	    				while ($arrRow = mysql_fetch_array($nResult))
	    				{
	    					$arrLastRow = $arrRow;
	    				}
						$Circulation_cpid = $arrLastRow[0];
					}
				}				
				
				//switching Email Format
				if ($nUserId != -2)
				{	
					$strQuery = "SELECT strEmail_Format, strEmail_Values FROM `cf_user` WHERE nID = $nUserId;";
				}
				else
				{	// in this case the next user is the sender of this circulation
					$strQuery = "SELECT strEmail_Format, strEmail_Values FROM `cf_user` WHERE nID = ".$arrForm['nSenderId'].";";
				}
				$nResult = mysql_query($strQuery, $nConnection);
				if ($nResult)
	    		{
		    		$arrMailFormat = mysql_fetch_array($nResult);
		    		$strMyMailFormat = $arrMailFormat[0].$arrMailFormat[1];
		    		$Circulation_Name = $arrForm["strName"];
					$Circulation_AdditionalText = str_replace("\n", "<br>", $arrHistory["strAdditionalText"]);
    				
    				//--- create mail
					include ("../mail/mail_".$strMyMailFormat.".inc.php");

					switch ($arrMailFormat[0])
					{
						case PLAIN:
							$mail->setText($strMessage);
							break;
						case HTML:
							$mail->setHtml($strMessage);
							break;
	    			}		    		
	    		}				
				
				//------------------------------------------------------
				//--- send email to user
				//------------------------------------------------------
				if ($nUserId != -2)
				{
					$strQuery = "SELECT * FROM cf_user WHERE nID = $nUserId";
				}
				else
				{	// in this case the next user is the sender of this circulation
					$strQuery = "SELECT * FROM cf_user WHERE nID = ".$arrForm['nSenderId']."";
				}
				$nResult = mysql_query($strQuery, $nConnection);
        		if ($nResult)
        		{
        			if (mysql_num_rows($nResult) > 0)
        			{
						$arrRow = mysql_fetch_array($nResult);
						$SYSTEM_REPLY_ADDRESS = str_replace (' ', '_', $SYSTEM_REPLY_ADDRESS);
						
						$mail->setFrom($SYSTEM_REPLY_ADDRESS);
						$mail->setSubject($MAIL_HEADER_PRE.$arrForm["strName"]);
						$mail->setHeader('X-Mailer', 'CuteFlow Document Workflow System');
						$mail->setHeader('Date', date('D, d M y H:i:s O'));
						
						$result = $mail->send(array($arrRow["strEMail"]), 'smtp');
						if (!$result)
						{
							$fp = fopen ("mailerror.log", "a");
							if ($fp)
							{
								fputs ($fp, date("d.m.Y", time())." - sendToUser\n");
								foreach ($mail->errors as $output)
								{
									fputs($fp, $output."\n");
								}
								
								fclose($fp);
							}
						}
						else
						{
							return true;
						}
					}
				}
			}
		}
		
		return false;
	}
	
	function sendMessageToSender($nSenderId, $nLastStationId, $strMessageFile, $strCirculationName, $strEndState, $Circulation_cpid)
	{
		global $DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD, $DATABASE_DB, $MAIL_HEADER_PRE, $CUTEFLOW_SERVER;
		global $SMTP_SERVER, $SMTP_PORT, $SMTP_USERID, $SMTP_PWD, $SMTP_USE_AUTH, $MAIL_ENDACTION_DONE_REJECT, $MAIL_ENDACTION_DONE_SUCCESS;
		global $SYSTEM_REPLY_ADDRESS, $CIRCULATION_DONE_MESSSAGE_REJECT, $CIRCULATION_DONE_MESSSAGE_SUCCESS, $CUTEFLOW_VERSION;
		
		global $CUTEFLOW_SERVER, $CUTEFLOW_VERSION, $EMAIL_BROWSERVIEW, $MAIL_LINK_DESCRIPTION, $MAIL_HEADER_PRE;
		global $CIRCULATION_DONE_MESSSAGE_REJECT, $CIRCULATION_DONE_MESSSAGE_SUCCESS, $CIRCDETAIL_SENDER, $CIRCDETAIL_SENDDATE, $MAIL_ADDITION_INFORMATIONS, $objURL;
		
		$nConnection = mysql_connect($DATABASE_HOST, $DATABASE_UID, $DATABASE_PWD);
		if ($nConnection)
		{
			if (mysql_select_db($DATABASE_DB, $nConnection))
			{	
				$mail = new htmlMimeMail();
				$mail->setSMTPParams($SMTP_SERVER, $SMTP_PORT, NULL, $SMTP_USE_AUTH, $SMTP_USERID, $SMTP_PWD);
				
				//switching Email Format
				$strQuery = "SELECT strEmail_Format, strEmail_Values FROM `cf_user` WHERE nID = $nSenderId;";
				$nResult = mysql_query($strQuery, $nConnection) or die ("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $strQuery . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());
				if ($nResult)
	    		{
		    		$arrMailFormat = mysql_fetch_array($nResult);
		    		
		    		$strMyMailFormat = $arrMailFormat["strEmail_Format"];
		    		   	
    				//--- create mail
    				//include ("../language_files/language.inc.php");
					include ("../mail/mail_".$strMyMailFormat."_done.inc.php");					
	    					
					switch ($strMyMailFormat)
					{
						case PLAIN:
							$mail->setText($strMessage);
							break;
						case HTML:
							$mail->setHtml($strMessage);
							break;
	    			}
	    		}
								
				$strQuery = "SELECT * FROM cf_user WHERE nID = $nSenderId";
				$nResult = mysql_query($strQuery, $nConnection);
        		if ($nResult)
        		{
        			if (mysql_num_rows($nResult) > 0)
        			{
						$arrRow = mysql_fetch_array($nResult);
				
						$mail->setFrom($SYSTEM_REPLY_ADDRESS);
						
						eval ("\$strEndSubject = \"\$MAIL_ENDACTION_DONE_$strEndState\";");
						$mail->setSubject($MAIL_HEADER_PRE.$strCirculationName.$strEndSubject);
						$mail->setHeader('X-Mailer', 'CuteFlow Document Workflow System');
						$mail->setHeader('Date', date('D, d M y H:i:s O'));
						$result = $mail->send(array($arrRow["strEMail"]), 'smtp');
						if (!$result) 
						{
						    $fp = fopen ("../mailerror.log", "a");
							if ($fp)
							{
								fputs ($fp, date("d.m.Y", time())." - sendMessageToSender\n");
								foreach ($mail->errors as $output)
								{
									fputs($fp, $output."\n");
								}
								
								fclose($fp);
							}
						}
						else
						{
							return true;
						}
					}
				}
			}
		}
	}
?>