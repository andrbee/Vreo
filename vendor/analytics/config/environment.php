<?php



// enable when testing the server installation
// disable when done testing the installation
$ALLOW_TEST_INSTALLATION = true;



// enable when developing or debugging
// also, be certain to call API endpoints yourself when debugging, by replacing receiveJson() to receiveJsonFromRequest(), and then by calling the API URL followed by ?json={data}
$ENABLE_ERROR_REPORTING = true;



// if higher, passwords will be stored more securely, but registering and logging in will cost more CPU power
// will only have an effect on new passwords (so after registering, or after changing your password, even if the new password is the same as the old one)
$PASSWORDS_BCRYPT_COST = 10;







