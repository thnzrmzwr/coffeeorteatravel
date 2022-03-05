<?php include 'partials/templates.php'; 
//include($_SERVER['DOCUMENT_ROOT']."/ipcheck.php");?>
<?php 
$fldCustomerEMail = $fldCustomerFName=$fldCustomerLName = $fldCustomerCityOfResidence=$fldCustomerCountryOfResidence=$message = $isset = $success=null;
if(isset($_POST['cform'])){
    if(!empty($_POST['email'])){
        $fldCustomerEMail = $_POST['email'];
    }
    if(!empty($_POST['fname'])){
        $fldCustomerFName = $_POST['fname'];
    }
    if(!empty($_POST['lname'])){
        $fldCustomerLName = $_POST['lname'];
    }
    if(!empty($_POST['city'])){
        $fldCustomerCityOfResidence = $_POST['city'];
    }
    if(!empty($_POST['country'])){
        $fldCustomerCountryOfResidence = $_POST['country'];
    }
    if(!empty($_POST['message'])){
        $message = $_POST['message'];
    }
    $fldCustomerMobilePhone = $_POST['phone'];
    //tmp code-------
    // $fldCustomerEMail = 'thnzrmzwr@gmail.com';
    // $fldCustomerFName = 'ramesh';
    // $fldCustomerLName = 'bandara';
    // $message = 'testing mate';
    //end tmp code----------
    $isset = true;
    if(!empty($fldCustomerEMail) && !empty($fldCustomerFName) && !empty($fldCustomerLName) && !empty($message)){
        
        //===============phpMail ===============
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
            $sql .= "(fldCustomerEmailVerificationID,fldCustomerDateTime,fldCustomerDate,fldCustomerIP,fldCustomerMobilePhone,fldCustomerEMail,fldCustomerCityOfResidence,fldCustomerCountryOfResidence,fldCustomerLName,fldCustomerFName)";
            $sql .= "VALUES('$fldCustomerEmailVerificationID','$fldCustomerDateTime','$fldCustomerDate','$fldCustomerIP','$fldCustomerMobilePhone','$fldCustomerEMail','$fldCustomerCityOfResidence','$fldCustomerCountryOfResidence','$fldCustomerLName','$fldCustomerFName')";
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
                    						<td colspan="3" style="font-family: Arial; font-size: 10pt; color: #a58454" valign="bottom" width="315" height="40">
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
        $to_booking = 'info@coffeeorteatravel.com, info@nazcloak.com';
        $subject = 'Conatct Form Request in Coffee or Tea Travel Website';
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
        mysql_close($db_elegantp);
        ///////////////////////////////

        //===========end of phpMail =============
        $fldCustomerEMail = $fldCustomerFName = $fldCustomerLName = $message = $fldCustomerMobilePhone=$fldCustomerCityOfResidence=$fldCustomerCountryOfResidence=$isset= null;
        $success= true;
    }

}
//print_r($res);
?>
<?php ncheader(5, $menu, $weblink); ?>

<div class="container-fluid bg-coffee px-0">
    <div class="py-13 bg-theme-color-7 ps-xl-5 ps-lg-0">
        <h2 class="text-light px-3 px-sm-5 h1 fw-bold">CONTACT US</h2>
        <p class="text-light px-3 px-sm-5"><?php $contact=PageDetails($db_elegantp,42);
        $para = explode("|", $contact['PageTextNoneHTML']);
        echo $para[0];?></p>
    </div>
</div>
<div class="container-fluid bg-theme-color">
    <div class="row" id="visit">
        <iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=Priyadarsanarama%20Road,%20Dehiwala&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" allowfullscreen="" loading="lazy"></iframe>
    </div>
    <div class="row py-4 px-sm-3 px-md-5" id="contact">
        <div class="col-md-6 p-sm-3 p-md-4 p-lg-5 p-4 text-ncs-light">
            <p class="h4 text-light">Welcome</p>
            <p class="py-3"><?= $ReservationsADDRESS; ?></p>
            <p class="text-primary"><i class="far fa-envelope pe-2"></i><a href="mailto:<?= $SignatureDefaultEmail; ?>"><?= $SignatureDefaultEmail; ?></a></p>
            <p class="text-primary"><i class="fal fa-phone-alt pe-2"></i><a href="tel:<?php echo $HeadOfficePHONE; ?>"><?= $HeadOfficePHONE; ?></a></p>
            <p class="text-primary"><i class="fal fa-phone-alt pe-2"></i><a href="tel:<?= $ReservationsHOTLINE; ?>"><?= $ReservationsHOTLINE; ?></a></p>
            <p class="text-primary"><i class="fal fa-phone-alt pe-2"></i><a href="tel:<?= $ReservationsPHONE; ?>"><?= $ReservationsPHONE; ?></a></p>
            <p class="py-2"><?= $para[1]; ?></p>
            <a href="<?= $TWITTERPAGE; ?>" class="btn bg-light rounded text-primary m-1"><i class="fab fa-instagram"></i>Instagram</a>
            <a href="<?= $FACEBOOKPAGE; ?>" class="btn bg-light rounded text-primary m-1"><i class="fab fa-facebook-square pe-2"></i>Facebook</a>
        </div>
        <div class="col-md-6 p-sm-3 p-md-4 p-lg-5 pt-sm-5 p-4">
            <p class="h4 text-light">Contact Form</p>
            <form action="" class="form-control-dark" method="post">
                <div class="row my-3">
                    <div class="col">
                        <label for="fname" class="form-label text-ncs-light">First Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control<?= ($isset==true && empty($fldCustomerFName))? ' is-invalid':'' ?>" name="fname" aria-label="fname" value="<?= (!empty($fldCustomerFName))? $fldCustomerFName:''; ?>">
                        <div class="invalid-feedback">Name can't be empty</div>
                    </div>
                    <div class="col">
                        <label for="fname" class="form-label text-ncs-light">Last Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control<?= ($isset==true && empty($fldCustomerLName))? ' is-invalid':'' ?>" name="lname" aria-label="lname" value="<?= (!empty($fldCustomerLName))? $fldCustomerLName:''; ?>">
                        <div class="invalid-feedback">Name can't be empty</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="email" class="form-label text-ncs-light">Email<span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control<?= ($isset==true && empty($fldCustomerEMail))? ' is-invalid':'' ?>" aria-label="email" value="<?= (!empty($fldCustomerEMail))? $fldCustomerEMail:''; ?>">
                        <div class="invalid-feedback">Email can't be empty</div>
                    </div>
                    <div class="col">
                        <label for="phone" class="form-label text-ncs-light">Phone</label>
                        <input type="tel" class="form-control" name="phone" aria-label="phone" value="<?= (!empty($fldCustomerMobilePhone))? $fldCustomerMobilePhone:''; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="city" class="form-label text-ncs-light">Your City<span class="text-danger">*</span></label>
                        <input type="city" name="city" class="form-control<?= ($isset==true && empty($fldCustomerCityOfResidence))? ' is-invalid':'' ?>" aria-label="city" value="<?= (!empty($fldCustomerCityOfResidence))? $fldCustomerCityOfResidence:''; ?>">
                        <div class="invalid-feedback">Your city can't be empty</div>
                    </div>
                    <div class="col">
                        <label for="country" class="form-label text-ncs-light">Your Country<span class="text-danger">*</span></label>
                        <select id="fldCountry" class="form-control" name="country">
                        <?php 
                            echo '<option value="">Select a Country</option>';
                                $res = get_countries_nc($db_sqli);
                               foreach($res as $countr){
                                   echo '<option value="'.$countr[0].'">'.$countr[1].'</option>';
                               }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label text-ncs-light">Message<span class="text-danger">*</span></label>
                    <textarea class="form-control<?= ($isset==true && empty($message))? ' is-invalid':'' ?>" name="message" rows="3" value="<?= (!empty($message))? $message:''; ?>"></textarea>
                    <div class="invalid-feedback">Please make a brief explain</div>
                </div>
                <div class="d-grid">
                    <button type="submit" name="cform" class="btn btn-primary">Submit Form</button>
                </div>
                <?= ($success ==true)? '<div class="text-success mt-2">Thank you! Form Submitted</div>':'';?>
            </form>
        </div>
    </div>
</div>

<?php ncfooter(5, $menu,$weblink, $footerData); ?>
<script>
    <?= ($isset==true || $success==true)? "document.getElementById('contact').scrollIntoView();":''; ?>
    <?= (!empty($fldCustomerCountryOfResidence))? "document.querySelector('#fldCountry').value=".$fldCustomerCountryOfResidence.";":''; ?>
</script>