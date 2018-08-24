<?php include('_header.php'); ?>


<?php if (!$registration->registration_successful && !$registration->verification_successful) { ?>
<br>
<form method="post" action="buddyregister.php" name="registerform">
    <p>
    <label for="user_name"><?php echo WORDING_REGISTRATION_USERNAME; ?></label>
    <input id="user_name" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />
	
	    <label for="first_name"><?php echo WORDING_REGISTRATION_USERNAME; ?></label>
    <input id="first_name" type="text" pattern="[a-zA-Z0-9]{2,64}" name="first_name" required />
	
		    <label for="last_name"><?php echo WORDING_REGISTRATION_USERNAME; ?></label>
    <input id="last_name" type="text" pattern="[a-zA-Z0-9]{2,64}" name="last_name" required />
	
			    <label for="group_name"><?php echo WORDING_REGISTRATION_USERNAME; ?></label>
    <input id="group_name" type="text" pattern="[a-zA-Z0-9]{2,64}" name="group_name" required />

    <label for="user_email"><?php echo WORDING_REGISTRATION_EMAIL; ?></label>
    <input id="user_email" type="email" name="user_email" value="@bristol.ac.uk" required />

    <label for="user_password_new"><?php echo WORDING_REGISTRATION_PASSWORD; ?></label>
    <input id="user_password_new" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />

    <label for="user_password_repeat"><?php echo WORDING_REGISTRATION_PASSWORD_REPEAT; ?></label>
    <input id="user_password_repeat" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
   <br> 
     
    <input  id="rulescheckbox" type="checkbox" name="rulescheckbox" value='checked'/> 
    Tick this box of you have read and accept the   <strong> <a href="rules.html" target="_blank">the rules (click here)</a></strong> of the buddy system (compulsory) </br> 
    
  <input  id="persocheckbox" type="checkbox" name="persocheckbox" value='checked'/> Please don't reveal personal information  </br> 
    

    <img src="login/tools/showCaptcha.php" alt="captcha" />

    <label><?php echo WORDING_REGISTRATION_CAPTCHA; ?></label>
    <input type="text" name="captcha" required />
    	
    

    <input type="submit" name="register" value="<?php echo WORDING_REGISTER; ?>" />
    </p>
</form>
<?php } ?>

    <a href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a>

<?php //include('_footer.php'); ?>
