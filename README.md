# Celesta2k19-Webpage

##### Event API: https://celesta.org.in//backend/admin/functions/events_api.php

##### Admin Panel Link: https://celesta.org.in/backend/admin/login.php

##### Participate in an Event:
      Link: https://celesta.org.in/backend/admin/register_event.php
      Method: GET
      Parameters: eventid, celestaid, access_token
      Response:
              * status
                    * 302 - Already Registered
                    * 202 - Succesfully registered the user
                    * 401 - Unauthorized access. Celesta ID or access token doesn't match.
                    * 404 - Event not found
              * message - Array of Messages
