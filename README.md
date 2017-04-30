STEP 1:Set up virtual host

help link:https://www.digitalocean.com/community/tutorials/how-to-set-up-apache-virtual-hosts-on-ubuntu-14-04-lts

Document Root :/path/rootfolder

STEP 2:Set up mysql db
    Import db form /db/wingify_product_app.sql
STEP 3:
    Change config.file /config/config.php
    DB_NAME:product_app
    DB_USER:your mysql username
    DB_PASSWORD:your mysql password
    HOST:mydql host
    BASE_PATH:host for app  same as virtual host server name//like http://localhost/rootfolder



First Time Use:
    First we need to create admin user and api_token

Endpoint: hostname/users/createAdmin
METHOD :POST
Data Params:
    {
      "username":"your admin name",
      "email":"your admin email"
    }

Success Response :
        {
        "success":"true",
        "api_token":"1f2edf997cb1bdc832e14713d2daef684a9d10e98e7e709331673c33e9192ecf",
        "expire_time":1501145638
        }


After Getting api_token use this token for each call


Token will be expire after 6 month form generated date.
