<?php include 'partials/templates.php';
//include $_SERVER['DOCUMENT_ROOT']."/ipcheck.php";
if(isset($_GET['tourpackageid']) && is_numeric($_GET['tourpackageid'])){
    $id = $_GET['tourpackageid'];
    $details = GetTourPackageSafSmartSQl($db_elegantp,$SmartSQl = "tp.fldTourPackageID=$id",$GROUPBY=null,$ORDERBY=null,$LIMIT=null);
    //print_r($details);
    $details = $details[0];
    $itenary = $ml = null;
    if('sri lanka'==strtolower($details['TourPackageCountryName'])){
        $itenary = TourPackageDetails($db_elegantp,$id);
    }else{
        $ml =TourPackageDetailsEdited($db_elegantp,$id);
      //  print_r($ml);
    }
    $tpp=TourPackagePhotoEdited($db_elegantp,$id);
}else{
    exit;
}
//issue in 110 call to format on null (date format)
//=========form handler start================
if (isset( $_POST["fldCustomerFormArrivalDate"] )) {
	$_POST ["ArrivalYear"] = date ( "Y", strtotime ( $_POST ["fldCustomerFormArrivalDate"] ) );
	$_POST ["ArrivalMonth"] = date ( "m", strtotime ( $_POST ["fldCustomerFormArrivalDate"] ) );
	$_POST ["ArrivalDay"] = date ( "d", strtotime ( $_POST ["fldCustomerFormArrivalDate"] ) );
}
if (isset($_POST['Submit'])){
	$isset = true;
	if(($_POST["ArrivalYear"])&&(
    $_POST["ArrivalMonth"])&&(
    $_POST["ArrivalDay"])&&(
    $_POST["fldCustomerFormNights"])&&(
    $_POST["fldCustomerFormRoomsAdult"])&&(
    $_POST["fldCustomerFName"])&&(
    $_POST["fldCustomerEMail"])&&(
    $_POST["fldCustomerCountryOfResidence"])){
	
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
		$fldCustomerFormArrivalDate=$_POST ["fldCustomerFormArrivalDate"];
		$today = date("Y-m-d H:i:s");
		$date = DateTime::createFromFormat('m/d/yy', $fldCustomerFormArrivalDate); // "d/m/y" corresponds to the input format
		$MyArrivalDate = SafDate5V2($date->format('Y-m-d')); //outputs 2021-01-20 

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
												<td style="border-top: 1px solid #a58454; border-bottom: 1px solid #a58454; background-color: #a58454">
													<b><font face="Arial" size="2">OFFER INFORMATION</font>
													</b></td>
											</tr>
											<tr>
												<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="650" height="40">
												'.$fldCustomerFormSubject.'<br><br>'.$OFFERTEXT.'
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
													<font size="2" color="#a58454">Arrival date: '.$MyArrivalDate.'</font>
												</td>
												<td align="left" width="20" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" height="40">&nbsp;</td>
												<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="315" height="40">
													<font size="2" color="#a58454">No. of nights: '.$fldCustomerFormNights.'</font>&nbsp;
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
		$subject = 'Request From Coffee or Tea Travel (PACKAGE)';
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
				$fldCustomerFormType=8; //Reservations
				$fldCustomerFormArrivalDate = $_POST["ArrivalYear"] .'-'. $_POST["ArrivalMonth"] .'-'. $_POST["ArrivalDay"];
				
				$ArrivalDate = $fldCustomerFormArrivalDate;
				$Nights = $fldCustomerFormNights;
				list($ArrivalYear,$ArrivalMonth,$ArrivalDay)=explode("-",$ArrivalDate);
				$DepartureDate=date('Y-m-d',mktime(0,0,0,$ArrivalMonth,$ArrivalDay+$Nights,$ArrivalYear));                        
										
				$fldCustomerFormNights = $_POST["fldCustomerFormNights"];
				$fldCustomerFormRooms = $_POST["fldCustomerFormRooms"];
				$fldCustomerFormBudget = $_POST["fldCustomerFormBudget"];
				$fldCustomerFormTypeOFHoliday = $_POST["fldCustomerFormTypeOFHoliday"];
				$fldCustomerFormSubject = $fldCustomerFormSubject;
				$fldCustomerFormMessage = ConvertMakeAjexFriendly($_POST["fldCustomerFormMessage"]);
				if ($fldCustomerID){
					$sql = "INSERT INTO tblCustomerForm ";
					$sql .= "(fldCustomerFormSubject,fldCustomerID,fldCustomerFormIP,fldCustomerFormDate,fldCustomerFormDateTime,fldCustomerFormType,fldCustomerFormArrivalDate,fldCustomerFormNights,fldCustomerFormRooms,fldCustomerFormBudget,fldCustomerFormTypeOFHoliday,fldCustomerFormResort1ID,fldCustomerFormResort1VillaID,fldCustomerFormResort2ID,fldCustomerFormResort2VillaID,fldCustomerFormMessage,fldCustomerFormDestinationID)";
					$sql .= "VALUES('$fldCustomerFormSubject','$fldCustomerID','$fldCustomerFormIP','$fldCustomerFormDate','$fldCustomerFormDateTime','$fldCustomerFormType','$fldCustomerFormArrivalDate','$fldCustomerFormNights','$fldCustomerFormRooms','$fldCustomerFormBudget','$fldCustomerFormTypeOFHoliday','$fldCustomerFormResort1ID','$fldCustomerFormResort1VillaID','$fldCustomerFormResort2ID','$fldCustomerFormResort2VillaID','$fldCustomerFormMessage','$fldCustomerFormDestinationID')";
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
		$_POST["fldCustomerFormArrivalDate"]= $_POST["fldCustomerFormNights"]= $_POST["fldCustomerFormSubject"]= $_POST["fldCustomerFName"]= $_POST["fldCustomerEMail"]= $_POST["fldCustomerCountryOfResidence"]= $_POST['fldCustomerFormRoomsAdult']= $_POST['fldCustomerFormRoomsChild']= null;
		$success= true;
 	}
}
//mysql_close($db_elegantp);
///////////////////////////////  

ncheader(3, $menu, $weblink); ?>
<div class="container-fluid px-0 bg-theme-color position-relative">
    <img class="bgimg" src="<?= tiphoto($tpp['TourPackagePhotoFileName'],$size = 'org');  ?>" alt="">
    <div class="bgimgoverlay-full px-5 flex-center-items theme-gradient-bt">
        <h2 class="text-light px-3 px-sm-5 h1 fw-bold"><?= $details['TourPackageTitle'] ?></h2>
        <h4 class="text-light px-3 px-sm-5"><?php $nights = $details['TourPackageDuration'];
            $days = $nights+1;
            echo "$days Days/ $nights Nights Tour"; ?></h4>
    </div>
    <div class="container bg-theme-color">
        <div class="row text-light border border-secondary rounded">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card bg-theme-color border-0">
                    <div class="card-body d-flex mx-auto">
                        <span class="flex-center me-2" style="font-size: 24px;">
                            <i class="fas fa-clock"></i>
                        </span>
                        <div>
                            <p class="m-0 fw-bold">Duaration</p>
                            <p class="m-0"><?= $days.' Days/ '.$nights.' Nights'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card bg-theme-color border-0">
                    <div class="card-body d-flex mx-auto">
                        <span class="flex-center me-2" style="font-size: 24px;">
                            <i class="fas fa-users"></i>
                        </span>
                        <div>
                            <p class="m-0 fw-bold">Group Size</p>
                            <p class="m-0"><?php echo $gbed[$details['GBeddingPolicyID']] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card bg-theme-color border-0">
                    <div class="card-body d-flex mx-auto">
                        <span class="flex-center me-2" style="font-size: 24px;">
                            <i class="fas fa-dollar-sign"></i>
                        </span>
                        <div>
                            <p class="m-0 fw-bold">Price start from:</p>
                            <p class="m-0">US $<?= $details['TourPackagePrice'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card bg-theme-color border-0">
                    <div class="card-body d-flex mx-auto">
                        <span class="flex-center me-2" style="font-size: 24px;">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                        <div>
                            <p class="m-0 fw-bold">Expire Date</p>
                            <p class="m-0"><?= $details['PackageExpireDate'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row py-5 py-lg-13 text-light">
            <div class="col-md-12 col-lg-7">
                <h4>Package Desciption</h4>
                <?php
                    if(!empty($ml)){
                        $desc =$ml['TourPackageTextAd'];
                    }else{
                        $desc = $details['TourPackageDescription'];
                    }
                    $list = explode('*',$desc);
                    if(is_array($list) && count($list)>1){
                        echo '<ul class="lh-lg p">';
                        for($i=0; count($list)>$i; $i++){
                            echo ($list[$i]) ? "<li>$list[$i]</li>" :'';
                        }
                        echo "</ul>";
                    }else{
                        echo '<p class="lh-lg">'.$details['TourPackageDescription'].'</p>';
                    }
                ?>
            </div>
            <div class="col-md-12 py-5 py-lg-0 col-lg-5">
                <form class="border border-secondary p-3 rounded" id="pckgForm" action="" method="post">
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
<?php $item =$itenary['TourItineraryArray']; ?>
<div class="bg-coffee">
    <div class="container-fluid bg-theme-color-7">
        <div class="container pt-5">
            <?php if(empty($ml)){ ?>
            <div class="row text-light">
                <h3 class="fw-bold"><?= $days.' Days/ '.$nights.' Nights'; ?> Itenary:</h3>           
            </div>
            <div class="row py-4">
                <div class="col-12 ">
                    <div class="accordion" id="ncaccordion">
                        <?php for($i=0; count($item)>$i; $i++){ ?>
                        <div class="accordion-item border border-secondary">
                            <h2 class="accordion-header" id="heading<?= $i+1 ?>">
                                <button class="accordion-button fw-semi" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i+1 ?>" aria-expanded="true" aria-controls="collapse<?= $i+1 ?>">Day <?php echo $item[$i]['TourItineraryDay'].' - '.$item[$i]['TourItineraryDestination']; ?></button>
                            </h2>
                            <div id="collapse<?= $i+1 ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $i+1 ?>" data-bs-parent="#ncaccordion">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-12">
                                        <img class="width-full width-sm-unset" src="<?php $tipe = TourItineraryPhotoEdited($db_elegantp, $item[$i]['TourItineraryID']);
                                        if($tipe){
                                            echo tiphoto($tipe[0]['TourItineraryPhotoFileName'],$size = 'thu'); 
                                        } ?>">
                                    </div>
                                    <div class="col-12">
                                        <p class="mt-3"><?= $item[$i]['TourItineraryDescription']; ?></p>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php 
            if('sri lanka'==strtolower($details['TourPackageCountryName'])){
                $countryid = 183;
            }else{
                $countryid = 121;
            }
            $alsoLike = GetTourPackageSafSmartSQl($db_elegantp,$SmartSQl = "tp.fldCountryID=$countryid",$GROUPBY=null,$ORDERBY=null,$LIMIT=null);
            ?>
            <div class="row py-5">
                <h3 class="fw-bold text-light">You might also like:</h3>
                <?php for($i=0; 4>$i; $i++){ $aPhoto=TourPackagePhotoEdited($db_elegantp,$alsoLike[$i]['TourPackageID']);
                    if($alsoLike[$i]['TourPackageTitle']){ ?>
                    <div class="col-12 col-sm-6 col-md-4 col-xl-3 p-1 p-sm-2 p-md-3">
                        <div class="card bg-dark border border-secondary h-full text-light">
                            <img src="<?= tiphoto($aPhoto['TourPackagePhotoFileName'],$size = 'std'); ?>" alt="" class="card-img-top h-270 center-cover">
                            <div class="card-body">
                                <h6 class="card-title text-capitalize"><?= $alsoLike[$i]['TourPackageTitle']; ?></h6>
                            </div>
                            <div class="card-footer bg-secondary">
                                <span class="ncs-small">From: <span class="fw-bold">US$<?= $alsoLike[$i]['TourPackagePrice'];?></span></span>
                                <a href="<?= $weblink.'tour-package-single.php?tourpackageid='.$alsoLike[$i]['TourPackageID'] ?>" class="btn btn-outline-warning btn-sm float-end">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php $aPhoto=null; } } ?>
            </div>
        </div>
    </div>
</div>
<?php ncfooter(3, $menu,$weblink, $footerData); ?>
<script>
<?= (isset($_POST['Submit']))? "document.getElementById('pckgForm').scrollIntoView();":''; ?>
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
</script>