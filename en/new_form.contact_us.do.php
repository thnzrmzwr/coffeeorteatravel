<?
// include($_SERVER['DOCUMENT_ROOT']."ipcheck.php");
// if ($myallow==false) {
// 	print '<meta name="bitly-verification" content=""/>';
// 	include($_SERVER["DOCUMENT_ROOT"]."/home.php");
// 	exit;
// }

if ($mySSL){
	if ($HTTP_X_FORWARDED_PROTO=="http") {
		header("Location: $DOMAIN/form.contact_us.do.php?$QUERY_STRING");
		exit;
	}
}

if (($_POST["Submit"])&&(
$_POST["fldCustomerFormType"])&&(
$_POST["fldCustomerTitle"])&&(
$_POST["fldCustomerFName"])&&(
$_POST["fldCustomerLName"])&&(
$_POST["fldCustomerEMail"])&&(
$_POST["fldCustomerCountryOfResidence"])&&(
$_POST["fldCustomerCityOfResidence"])&&(
$_POST["fldCustomerFormMessage"])){

	$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	$text = $_POST["fldCustomerFormMessage"];
	if(preg_match($reg_exUrl, $text, $url)) {
		header("Location: $DOMAIN/contact_us.html");
		exit;
	}


	$fldCustomerFormDestinationID=0; //Maldives Holiday
	include($_SERVER["DOCUMENT_ROOT"]."/config/include_spamer_security.php");
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
	$fldCustomerFormType = $_POST["fldCustomerFormType"];

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
                    							<font size="2" color="#a58454">First Name: '.$fldCustomerFName.'</font>
                    						</td>
                    						<td align="left" width="20" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" height="40"> </td>
                    						<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="315" height="40">
                    							<font size="2" color="#a58454">Email: '.$fldCustomerEMail.'</font>
                    						</td>
                    					</tr>
                    					<tr>
                    						<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="315" height="40">
                    							<font size="2" color="#a58454">Land Phone: '.$fldCustomerHomePhone.'</font>
                    						</td>
                    						<td align="left" width="20" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" height="40">&nbsp;</td>
                    						<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="315" height="40">
                    							<font size="2" color="#a58454">Mobile Phone: '.$fldCustomerMobilePhone.'</font>
                    						</td>
                    					</tr>
                    					</table>
                    				&nbsp;<table border="0" width="100%" cellpadding="4" style="border-collapse: collapse">
                    					<tr>
                    						<td style="border-top: 1px solid #a58454; border-bottom: 1px solid #a58454; background-color: #a58454">
                    							<b>
                    								<font face="Arial" size="2">MESSAGE</font>
                    							</b></td>
                    					</tr>
                    					<tr>
                    						<td align="left" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="650" height="40">
                    							<font size="2" color="#a58454">Message/special requests</font>
                    							<p align="justify">'.$fldCustomerFormMessage.'</p>
                    						</td>
                    					</tr>
                    				</table>
                    			</td>
                    		</tr>
                    	</table>
                    </div>';
//$sentOk = mail($to,$subject,$message,$headers);
$to_booking = 'sales@ultraluxurymaldives.com, shabeeb@ultraluxurymaldives.com';
$subject = 'Request From Ultra Luxury Maldives Website (CONTACT)';
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
			////////////////////////////////////////////////////////////////////////////////////////////
			$fldCustomerFormID=$data_CustomerForm->fldCustomerFormID;
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
			$fldCustomerFormType=$fldCustomerFormType; //reservation, contact us, quick form
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
		$EMAILTEXT='';$TEMPATETEXT='';$MYBODY='';$MESSAGETEXT='';$MYMESSAGEBODY='';
		$MESSAGETEXT=GetTemplateText($db_elegantp,39);	//Website Message: Form - After filling the other form 1 (Email Verified Clients)
		$EMAILSUBJECT=$EMAIL_SUBJECT[1];
		//////////////////////////////////////////////////////////////////////////////////////////////////
		$MYBODY=$MESSAGETEXT;
		include($_SERVER["DOCUMENT_ROOT"]."/function/str_replace_function.php"); //Send and Return $MYBODY
		$MYMESSAGEBODY=$MYBODY;
		//////////////////////////////////////////////////////////////////////////////////////////////////

		if ($fldCustomerStatus!=9){
			if ($Hours>=1) { //if the previus enqury is more than 4 hour only I will send the mail
				// Email to Email Verified Clientse]
				$EMAILTEXT='';$TEMPATETEXT='';$MYBODY='';$MESSAGETEXT='';$MESSAGE="";
				$MESSAGE= GetTemplateText($db_elegantp,7);//Website Email: After form filling (Email Verified Clients)
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

				$mail->AddBCC("$MailPilotEmail");
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
		$MESSAGETEXT= GetTemplateText($db_elegantp,43);//Website Message: Form - After filling the Other form 1 (Email NOT Verified Clients)
		$EMAILSUBJECT=$EMAIL_SUBJECT[2];
		//////////////////////////////////////////////////////////////////////////////////////////////////
		$MYBODY=$MESSAGETEXT;
		include($_SERVER["DOCUMENT_ROOT"]."/function/str_replace_function.php"); //Send and Return $MYBODY
		$MYMESSAGEBODY=$MYBODY;
		//////////////////////////////////////////////////////////////////////////////////////////////////

		if ($fldCustomerStatus!=9){
			if ($Hours>=1) { //if the previus enqury is more than 4 hour only I will send the mail
				// Email for Email NOT Verified Clients [Using template without phone]
				$EMAILTEXT='';$TEMPATETEXT='';$MYBODY='';$MESSAGETEXT='';
				$MESSAGE= GetTemplateText($db_elegantp,6);//Website Email: After form filling (Email NOT Verified Clients)
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
				$mail->AddBCC("$MailPilotEmail");
				$mail->Subject=$EMAIL_SUBJECT[2];
				$mail->MsgHTML($MYBODY);
				if(!$mail->Send()){
					//write somthing in error log;
				}
			}
		}
	}


///////////////////////////////
    
if ($mySSL==1){$MYMESSAGEBODY=str_replace("http://www.$DOMAINNAME", "https://www.$DOMAINNAME",$MYMESSAGEBODY);}else{$MYMESSAGEBODY=str_replace("https://www.$DOMAINNAME", "http://www.$DOMAINNAME",$MYMESSAGEBODY);}
include($_SERVER["DOCUMENT_ROOT"]."/function/web_function.php");

if (!$pid) { $pid=34;}
$PageDetails = PageDetails($db_elegantp,$pid);

$pageTitle= "$WEBSITE_NAME Thanks you.";
$pageKeyword='';
$pageDescription='';
$h1Title=$pageTitle;
$page="contact";
include($_SERVER["DOCUMENT_ROOT"]."/includes/new_include.inside_header.php")
////////////////////////////////////////////////////////////////////////////////
?>

      <!-- ========== PAGE TITLE ========== -->
      <div class="page-title gradient-overlay op6" style="background: url(<?=pagphoto ($PageDetails['PagePhotoArray']['0']['PhotoFileName'],'org')?>); background-repeat: no-repeat; background-size: cover;">
        <div class="container">
          <div class="inner">
            <h1>Thank You, for your request!</h1>
            <ol class="breadcrumb">
              <li>
                <a href="<?=$DOMAIN?>">Home</a>
              </li>
            </ol>
          </div>
        </div>
      </div>
      <!-- ========== MAIN ========== -->
      <main class="contact-page">
        <div class="container">
          <div class="entry">
            <div class="row">
              <div class="col-md-8">
                <div class="section-title">
                  <h4 class="text-uppercase">Thank You, for your request!</h4>
                  <p class="section-subtitle">High quality accommodation services</p>
                </div>
                <div class="info-branding">
                	<?
    					print $MYMESSAGEBODY;
    		            if ($fldCustomerFormID){
    		                 print $GoogleConversionCode;
    		         	}
    				?>
                </div>
              </div>
            </div>

          </div>
        </div>
      </main>

<?
////////////////////////////////////// MainContent End //////////////////////////////////////
include($_SERVER["DOCUMENT_ROOT"]."/includes/new_include.inside_footer.php");

}else{
	// If anything kind of spam
	header("Location: $DOMAIN/contact.html");
}
mysql_close($db_elegantp);
exit;
?>