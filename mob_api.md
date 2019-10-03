# Mobile App API calls

### Link: [https://celesta.org.in/backend/user/functions/functions.php](https://celesta.org.in/backend/user/functions/functions.php)

## Registeration of User
Method: POST
Parameters: 
* f:"register_user"  (This parameter must be supplied along with the value written, to hit the registration api)
* first_name (minimum 3 letters)
* last_name
* phone
* college
* email (primary key)
* password
* confirm_password
* gender (m or f)
* referral_id (If entered send that else send CLST1504)
Response:
	```'status': 200/400```
	```'message': ["celestaid": "CLST****", "qrcode":"qr_code_url"] or Array of error messages```

## Activate User account
Method: POST
Parameters:
* f : "activate_user" (This parameter must be supplied to hit the activate user api)
* celestaid
* validation_code(5 digiit otp)

Response:
* status: 201/402
* message: Array of messages

## Login User
Method: POST
Parameters: 
* f : "login_user"  (This parameter must be supplied to hit the login user api)
* celestaid
* password

Response: 
* status: 202/403
* celestaid
* first_name
* last_name
* email
* phone
* qr_code
* message: Array of Messages
* events_registered: Events user have registered in JSON encoded form
* events_participated: Events user have participated
* access_token: (Store it safely. It will be required to hit the profile API)

## Profile API
Method: POST
Parameters:
* f : "user_profile"  (This parameter must be supplied to hit the login user api)
* celestaid
* access_token

Response: 
* status: 202/403
* celestaid
* first_name
* last_name
* email
* phone
* qr_code
* message: Array of Messages
* events_registered: Events user have registered in JSON encoded form
* events_participated: Events user have participated

