# BHRA-raking-merge-tool

This web-based application allows merging customer data from SuperSAAS, raker data from VolunteerSpot and the BHRA roster from excel spreadsheet.  The resulting web page is an integrated schedule for raking.

Configuration:

Passwords (for administrative access, and for database access)
and paths to upload and publish directories
are held in a config.ini file which is located outside of
the public_html area:

$ pwd
/home/*************/public_html/meatpacker
$ git remote -v
origin	https://*******************@github.com/******************/BHRA-raking-merge-tool.git (fetch)
origin	https://***************@github.com/***************/BHRA-raking-merge-tool.git (push)
$ more ../../meatpacker_config.ini 
; this is the INI file for BHRA meatpacker.  It specifies
; upload/publish directories
; database tables and login

[application password]
meatpacker_admin_password = "***********************"

[upload paths]
upload_path_volunteerspot_rakers =      "/home/**************/meatpacker_uploads/volunteerspot_raker/"
upload_path_volunteerspot_supervisors = "/home/**************/meatpacker_uploads/volunteerspot_supervisors/"
upload_path_supersaas =                 "/home/**************/meatpacker_uploads/supersaas/"
upload_path_roster =                    "/home/**************/meatpacker_uploads/roster/"

[publish directory]
publish_path = "/home/*********/public_html/bhra/"
publish_url  = "/../bhra/"
publish_schedule_filename = "schedule.html"

[database]
databasehost = "localhost"
databasename = "bhra_meatpacker"
databaseusername = "bhra"
databasepassword = "*******************"

db_table_volunteerspot_rakers = "volunteerspot_raker"
db_table_volunteerspot_supervisors = "volunteerspot_supervisor"
db_table_appointments = "appointment"
db_table_roster_parent = "roster_parent"
db_table_roster_raker = "roster_raker"

