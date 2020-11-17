usernames and passwords for each account 

`````````````````````
admin - 123
leader - 123 
manager1 - 123
manager2 - 123
finance - 123
`````````````````````

import the db as `department_ms`

before anything else, go to the 'api' folder and edit the login.php file
and provide your gmail and password for the sender_email & sender_password variables.
do the same in generatePdf.php file as well.

then log in to your gmail account security settings and turn 'Allow less secure apps' on..
'Allow less secure apps'

NOTE: You cannot use a gmail that has 2-Step Verification turned on.

go to the users table and edit admin's email address and
provide a real valid email address before trying to log in.. 
the OTP code will be sent to that email address on login.

if you enter a wrong password for three times within 30 seconds, 
your account will be locked for 30 seconds. 

after login in to the admin page create users with valid email accounts.
this way the OTP will be sent to the email address.

then u can login to those accounts and u will be asked to enter the OTP received.

Leaders can make new orders and edit and cancel those orders. [PENDING][0]
Managers can view pending orders for his department and approve or reject them. [PROCESSING][1]
Finance manager can view those approved orders by the managers and can proceed with the order. [APPROVED][2]
Admin can add senior manager's emails and send them the daily orders report. 

