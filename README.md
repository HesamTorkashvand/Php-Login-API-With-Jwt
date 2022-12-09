# LoginAPI
php api for login , signup and forgetpassword with JsonWebToken + mysql database

===============================

Register Request : 

url : http://localhost/register.php

body: {"email":"test@gmail.com","password":"Pass","name":"Firstname"}

===============================

Login Request : 

url : http://localhost/Login.php

body: {"email":"test@gmail.com","password":"Pass"}

===============================

Request For ResetPassword:

url: http://localhost/forget.php

1- Get Token : 
 
Body: {"Action":"GetToken","email":"test@gmail.com"}
    
2- Reset Password :

Body: {"Action":"ResetPassword","token":"Token","newpass":"newpass"}
