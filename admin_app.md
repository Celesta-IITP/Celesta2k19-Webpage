# API for the Admin App of Celesta2k19
## Base Url: https://celesta.org.in/backend/admin/functions/app/


### Login of the Admins
#### URL: login.php
#### REQUEST_METHOD: POST
#### Parameters:
* email
* password
#### Response:
* permit
* access_token
* status : 200(OK) / 204(User not found) / 405(Method not found)
* message ---- Array of messages
* position - Position of the user

### Checkin Checkout of users
#### URL: checkin_checkout.php
#### REQUEST_METHOD: POST
#### Parameters:
* access_token (of admins)
* permit (of admins)
* celestaid
* date_time
#### Response:
* status: 200(Checked out/Checked in)/ 203(Account not verified at desk)/ 404(Celestaid not found)
* message: Array of messages
* action: Checkin/Checkout

### Checkin Checkout of users for accommodation at hostel
#### URL: hospi_checkin_checkout.php
#### REQUEST_METHOD: POST
#### Parameters:
* access_token (of admins)
* permit (of admins)
* celestaid
* date_time
#### Response:
* status: 200(Checked out/Checked in)/ 203(Account not verified at desk)/ 204(Not payed accommodation fee or user has not booked accommodation) /404(Celestaid not found)/ 401(Invalid user)
* message: Array of messages
* action: Checkin/Checkout