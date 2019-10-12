# Mobile App API calls

### Link: [https://celesta.org.in/backend/user/functions/mob_functions.php](https://celesta.org.in/backend/user/functions/mob_functions.php)

## Registration of User
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
	```'message':Array of error messages```

## Activate User account
```User account is activated via the link send in the email```

Response:
* status: 201/402
* message: Array of messages

## Resend Activation Link
Method: POST
Parameters:
* f: "resend_activation_link"
* email

Response:
* status: 200(Successfully send the email)/ 208(Account already activated)/ 404(Email not found)
* message - Array of messages

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
* qr_code
* message: Array of Messages
* access_token: (Store it safely. It will be required to hit the profile API)

## Logout User
Method: POST
Parameters:
* f: "logout_user" (This parameter must be supplied to determine logout api.)
* celestaid
* access_token

Response:
* status: 202/401
  - 202: Successfully logged out
  - 401: Invalid authentication
* message: Array of messages

## Profile API
Method: POST
Parameters:
* f : "user_profile"  (This parameter must be supplied to hit the login user api)
* celestaid
* access_token

Response: 
* status: 202(Data successfully fetched)/403(Invalid access token)
* profile
    - celestaid
    - first_name
    - last_name
    - email
    - phone
    - qr_code
    - events_registered: Events user have registered in JSON encoded form
    - events_participated: Events user have participated
* message: Array of Messages
* events (Array of the following objects)
    - ev_id
    - ev_amount

