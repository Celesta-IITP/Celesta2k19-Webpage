
# Celesta2k19-Webpage

  

### Event API: https://celesta.org.in/backend/admin/functions/events_api.php
### Admin Panel Link: https://celesta.org.in/backend/admin/login.php

### Mobile App API Documentation: https://github.com/Celesta-IITP/Celesta2k19-Webpage/blob/development/mob_api.md
### Admin APP API Documentation: https://github.com/Celesta-IITP/Celesta2k19-Webpage/blob/development/admin_app.md

### Participate in an Event:
Link: https://celesta.org.in/backend/admin/functions/register_event.php

Method: POST

Parameters: eventid, celestaid, access_token

Response:
* status:
-302 - Already Registered
-202- Succesfully registered the user
-401- Unauthorized access. Celesta ID or access token doesn't match.
-404 - Event not found
* message - Array of Messages

### Register in a Team Event:

Link: https://celesta.org.in/backend/admin/functions/reg_team_event.php

Method: POST

Parameters:
* eventid
* celestaid (of captain)
* access_token(of captain)
* member1 (member 1 celestaid)
* member2 (member 2 celestaid)
* member3 (member 3 celestaid)
* member4 (member 4 celestaid)
* member5 (member 5 celestaid)
* team_name(Name of the team)

Response:

* status:
-302 - Some members of the team is already Registered
-202- Successfully registered the team
-401- Unauthorized access. Celesta ID or access token doesn't match.
-404 - Event does not found
-405 - members celesta id is incorrect
* message - Array of Messages
