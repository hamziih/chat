<?php
// email signature
$bmail['signature'] = "Kind regards \n %site%";
						
// welcome email on activation
$bmail['resend_activation_title'] = 'Account verification';
$bmail['resend_activation_content']  = "Dear %user%,\n
										Bellow you will find the verification code to verify your account.\n
										Verification code : %data%";
							
// recovery email
$bmail['recovery_title'] = 'Password recovery';
$bmail['recovery_content'] = "Dear %user%,\n
							We have received a temporary password request for your account. If you do not have requested any temporary password please simply ignore this email. 
							Bellow you will find your temporary password. Note that once you use it your old password will not be valid anymore.\n
							temporary password : %data%";
							
// test email
$bmail['test_title'] = 'Test success';
$bmail['test_content'] = 'This email confirm that your email settings are properly set';
?>