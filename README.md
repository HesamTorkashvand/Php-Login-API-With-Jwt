# LoginAPI
php api for login , signup and forgetpassword with JsonWebToken + mysql database

=============================================================================

Register Request : 

url : http://localhost/register.php

body: {"email":"<Email>","password":"<Password>","name":"<Firstname>"}

=============================================================================

Login Request : 

url : http://localhost/Login.php

body: {"email":"<Email>","password":"<Password>"}

=============================================================================

Request For ResetPassword:

url: http://localhost/forget.php

1- Get Token : 
 
Body: {"Action":"GetToken","email":"<Email>"}
    
2- Reset Password :

Body: {"Action":"ResetPassword","token":"<Token>","newpass":"<newpass>"}
