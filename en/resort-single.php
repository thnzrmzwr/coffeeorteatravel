<?php include 'partials/templates.php';
//include($_SERVER['DOCUMENT_ROOT']."ipcheck.php");
if(isset($_GET['resortid']) && !empty($_GET['resortid'])){
    $id = $_GET['resortid'];
	$countryName = strtolower($_GET['country']);
    if($countryName=='maldives'){
      $country=121;
    }else{
      $country =183;
    }

}else{
    exit;
}

//=========form handler start================
if (isset( $_POST ["fldCustomerFormArrivalDate"] )) {
	$_POST ["ArrivalYear"] = date ( "Y", strtotime ( $_POST ["fldCustomerFormArrivalDate"] ) );
	$_POST ["ArrivalMonth"] = date ( "m", strtotime ( $_POST ["fldCustomerFormArrivalDate"] ) );
	$_POST ["ArrivalDay"] = date ( "d", strtotime ( $_POST ["fldCustomerFormArrivalDate"] ) );
}

if(isset($_POST['Submit'])){
	$isset=true;
	if (($_POST["ArrivalYear"])&&(
	$_POST["ArrivalMonth"])&&(
	$_POST["ArrivalDay"])&&(
	$_POST["fldCustomerFormNights"])&&(
	$_POST["fldCustomerFormRooms"])&&(
	$_POST["fldCustomerFormBudget"])&&(
	$_POST["fldCustomerFormTypeOFHoliday"])&&(
	$_POST["fldCustomerFormResort1ID"])&&(
	$_POST["fldCustomerFormResort1VillaID"])&&(
	$_POST["fldCustomerTitle"])&&(
	$_POST["fldCustomerFName"])&&(
	//$_POST["fldCustomerLName"])&&(
	$_POST["fldCustomerEMail"])&&(
	$_POST["fldCustomerCountryOfResidence"])&&(
	//$_POST["fldCustomerCityOfResidence"])&&(
	$_POST["fldCustomerFormMessage"])){
		echo 'passed';
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		$text = $_POST["fldCustomerFormMessage"];
		// if(preg_match($reg_exUrl, $text, $url)) {
		// 	header("Location: $DOMAIN/resort-reservations.html");
		// 	exit;
		// }

		$fldCustomerFormDestinationID=1; //Maldives Holiday
		//include($_SERVER["DOCUMENT_ROOT"]."/config/include_spamer_security.php");
		include($_SERVER["DOCUMENT_ROOT"]."/phpmailer/class.phpmailer.php");
		include($_SERVER["DOCUMENT_ROOT"]."/phpmailer/class.smtp.php");
		include($_SERVER["DOCUMENT_ROOT"]."/phpmailer/class.emailseparater.php");

		$spiltObj = new emailSeparate();
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPDebug=0;
		$mail->SMTPAuth=$smtpArray['Auth'];		//true;
		$mail->SMTPSecure = $smtpArray['Secure'];	//"tls";
		$mail->Host= $smtpArray['Host'];		//"smtp.gmail.com";
		$mail->Port= $smtpArray['Port'];		//587;
		$mail->Username= $MYFROM_EMAIL;			//"sales";
		$mail->Password= SafMyBase64Decode($MYFROM_EMAIL_P);		//"";
		//	$mail->AddAttachment($_SERVER["DOCUMENT_ROOT"]."/logos/$SignatureLogoName", "$SignatureLogoName");

		$fldCustomerTitle = $_POST["fldCustomerTitle"];
		$fldCustomerFName = ConvertMakeAjexFriendly($_POST["fldCustomerFName"]);
		$fldCustomerLName = ConvertMakeAjexFriendly($_POST["fldCustomerLName"]);
		$fldCustomerEMail = $_POST["fldCustomerEMail"];
		$fldCustomerCountryOfResidence = $_POST["fldCustomerCountryOfResidence"];
		$fldCustomerCityOfResidence = ConvertMakeAjexFriendly($_POST["fldCustomerCityOfResidence"]);
		$fldCustomerMobilePhone = ConvertMakeAjexFriendly($_POST["fldCustomerMobilePhone"]);
		$fldCustomerHomePhone = ConvertMakeAjexFriendly($_POST["fldCustomerHomePhone"]);

		$Error = $Error . '<li>This is not an error: '.$Submit.'</li>';
		/////////////////////////////////////////////////////////////////////////////// CUSTOMER TABLE
		$sql = "SELECT fldCustomerID,fldCustomerTitle,fldCustomerFName,fldCustomerLName,fldCustomerStatus,fldCustomerEmailVerified,fldCustomerEmailVerificationID FROM tblCustomer WHERE fldCustomerEMail='".mysql_real_escape_string($fldCustomerEMail)."'";
		$result = mysql_query($sql, $db_elegantp);
		$rows = mysql_num_rows($result);
		if(mysql_num_rows($result)) {
			$data=mysql_fetch_object($result);
			$fldCustomerID=$data->fldCustomerID;
			$fldCustomerTitle=$data->fldCustomerTitle;
			$fldCustomerFName=$data->fldCustomerFName;
			$fldCustomerLName=$data->fldCustomerLName;
			$fldCustomerStatus=$data->fldCustomerStatus;
			$fldCustomerEmailVerificationID=$data->fldCustomerEmailVerificationID;
			$fldCustomerEmailVerified=$data->fldCustomerEmailVerified;
		}else{
			$fldCustomerIP= GetGeoInfo($DOCUMENT_ROOT,$DOMAIN,'','IPAdress');
			$fldCustomerDate=date('Y-m-d');
			$fldCustomerDateTime=date('Y-m-d H:i:s');
			$MD5Text=date('YmdHis').$fldCustomerEMail;
			$fldCustomerEmailVerificationID=md5($MD5Text);

			$sql = "INSERT INTO tblCustomer ";
			$sql .= "(fldCustomerEmailVerificationID,fldCustomerDateTime,fldCustomerDate,fldCustomerIP,fldCustomerWorkPhone,fldCustomerMobilePhone,fldCustomerHomePhone,fldCustomerEMail,fldCustomerCityOfResidence,fldCustomerCountryOfResidence,fldCustomerLName,fldCustomerFName,fldCustomerTitle)";
			$sql .= "VALUES('$fldCustomerEmailVerificationID','$fldCustomerDateTime','$fldCustomerDate','$fldCustomerIP','$fldCustomerWorkPhone','$fldCustomerMobilePhone','$fldCustomerHomePhone','$fldCustomerEMail','$fldCustomerCityOfResidence','$fldCustomerCountryOfResidence','$fldCustomerLName','$fldCustomerFName','$fldCustomerTitle')";
			$result = mysql_query($sql, $db_elegantp);

			$sql_Customer = "SELECT fldCustomerID,fldCustomerTitle,fldCustomerFName,fldCustomerLName,fldCustomerEmailVerificationID,fldCustomerEmailVerified FROM tblCustomer WHERE fldCustomerEMail='".mysql_real_escape_string($fldCustomerEMail)."'";
			$result_Customer = mysql_query($sql_Customer, $db_elegantp);
			$rows_Customer = mysql_num_rows($result_Customer);
			if(mysql_num_rows($result_Customer)) {
				$data_Customer=mysql_fetch_object($result_Customer);
				$fldCustomerID=$data_Customer->fldCustomerID;
				$fldCustomerTitle=$data_Customer->fldCustomerTitle;
				$fldCustomerFName=$data_Customer->fldCustomerFName;
				$fldCustomerLName=$data_Customer->fldCustomerLName;
				$fldCustomerEmailVerificationID=$data_Customer->fldCustomerEmailVerificationID;
				$fldCustomerEmailVerified=$data_Customer->fldCustomerEmailVerified;
			}else{
				$Error = $Error . 'Problem with adding your information to databse';
			}
		}
		////////////////////////////////////////////////////////////////////// SENT EMAIL START
		///////////////////////////////
		$today = date("Y-m-d H:i:s");
		$vartext='';
		$vartext =$vartext.'<div align="center">
							<table border="1" width="650" cellpadding="4" style="border-collapse: collapse" bordercolor="#a58454" bgcolor="#FFFFFF">
								<tr>
									<td bgcolor="#FFFFFF">
										<table border="0" width="100%" cellpadding="4" style="border-collapse: collapse">
											<tr>
												<td colspan="3" style="font-family: Arial; font-size: 10pt; color: #a58454" align="right">
													<b>Inquiry received on: '.SafDateTim02($today).'</b></td>
											</tr>
											<tr>
												<td colspan="3" style="border-top: 1px solid #a58454; border-bottom: 1px solid #a58454; background-color: #a58454">
													<b>
														<font face="Arial" size="2">PRIMARY INFORMATION</font>
													</b></td>
											</tr>
											<tr>
												<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="315" height="40">
													<font size="2" color="#a58454">Name: '.$fldCustomerFName.'</font>
												</td>
												<td align="left" width="20" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" height="40"> </td>
												<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="315" height="40">
													<font size="2" color="#a58454">Mobile phone: '.$fldCustomerMobilePhone.'</font>
												</td>
											</tr>
											<tr>
												<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="315" height="40">
													<font size="2" color="#a58454">Email: '.$fldCustomerEMail.'</font>
												</td>
												<td align="left" width="20" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" height="40">&nbsp;</td>
												<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="315" height="40">
													<font size="2" color="#a58454">Passport issued country: '.GetCountryName($db_elegantp,$fldCustomerCountryOfResidence).'</font>
												</td>
											</tr>
										</table>
										<table border="0" width="100%" cellpadding="4" style="border-collapse: collapse">
											<tr>
												<td style="font-family: Arial; font-size: 10pt; color: #a58454" align="right">&nbsp;</td>
											</tr>
										</table>
										<table border="0" width="100%" cellpadding="4" style="border-collapse: collapse">
											<tr>
												<td colspan="3" style="border-top: 1px solid #a58454; border-bottom: 1px solid #a58454; background-color: #a58454">
													<b>
														<font face="Arial" size="2">DESTINATION INFORMATION</font>
													</b></td>
											</tr>
											<tr>
												<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="315" height="40">
													<font size="2" color="#a58454">Resort 1: '.GetProductName($db_elegantp,$fldCustomerFormResort1ID).'</font>
												</td>
												<td align="left" width="20" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" height="40">&nbsp;</td>
												<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="315" height="40">
													<font size="2" color="#a58454">Resort 1 room category: '.GetRoomType($db,$fldCustomerFormResort1VillaID).'</font>
												</td>
											</tr>
										</table>
										<table border="0" width="100%" cellpadding="4" style="border-collapse: collapse">
											<tr>
												<td colspan="3" style="font-family: Arial; font-size: 10pt; color: #a58454" align="right">&nbsp;</td>
											</tr>
											<tr>
												<td colspan="3" style="border-top: 1px solid #a58454; border-bottom: 1px solid #a58454; background-color: #a58454">
													<b>
														<font face="Arial" size="2">HOLIDAY INFORMATION</font>
													</b></td>
											</tr>
											<tr>
												<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="315" height="40">
													<font size="2" color="#a58454">Arrival date: '.SafDate5V2($ArrivalDate).'</font>
												</td>
												<td align="left" width="20" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" height="40">&nbsp;</td>
												<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="315" height="40">
													<font size="2" color="#a58454">No. of nights: '.$Nights.'</font>&nbsp;
												</td>
											</tr>
											<tr>
												<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="315" height="40">
													<font size="2" color="#a58454">Holiday type: '.$fldCustomerFormTypeOFHoliday.'</font>
												</td>
												<td align="left" width="20" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" height="40">&nbsp;</td>
												<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="315" height="40">
													<font size="2" color="#a58454">No. of room(s): '.$fldCustomerFormRooms.'</font>&nbsp;
												</td>
											</tr>                                        
											<tr>
												<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="top" width="315" height="40">
													<table border="1" width="100%" style="border-collapse: collapse" bordercolor="#a58454" height="100">
														<tr>
															<td bgcolor="#F7F7F7" align="center">
																<table border="0" cellpadding="4" style="border-collapse: collapse">
																	<tr>
																		<td align="center" colspan="2">
																			<font color="#a58454" size="2">Child age: 2-12
																				years, Infant age: 0-2 years</font>
																		</td>
																	</tr>
																	<tr>
																		<td align="right" style="font-family: Arial; font-size: 8pt">Pax: Adults '.$fldCustomerFormPaxRoomsAdult.', Child'.$fldCustomerFormPaxRoomsChild.', Infant'.$fldCustomerFormPaxRoomsInfant.'</td>
																		<td align="left" nowrap>&nbsp;</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
												<td align="left" width="20" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" height="40">&nbsp;</td>
												<td align="right" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="top" width="315" height="40">
													<table border="1" width="100%" style="border-collapse: collapse" bordercolor="#a58454" height="100">
														<tr>
															<td bgcolor="#F7F7F7" align="center">
																<table border="0" cellpadding="4" style="border-collapse: collapse">
																	<tr>
																		<td align="center" colspan="2">
																			<font size="2" color="#a58454">Travel period</font>
																		</td>
																	</tr>
																	<tr>
																		<td align="right" style="font-family: Arial; font-size: 8pt">
																			<b>Arrival Date: '.SafDate5V2($ArrivalDate).'</b></td>
																		<td align="left" style="font-family: Arial; font-size: 8pt">
																			&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="right" style="font-family: Arial; font-size: 8pt">
																			<b>Departure Date: '.SafDate5V2($DepartureDate).'</b></td>
																		<td align="left" style="font-family: Arial; font-size: 8pt">
																			&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="right" style="font-family: Arial; font-size: 8pt">
																			<b>Nights: '.$Nights.'</b></td>
																		<td align="left" style="font-family: Arial; font-size: 8pt">
																			&nbsp;</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
										<table border="0" width="100%" cellpadding="4" style="border-collapse: collapse">
											<tr>
												<td style="font-family: Arial; font-size: 10pt; color: #a58454" align="right">&nbsp;</td>
											</tr>
											<tr>
												<td style="border-top: 1px solid #a58454; border-bottom: 1px solid #a58454; background-color: #a58454">
													<b>
														<font face="Arial" size="2">MESSAGE</font>
													</b></td>
											</tr>
											<tr>
												<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="650" height="40">
													<font size="2" color="#a58454">Message/special requests</font>
													<p align="justify">'.SafGetDoneBodyText($fldCustomerFormMessage,0,0).'</p>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div>';
		//$sentOk = mail($to,$subject,$message,$headers);
		$to_booking = 'info@coffeeorteatravel.com, info@nazcloak.com';
		$subject = 'Request From Ultra Luxury Maldives Website (RESERVATION)';
		$msg_booking = $vartext;

		// Make sure to escape quotes
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$fldCustomerFName.' <'.$CUSTOMEREMAIL.'>' . "\r\n";

		// Email to
		mail($to_booking, $subject, $msg_booking, $headers);
		////////////////////////////////////////////////////////////////////// SENT EMAIL END
			/////////////////////////////////////////////////////////////////////////////// ADDING AD DATA
		include($_SERVER["DOCUMENT_ROOT"]."/includes/include.record_ad_data.php");

		/////////////////////////////////////////////////////////////////////////////// CUSTOMER FORM TABLE
		if ($fldCustomerStatus!=9){ //9=SPAM but show like that we are adding the data
			$fldCustomerFormDateTime='';
			$sql_CustomerForm = "SELECT fldCustomerFormDateTime,fldCustomerID,fldCustomerFormID FROM tblCustomerForm WHERE fldCustomerID='".mysql_real_escape_string($fldCustomerID)."' ORDER BY fldCustomerFormID DESC";
			$result_CustomerForm = mysql_query($sql_CustomerForm, $db_elegantp);
			$rows_CustomerForm = mysql_num_rows($result_CustomerForm);
			if(mysql_num_rows($result_CustomerForm)) { //taking last enqury
				$data_CustomerForm=mysql_fetch_object($result_CustomerForm);
				$fldCustomerFormDateTime=$data_CustomerForm->fldCustomerFormDateTime;
				$fldCustomerID=$data_CustomerForm->fldCustomerID;
			}
			$Hours=1;
			if ($fldCustomerFormDateTime){
				$Hours=SafHoursDiff($fldCustomerFormDateTime);
			}
			if ($Hours>=1) { //if the previus enqury is more than 4 hour then only It will add to the db
				$fldCustomerID=$fldCustomerID;
				$fldCustomerFormIP=GetGeoInfo($DOCUMENT_ROOT,$DOMAIN,'','IPAdress');
				$fldCustomerFormDate=date('Y-m-d');
				$fldCustomerFormDateTime=date('Y-m-d H:i:s');
				$fldCustomerFormType=1; //Reservations
				$fldCustomerFormArrivalDate = $_POST["ArrivalYear"] .'-'. $_POST["ArrivalMonth"] .'-'. $_POST["ArrivalDay"];

				$ArrivalDate = $fldCustomerFormArrivalDate;
				$Nights = $fldCustomerFormNights;
				list($ArrivalYear,$ArrivalMonth,$ArrivalDay)=explode("-",$ArrivalDate);
				$DepartureDate=date('Y-m-d',mktime(0,0,0,$ArrivalMonth,$ArrivalDay+$Nights,$ArrivalYear));
										
				$fldCustomerFormNights = $_POST["fldCustomerFormNights"];
				$fldCustomerFormRooms = $_POST["fldCustomerFormRooms"];
				$fldCustomerFormBudget = $_POST["fldCustomerFormBudget"];
				$fldCustomerFormTypeOFHoliday = $_POST["fldCustomerFormTypeOFHoliday"];
				$fldCustomerFormResort1ID = $_POST["fldCustomerFormResort1ID"];
				$fldCustomerFormResort1VillaID = $_POST["fldCustomerFormResort1VillaID"];
				$fldCustomerFormResort2ID = $_POST["fldCustomerFormResort2ID"];
				$fldCustomerFormResort2VillaID = $_POST["fldCustomerFormResort2VillaID"];
				$fldCustomerFormMessage = ConvertMakeAjexFriendly($_POST["fldCustomerFormMessage"]);

				if ($fldCustomerID){
					$sql = "INSERT INTO tblCustomerForm ";
					$sql .= "(fldCustomerID,fldCustomerFormIP,fldCustomerFormDate,fldCustomerFormDateTime,fldCustomerFormType,fldCustomerFormArrivalDate,fldCustomerFormNights,fldCustomerFormRooms,fldCustomerFormBudget,fldCustomerFormTypeOFHoliday,fldCustomerFormResort1ID,fldCustomerFormResort1VillaID,fldCustomerFormResort2ID,fldCustomerFormResort2VillaID,fldCustomerFormMessage,fldCustomerFormDestinationID)";
					$sql .= "VALUES('$fldCustomerID','$fldCustomerFormIP','$fldCustomerFormDate','$fldCustomerFormDateTime','$fldCustomerFormType','$fldCustomerFormArrivalDate','$fldCustomerFormNights','$fldCustomerFormRooms','$fldCustomerFormBudget','$fldCustomerFormTypeOFHoliday','$fldCustomerFormResort1ID','$fldCustomerFormResort1VillaID','$fldCustomerFormResort2ID','$fldCustomerFormResort2VillaID','$fldCustomerFormMessage','$fldCustomerFormDestinationID')";
					$result = mysql_query($sql, $db_elegantp);
					$Error = $Error . '<li>This is not an error: Customer ID '.$fldCustomerID.'</li>';
				}else{
					$Error = $Error . '<li>Can not find your customer id in our database</li>';
				}
				$fldCustomerFormID=0;
				$sql_CustomerForm = "SELECT fldCustomerFormID FROM tblCustomerForm WHERE fldCustomerID='".mysql_real_escape_string($fldCustomerID)."' and fldCustomerFormDateTime='".mysql_real_escape_string($fldCustomerFormDateTime)."' ORDER BY fldCustomerFormID DESC";
				$result_CustomerForm = mysql_query($sql_CustomerForm, $db_elegantp);
				$rows_CustomerForm = mysql_num_rows($result_CustomerForm);
				if(mysql_num_rows($result_CustomerForm)) {
					$data_CustomerForm=mysql_fetch_object($result_CustomerForm);
					$fldCustomerFormID=$data_CustomerForm->fldCustomerFormID;
				}else{
					$Error = $Error . '<li>Can not find last added enquries</li>';
				}

				if ($fldCustomerFormID){
					/////////////////////////////////////////////////////////////////////////////// UPDATING AD DATA with fldCustomerFormID
					include($_SERVER["DOCUMENT_ROOT"]."/includes/include.record_ad_data.php");
					/////////////////////////////////////////////////////////////////////////////// ADDING CUSTOMER PAX TABLE
					$mycount=0;
					for ($i_pax = 0; $i_pax < $fldCustomerFormRooms; $i_pax++) {
						$mycount=$mycount + 1;
						$fldCustomerFormPaxRooms=$mycount;
						$fldCustomerFormPaxRoomsAdult=$fldCustomerFormRoomsAdult[$mycount];
						$fldCustomerFormPaxRoomsChild=$fldCustomerFormRoomsChild[$mycount];
						$fldCustomerFormPaxRoomsInfant=$fldCustomerFormRoomsInfant[$mycount];
						$sql = "INSERT INTO tblCustomerFormPax ";
						$sql .= "(fldCustomerFormPaxRoomsInfant,fldCustomerFormPaxRoomsChild,fldCustomerFormPaxRoomsAdult,fldCustomerFormPaxRooms,fldCustomerID,fldCustomerFormID)";
						$sql .= "VALUES('$fldCustomerFormPaxRoomsInfant','$fldCustomerFormPaxRoomsChild','$fldCustomerFormPaxRoomsAdult','$fldCustomerFormPaxRooms','$fldCustomerID','$fldCustomerFormID')";
						$result = mysql_query($sql, $db_elegantp);
					}
				}
			}else{
				$Error = $Error . '<li>Can not submit one after one enquries ('.$Hours.')</li>';
			}
		}else{
			$Error = $Error . '<li>This is a SPAM email</li>';
		}

		/////////////////////////////////////////////////////TO SEND MAIL
		$TIME=date('D, M d, Y h:i a');
		$VERIFICATIONID=$fldCustomerEmailVerificationID;
		$NAME=SafTitleListFunV2('null',$fldCustomerTitle,"","","","","","","") . " $fldCustomerFName $fldCustomerLName";
		$CUSTOMEREMAIL=$fldCustomerEMail;
		if ($fldCustomerEmailVerified){
			// Message after form submission for Email Verified Clients
			$EMAILTEXT='';$TEMPATETEXT='';$MYBODY='';$MESSAGE='';$MYMESSAGEBODY='';
			$MYMESSAGEBODY=GetTemplateText($db_elegantp,44);	//Website Message: Reservation Form - After filling the form (Email Verified Clients)
			$EMAILSUBJECT=$EMAIL_SUBJECT[1];
			//////////////////////////////////////////////////////////////////////////////////////////////////
			$MYBODY=$MYMESSAGEBODY;
			include($_SERVER["DOCUMENT_ROOT"]."/function/str_replace_function.php"); //Send and Return $MYBODY
			$MYMESSAGEBODY=$MYBODY;
			//////////////////////////////////////////////////////////////////////////////////////////////////
			if ($fldCustomerStatus!=9){
				if ($Hours>=1) { //if the previus enqury is more than 4 hour only I will send the mail
					// Email to Email Verified Clients [Using template without phone]
					$EMAILTEXT='';$TEMPATETEXT='';$MYBODY='';$MESSAGETEXT='';$MESSAGE='';
					$MESSAGE = GetTemplateText($db_elegantp,7);//Website Email: After form filling (Email Verified Clients)
					$TEMPATETEXT=GetTemplateText($db_elegantp,2);//Website Email Signature: After form filling
					$EMAILSUBJECT=$EMAIL_SUBJECT[1];
					//////////////////////////////////////////////////////////////////////////////////////////////////
					$MYBODY=$TEMPATETEXT;
					include($_SERVER["DOCUMENT_ROOT"]."/function/str_replace_function.php"); //Send and Return $MYBODY
					$MYBODY=$MYBODY;
					//////////////////////////////////////////////////////////////////////////////////////////////////

					//From Email
					$fromArray = $spiltObj->getmyEmailAddress("$MYFROM_NAME <$MYFROM_EMAIL>");
					foreach($fromArray as $key=>$value):
						$mail->SetFrom($value['email'],$value['name']);
					endforeach;

					//To Email
					$toArray = $spiltObj->getmyEmailAddress("$NAME <$fldCustomerEMail>");
					foreach($toArray as $key=>$value):
						$mail->AddAddress($value['email'],$value['name']);
					endforeach;

					$mail->AddBCC("$MYFROM_EMAIL");
					$mail->Subject=$EMAIL_SUBJECT[1];
					$mail->MsgHTML($MYBODY);
					if(!$mail->Send()){
						//write somthing in error log;
					}
				}
			}
		}else{
			// Message after form submission for Email NOT Verified Clients
			$EMAILTEXT='';$TEMPATETEXT='';$MYBODY='';$MESSAGETEXT='';$MYMESSAGEBODY='';
			$MESSAGETEXT= GetTemplateText($db_elegantp,42);//Website Message: Reservation Form - After filling the form (Email NOT Verified Clients)
			$EMAILSUBJECT=$EMAIL_SUBJECT[2];
			//////////////////////////////////////////////////////////////////////////////////////////////////
			$MYBODY=$MESSAGETEXT;
			include($_SERVER["DOCUMENT_ROOT"]."/function/str_replace_function.php"); //Send and Return $MYBODY
			$MYMESSAGEBODY=$MYBODY;
			//////////////////////////////////////////////////////////////////////////////////////////////////

			if ($fldCustomerStatus!=9){
				if ($Hours>=1) { //if the previus enqury is more than 4 hour only I will send the mail
					// Email for Email NOT Verified Clients [Using template without phone]
					$EMAILTEXT='';$TEMPATETEXT='';$MYBODY='';$MESSAGETEXT='';$MESSAGE='';
					$MESSAGE = GetTemplateText($db_elegantp,6);//Website Email: After form filling (Email NOT Verified Clients)
					$TEMPATETEXT=GetTemplateText($db_elegantp,2);//Website Email Signature: After form filling
					//////////////////////////////////////////////////////////////////////////////////////////////////
					$MYBODY=$TEMPATETEXT;
					include($_SERVER["DOCUMENT_ROOT"]."/function/str_replace_function.php"); //Send and Return $MYBODY
					$MYBODY=$MYBODY;
					//////////////////////////////////////////////////////////////////////////////////////////////////

					//From Email
					$fromArray = $spiltObj->getmyEmailAddress("$MYFROM_NAME <$MYFROM_EMAIL>");
					foreach($fromArray as $key=>$value):
						$mail->SetFrom($value['email'],$value['name']);
					endforeach;
					//To Email
					$toArray = $spiltObj->getmyEmailAddress("$NAME <$fldCustomerEMail>");
					foreach($toArray as $key=>$value):
						$mail->AddAddress($value['email'],$value['name']);
					endforeach;
					$mail->AddBCC("$MYFROM_EMAIL");
					$mail->Subject=$EMAIL_SUBJECT[2];
					$mail->MsgHTML($MYBODY);
					if(!$mail->Send()){
						//write somthing in error log;
					}
				}
			}
		}
		$success= true;
	}
}
///////////////////////////////

    //$id = 98;//$_GET['tourpackageid'];
    $details =ProductDetails($db_elegantp,$ProductID=$id);
    $productD = $details['ProductTextCategoryArray'];
    $pp = ProductPhotosGellaryEditednaz($db_elegantp,$ProductID,null);
    
    for($i=0; count($productD)>$i; $i++){
        if($productD[$i]['ProductTextCategoryName']=='Overview'){
            $overviewText = $productD[$i]['ProductTextCategoryTextArray'][0]['ProductText'];

        }else if($productD[$i]['ProductTextCategoryName']=='Location'){
            $locationText = $productD[$i]['ProductTextCategoryTextArray'][0]['ProductText'];

        }else if($productD[$i]['ProductTextCategoryName']=='Accommodation'){
            $accommodationsA = $productD[$i]['AccommodationNameArray'];

        }else if($productD[$i]['ProductTextCategoryName']=='Dining'){
            $diningA = $productD[$i]['ProductTextCategoryTextArray'];

        }else if($productD[$i]['ProductTextCategoryName']== 'The Spa'){
            $spaA = $productD[$i]['ProductTextCategoryTextArray'];

        }else if($productD[$i]['ProductTextCategoryName']=='Facilities'){
            $facilitiesA = $productD[$i]['ProductTextCategoryTextArray'];
        }
    }
    //$country = 121;
    $resortsA = GetProductSafSmartSQl($db_elegantp,"p.fldCountryID =$country",$GROUPBY=null,$ORDERBY=null,$LIMIT=null);
    for($i=0; count($resortsA)>$i; $i++){
        $pid = $resortsA[$i]['ProductID'];
        $ptags = $resortsA[$i]['ProductTagsArray'];
        for($p=0; count($ptags)>$p; $p++){
            $tagsT[] = $ptags[$p]['TagsTitle'];
        }
    }
    $tagsTi = array_unique($tagsT);

ncheader(3, $menu, $weblink); ?>
<div class="container-fluid px-0 bg-theme-color">
    <div class="owl-carousel carousel-se1 owl-theme">
        <?php for($i=0; count($pp)>$i; $i++){ ?>
            <div class="position-relative">
               <img class="bgimg" style="height:70vh;" src="<?= fphoto($pp[$i]['ProductPhotoFileName'], 'org') ?>" alt="" >
               <div class="bgimgoverlay-full px-5 flex-center-items theme-gradient-bt" style="height:70vh;justify-content:end;">
                    <h2 class="text-light fs-1 px-3 px-sm-5"><?= $pp[$i]['ProductPhotoName'] ?></h2>
                    <h4 class="text-light px-3 px-sm-5"><?= $details['ProductShortDisplayName'] ?></h4>
                </div>
            </div>
        <?php /*$i = count($pp);*/ } ?>
    </div>
    <div class="container bg-theme-color">
        <div class="row py-5 py-lg-13 text-light">
            <div class="col-md-12 col-lg-7">
                <div class="pt-3 pb-4">
                    <h1 class="fw-bold"><?= $details['ProductName'] ?></h1> 
                    <p class="me-2 d-inline-block"><?= $details['ProductAtollDistric'].', '.$details['ProductIslandCity'].', '.$details['ProductCountryName'] ?></p>
                    <p class="text-warning d-inline-block">Ratings: <?php for($i=0; $details['ProductStarRating']>$i; $i++){echo '<i class="fas fa-star"></i>';} ?></p>
                </div>
                <div class="py-4">
                    <h4>Location</h4>
                    <p class="lh-lg Cmo"><?= $locationText ?></p>
                </div>
                <div class="py-4">
                    <h4>Overview</h4>
                    <p class="lh-lg Cmo"><?= $overviewText ?></p>
                </div>
            </div>
            <div class="col-md-12 py-5 py-lg-0 col-lg-5">
                <form class="border border-secondary p-3 rounded" id="rstForm" action="" method="post">
                    <h4 class="mb-3 text-center">Inquire!</h4>
                    <div class="row mb-2 gx-1">
                        <div class="col">
                            <label for="date" class="form-label text-ncs-light">Arrival Date<span class="text-danger">*</span></label>
                            <input type="date" id="arrivalDate" class="form-control<?= ($isset==true && empty($_POST['fldCustomerFormArrivalDate']))? ' is-invalid' : ''; ?>" placeholder="Date" name="fldCustomerFormArrivalDate" value="<?= (!empty($_POST['fldCustomerFormArrivalDate']))? $_POST['fldCustomerFormArrivalDate'] : ''; ?>" aria-label="date">
                            <div class="invalid-feedback">please select a arriaval date</div>
                        </div>
                        <div class="col">
                            <label for="nights" class="form-label text-ncs-light">No of nights<span class="text-danger">*</span></label>
                            <select class="form-select" name="fldCustomerFormNights" data-selected="<?= (!empty($_POST['fldCustomerFormNights']))? $_POST['fldCustomerFormNights'] : ''; ?>" aria-label="nights">
                                <option value="1">1 Night</option>
                                <?php for($i=1; $i<30; $i++){ ?>
                                    <option value="<?= $i+1 ?>"><?= $i+1 ?> Nights</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2 gx-1">
                        <div class="col">
                            <label for="adults" class="form-label text-ncs-light">Adults<span class="text-danger">*</span></label>
                            <select class="form-select" name="fldCustomerFormRoomsAdult" aria-label="adults" data-selected="<?= (!empty($_POST['fldCustomerFormRoomsAdult']))? $_POST['fldCustomerFormRoomsAdult'] : ''; ?>">
                                <?php for($i=0; $i<5; $i++){ ?>
                                    <option value="<?= $i+1 ?>"><?= $i+1 ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="childs" class="form-label text-ncs-light">Childs</label>
                            <select class="form-select" name="fldCustomerFormRoomsChild" aria-label="childs" data-selected="<?= (!empty($_POST['fldCustomerFormRoomsChild']))? $_POST['fldCustomerFormRoomsChild'] : ''; ?>">
                                <option selected>0</option>
                                <?php for($i=0; $i<5; $i++){ ?>
                                    <option value="<?= $i+1 ?>"><?= $i+1 ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2 gx-1">
                        <div class="col-3">
                            <label for="title" class="form-label text-ncs-light">Title</label>
                            <select class="form-select" name="fldCustomerTitle" aria-label="title" data-selected="<?= (!empty($_POST['fldCustomerTitle']))? $_POST['fldCustomerTitle'] : ''; ?>">
                                <option value="4" selected="">Dr.</option>
                                <option value="7" selected="">HRH </option>
                                <option value="6" selected="">Master.</option>
                                <option value="2" selected="">Miss.</option>
                                <option value="1" selected="">Mr.</option>
                                <option value="3" selected="">Mrs.</option>
                                <option value="5" selected="">Prof.</option>
                                <option value="" selected="">Title</option>
                            </select>
                        </div>
                        <div class="col-9">
                            <label for="name" class="form-label text-ncs-light">Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control<?= ($isset==true && empty($_POST['fldCustomerFName']))? ' is-invalid' : ''; ?>" name="fldCustomerFName" aria-label="name" value="<?= (!empty($_POST['fldCustomerFName']))? $_POST['fldCustomerFName'] : ''; ?>">
                            <div class="invalid-feedback text-end">please enter your name</div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="country" class="form-label text-ncs-light">Country of Residence<span class="text-danger">*</span></label>
                        <select class="form-select mb-2<?= ($isset==true && empty($_POST['fldCustomerCountryOfResidence']))? ' is-invalid' : ''; ?>" name="fldCustomerCountryOfResidence" data-selected="<?= (!empty($_POST['fldCustomerCountryOfResidence']))? $_POST['fldCustomerCountryOfResidence'] : ''; ?>" aria-label="country">
                            <?php 
                                echo '<option value="">Select a country</option>';
                                $res = get_countries_nc($db_sqli);
                                foreach($res as $countr){
                                    echo '<option value="'.$countr[0].'">'.$countr[1].'</option>';
                                }
                            ?>
                        </select>
                        <div class="invalid-feedback">please select your country</div>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label text-ncs-light">Email<span class="text-danger">*</span></label>
                        <input type="email" class="form-control<?= ($isset==true && empty($_POST['fldCustomerEMail']))? ' is-invalid' : ''; ?>" placeholder="Email" name="fldCustomerEMail" aria-label="email" value="<?= (!empty($_POST['fldCustomerEMail']))? $_POST['fldCustomerEMail'] : ''; ?>">
                        <div class="invalid-feedback">please enter your email</div>
                    </div>
                    <div class="mb-2">
                        <label for="mobile" class="form-label text-ncs-light">Mobile Number<span class="text-danger">*</span></label>
                        <input type="tel" class="form-control<?= ($isset==true && empty($_POST['fldCustomerMobilePhone']))? ' is-invalid' : ''; ?>" name="fldCustomerMobilePhone" aria-label="mobile" value="<?= (!empty($_POST['fldCustomerMobilePhone']))? $_POST['fldCustomerMobilePhone'] : ''; ?>">
                        <div class="invalid-feedback">please enter your mobile number</div>
                    </div>
                    <div class="d-grid mt-3">
                        <button type="submit" name="Submit" class="btn btn-warning">Request For Quotation</button>
                    </div>
					<?= ($success==true)? '<div class="text-success mt-2">Thank you! Form Submitted</div>':''; ?>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="bg-coffee">
    <div class="container-fluid bg-theme-color-7">
        <div class="container pt-5 text-light">
            <div class="py-4">
                <div class="row text-light">
                    <div class="col-12">
                        <h3 class="text-center text-sm-start fw-bold lh-base">Available Accommodations</h3>
                    </div>         
                </div>
                <div class="row py-4 g-5">
                    <?php for($a=0; count($accommodationsA)>$a; $a++){ ?>
                        <div class="col-lg-12 col-xl-6 accom<?= ($a>3)? ' scale0" style="display:none': ''; ?>">
                            <div class="row border border-warning p-3 rounded h-full bg-theme-color">
                                <div class="col-12 col-sm-5">
                                    <img class="width-full" style="height: 100%;object-fit: cover;" src="<?php $res = AccommodationPhotosEdited($db_elegantp,$accommodationsA[$a]['AccommodationID'],$LIMIT=null);
                                    echo fphoto($res[0]['AccommodationPhotoFileName'],$size = 'std'); $res=null;
                                    ?>" alt="">
                                </div>
                                <div class="col-12 pt-3 pt-sm-0 col-sm-7">
                                    <h5><?= $accommodationsA[$a]['AccommodationName'] ?></h5>
                                    <p class="text-ncs-light small CmoA"><?php 
                                        echo substr_replace($accommodationsA[$a]['AccommodationTextArray'][0]['AccommodationText'], "...", 250); ?>
                                        <span class="small pointer text-primary" data-bs-toggle="modal" data-bs-target="#seemore<?= $a ?>">See more</span>
                                    </p>
                                    <button class="btn btn-outline-warning rounded">Book Now</button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="my-3 text-center">
                        <button class="btn btn-outline-warning mt-5 mx-auto laccom"><i class="fa-solid fa-rotate"></i>Load More Accommodations</button>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<div class="container-fluid bg-theme-color">
    <div class="container py-5">
        <?php for($p=0; count($productD)>$p; $p++){ 
        if(!in_array($productD[$p]['ProductTextCategoryName'],['Overview', 'Location', 'Accommodation'])){ ?>
        <div class="row">
            <div class="col-12 pt-5">
                <h3 class="fw-bold text-light pt-4 pb-2"><?= $productD[$p]['ProductTextCategoryName'] ?></h3>
                <?php if(count($productD[$p]['ProductTextCategoryTextArray'])>1){ ?>
                <div class="accordion" id="ncaccordion">
                    <?php for($i=0; count($productD[$p]['ProductTextCategoryTextArray'])>$i; $i++){ ?>
                    <div class="accordion-item border border-secondary">
                        <h2 class="accordion-header" id="heading<?= "$p$i" ?>">
                            <button class="accordion-button accordion-warning fw-semi text-ncs-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= "$p$i" ?>" aria-expanded="true" aria-controls="collapse<?= "$p$i" ?>"><?= $productD[$p]['ProductTextCategoryTextArray'][$i]['ProductTextTitle'] ?></button>
                        </h2>
                        <div id="collapse<?= "$p$i" ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= "$p$i" ?>" data-bs-parent="#ncaccordion">
                            <div class="accordion-body bg-theme-color-7 text-ncs-light">
                                <div class="row">
                                    <div class="col-12">
                                        <img class="width-full width-sm-unset" src="<?php /*$tipe = TourItineraryPhotoEdited($db_elegantp, $productD[$p]['ProductTextCategoryTextArray'][$i]['TourItineraryID']);
                                        if($tipe){
                                            echo tiphoto($tipe[0]['TourItineraryPhotoFileName'],$size = 'thu'); 
                                        } */?>">
                                    </div>
                                    <div class="col-12">
                                        <p class="mt-3"><?php echo  $productD[$p]['ProductTextCategoryTextArray'][$i]['ProductText']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php }else{ ?>
                    <h6 class="text-light fw-semi"><?= $productD[$p]['ProductTextCategoryTextArray'][0]['ProductTextTitle'] ?></h6>
                    <p class="text-ncs-light pt-2"><? if(strpos($productD[$p]['ProductTextCategoryTextArray'][0]['ProductText'], '*') !== false){ 
                        echo '<ul class="text-ncs-light">';
                        echo str_replace('*','<li>',$productD[$p]['ProductTextCategoryTextArray'][0]['ProductText']); echo '</ul>';
                    }else{
                        echo $productD[$p]['ProductTextCategoryTextArray'][0]['ProductText'];
                    } ?></p>
                <?php } ?>
            </div>
        </div>
        <?php } } ?>
    </div>
</div>
<div class="bg-coffee">
    <div class="container-fluid bg-theme-color-7">
        <div class="container pt-5 text-light">
            <div class="py-4">
                <?php if('sri lanka'==strtolower($details['TourPackageCountryName'])){
                    $countryid = 183;
                }else{
                    $countryid = 121;
                }
                $alsoLike = GetTourPackageSafSmartSQl($db_elegantp,$SmartSQl = "tp.fldCountryID=$countryid",$GROUPBY=null,$ORDERBY=null,$LIMIT=null); ?>
                <div class="row py-5">
                    <h3 class="fw-bold text-light">Explore Resorts in <?= ($country==183) ? 'Sri Lanka' : 'Maldives'; ?>:</h3>
                    <?php for($rc=0; 4>$rc; $rc++){ ?> 
                    <div class="col-12 col-sm-6 col-md-4 col-xl-3 p-1 p-sm-2 p-md-3 resort-card" data-tags="<?= $tagsT[$rc] ?>">
                        <div class="card border border-secondary bg-dark text-light">
                            <img src="<?php $pphoto = ProductPhotoEdited($db_elegantp,$ProductID=$resortsA[$rc]['ProductID']);
                            echo fphoto($pphoto['ProductPhotoFileName'], 'med'); $pphoto =null;
                            ?>" alt="" class="card-img-top h-270 center-cover">
                            <div class="card-body">
                                <h5 class="card-title"><?= $resortsA[$rc]['ProductShortDisplayName'] ?></h5>
                                <p class="text-ncs-light card-text ncs-small fw-semi">
                                    <span class="float-start text-capitalize">Country: <?= strtolower($resortsA[$rc]['ProductCountryName']) ?></span><br><span class="d-block mt-2">Tags:<i class="fas fa-tags ms-2"></i><span class="r-tags ms-2"><?php for($pt=0; count($resortsA[$rc]['ProductTagsArray'])>$pt; $pt++){
                                                    echo $resortsA[$rc]['ProductTagsArray'][$pt]['TagsTitle'];
                                                    echo (count($resortsA[$rc]['ProductTagsArray'])==$pt+1)? '' : ', ';
                                    } ?></span></p>
                            </div>
                            <div class="card-footer bg-secondary">
                                <span class="float-start ncs-small"><?= ($resortsA[$rc]['ProductIslandCity']) ? 'City: '.strtolower($resortsA[$rc]['ProductIslandCity']) : ''; ?></span>
                                <a href="<?php echo $inside_pages['Resort'].'/'; echo ($country==183)?'sri-lanka'.'/'.$resortsA[$rc]['ProductID']:'maldives'.'/'.$resortsA[$rc]['ProductID']; ?>" class="btn btn-outline-warning btn-sm float-end">View Resort</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!=========modals=======>
<?php for($a=0; count($accommodationsA)>$a; $a++){ ?>
    <div class="modal fade" id="seemore<?= $a ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog p-sm-3 p-md-5" style="max-width:960px;">
            <div class="bg-coffee">
                <div class="modal-content bg-theme-color-7 border-warning">
                    <div class="modal-header text-light border-warning">
                        <h5 class="modal-title" id="exampleModalLabel"><?= $accommodationsA[$a]['AccommodationName'] ?></h5>
                        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <?php $res = AccommodationPhotosEdited($db_elegantp,$accommodationsA[$a]['AccommodationID'],$LIMIT=null); ?>
                                <div class="owl-carousel carousel-se2 owl-theme">
                                    <?php for($rs=0; count($res)>$rs; $rs++){ ?>
                                        <div class="position-relative">
                                            <img class="width-full" style="height:100%;object-fit:cover;" src="<?php echo fphoto($res[$rs]['AccommodationPhotoFileName'],$size = 'org');  ?>" alt="" >
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-ncs-light pt-3"><?= $accommodationsA[$a]['AccommodationTextArray'][0]['AccommodationText'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-warning">Book Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php ncfooter(3, $menu,$weblink, $footerData); ?>
<script>
$(document).ready(function(){
    $('.carousel-se1').owlCarousel({
        autoplay: true,
        autoplayhoverpause: true,
        autoplaytimeout:300,
        items: 1,
        nav: true,
        dots: false,
        loop: true
    });
    $('.carousel-se2').owlCarousel({
        autoplay: false,
        autoplayhoverpause: true,
        autoplaytimeout:300,
        items: 1,
        nav: true,
        dots: true,
        loop: false
    });
    var hd=0;
    var laccom = document.querySelector('.laccom');
    laccom.addEventListener('click', event=>{

        var accom = document.querySelectorAll('.accom');
        let l=lc= 0;
        for(i=0; accom.length>i; i++){
            if(accom[i].style.display == 'none'){
                if(l<4){
                    accom[i].style.display = '';
                    accom[i].classList.add('animate-block');
                    l++;
                }
                lc = true;
            }else{
                lc=false;
            }
        }
        console.log(lc);
        if(lc==true){
            laccom.style.display = 'block';
        }else{
            laccom.style.display = 'none';
        }
    });

    var ind=0;
    var CmoT = [];
    var Cmo = document.querySelectorAll('.Cmo');
    for(let i=0; Cmo.length>i; i++){
        if(Cmo[i].innerText.length>500){
            CmoT.push(Cmo[i].innerText);
            let CmoP = Cmo[i].innerText.substring(0, 480)+'...';
            document.querySelectorAll('.Cmo')[i].innerText = CmoP;
            let span =document.createElement('span');
            span.innerText = 'See more';
            span.classList = 'CmoB text-primary small pointer';
            span.dataset.pid = ind;
            Cmo[i].appendChild(span);
            span.addEventListener('click', Event=>{
                seeMore(span.dataset.pid,Cmo[i]);
            });
            ind++;
        }
    }

    function seeMore(text, element){
        element.innerText=CmoT[text]+'...';
        let span = document.createElement('span');
        span.classList = 'Cmols text-secondary small pointer';
        span.dataset.pid = text;
        span.innerText = 'See less'
        element.appendChild(span);
        span.addEventListener('click', Event=>{
            seeLess(element, 480, text);
        });
    }

    function seeLess(element, length, index){
       element.innerText = element.innerText.substring(0, length)+'...';
       let span = document.createElement('span');
       span.classList = 'CmoB text-primary small pointer';
       span.innerText = 'See more';
       span.dataset.pid = index;
       element.appendChild(span);
       span.addEventListener('click', Event=>{
        seeMore(index, element);
       });
    }

	<?= (isset($_POST['Submit']))? "document.getElementById('rstForm').scrollIntoView();":''; ?>
	try{
		var selectElem =document.querySelectorAll('select');
		for(let i=0; selectElem.length>i; i++){
			selectElem[i].childNodes
			for(let op=0; selectElem[i].childNodes.length>op; op++){
				if(selectElem[i].childNodes[op].value==selectElem[i].dataset.selected){
					selectElem[i].childNodes[op].setAttribute('selected','');
				}
			}
		}
	}catch(e){
		console.log(e);
	}

});
</script>