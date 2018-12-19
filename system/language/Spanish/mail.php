<?php
// email signature
$bmail['signature'] = "Saludos cordiales \n %site%";
			
// welcome email on activation
$bmail['resend_activation_title'] = 'Verificación de la cuenta';
$bmail['resend_activation_content']  = "Querida %user%,\n
										A continuación encontrará el código de verificación para verificar su cuenta.\n
										Código de verificación : %data%";
							
// recovery email
$bmail['recovery_title'] = 'Recuperar contraseña';
$bmail['recovery_content'] = "Querido/a %user%,\n
							Hemos recibido una solicitud de contraseña temporal para su cuenta. Si todavía no ha solicitado ninguna contraseña temporal por favor, ignora este correo. 
							A continuación encontrará la contraseña temporal. Tenga en cuenta que una vez que se utiliza la contraseña temporal será reemplazada por su antigua contraseña..\n
							contraseña temporal : %data%";
							
// test email
$bmail['test_title'] = 'Prueba de éxito';
$bmail['test_content'] = 'Este correo electrónico confirma que tu configuración de correo electrónico está correctamente configurada';
?>