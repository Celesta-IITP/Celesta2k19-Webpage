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
* email

### Checkin Checkout of users
#### URL: checkin_checkout.php
#### REQUEST_METHOD: POST
#### Parameters:
* access_token (of admins)
* permit (of admins)
* celestaid
* date_time
* email
#### Response:
* status: '200'(Checked out/Checked in)/ '203'(Account not verified at desk)/ '404'(Celestaid not found)/ '401'(Admin unauthorized to perform this action.)
* message: Array of messages
* action: Checkin/Checkout
* last_action: Details of previous action

### Checkin Checkout of users for accommodation at hostel
#### URL: hospi_checkin_checkout.php
#### REQUEST_METHOD: POST
#### Parameters:
* access_token (of admins)
* permit (of admins)
* celestaid
* date_time
* email
#### Response:
* status: '200'(Checked out/Checked in)/ '203'(Account not verified at desk)/ '204'(Not payed accommodation fee or user has not booked accommodation) /'404'(Celestaid not found)/ '401'(Invalid user)
* message: Array of messages
* action: Checkin/Checkout
* last_action: Details of previous action


### To get the list of all the events
#### URL: eventsDetail.php
#### REQUEST_METHOD: POST
#### Parameters:
* access_token (of admins)
* permit (of admins)
* email

#### Response:
* status: 200(Successfully sent data)/ 401(Invalid user or unauthorized)
* message: Message String
* events : Array of (Objects{
    - "ev_name": "Robo Wars",
    - "ev_id": "ATM3781",
    - "is_team_event": "1"
})

### To get details of all the registered users of an event
#### URL: eventUsers.php
#### REQUEST_METHOD: POST
#### Parameters:
* access_token (of admins)
* permit (of admins)
* ev_id
* email

#### Response:
* status: 200(Successfully sent data)/ 401(Invalid user or unauthorized)
* message: Message String
* is_team_event: 0(Not team event)/ 1(It is a team event)
* registered_users : Array of (Objects{
    - "name": "Robo Wars",
    - "time": "2019-10-11 12:51:22",
    - "phone": "111111111",
    - "amount": 1500,
    - "celestaid": "CLST5404"
})
* team_details : Array of (Objects{
    - "time": "2019-10-17 17:22:31",
    - "amount": "1500",
    - "cap_name": "",
    - "cap_email": "",
    - "cap_phone": "",
    - "mem1_name": "",
    - "mem2_name": "",
    - "mem3_name": "",
    - "mem4_name": "",
    - "team_name": "",
    - "mem1_email": "",
    - "mem1_phone": "",
    - "mem2_email": "",
    - "mem2_phone": "",
    - "mem3_email": "",
    - "mem3_phone": "",
    - "mem4_email": "",
    - "mem4_phone": "",
    - "cap_celestaid": "",
    - "mem1_celestaid": "",
    - "mem2_celestaid": "",
    - "mem3_celestaid": "",
    - "mem4_celestaid": ""
})

```Note: For team events parse team_details. For non team events parse registered users.```


### To get the details of an user
#### URL: getDetails.php
#### REQUEST_METHOD: POST
#### Parameters:
* access_token (of admins)
* permit (of admins)
* email

#### Response:
* status: 200(Successfully sent data)/ 401(Invalid user or unauthorized)
* message: ""
* accommodation: 0(Not booked accommodation)/1(Accommodation booked and paid)/2(Accommodation booked but not paid)
* iit_patna: 0 (Not college student)/1 (IIT Patna student)
* amount_paid: 100
* college: ""
* phone: ""
* registration_desk: 0 (Account not verified at registration desk)/1(Account verified at registration desk)
* events_registered : Array of (Objects{
    - "ev_id": "ATM9933",
    - "amount": "110.5",
    - "ev_name": "Robowars",
    - "cap_name": "Amartya Mondal",
    - "team_name": "atm",
    - "ev_name"
})
* events: Array of (Objects of{
    - "ev_id": "ATM3781",
    - "ev_amount": "1500"
})