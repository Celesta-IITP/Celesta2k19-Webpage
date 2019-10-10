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