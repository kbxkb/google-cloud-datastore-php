# A PHP web application implementing autocomplete using google cloud datastore 

This is a *quick and dirty* PHP web application that accesses google cloud datastore. The intent of this code is to demonstrate the technique only. This code, purposefully, in order to save time and effort, does not adhere to even minimum security standards (e.g., in order to quickly run the PHP code, it asks you to "chmod 777 /var/www/html" - it is your responsibility to understand the gravity of this and remove the VM as soon as you are done running the demo (or tighten things up yourself). Similarly, the code does not handle errors, does not log, and uses poor performance optimization (e.g., it does not connection-pool the datastore connection, instead it connects to Datastore every time a key is pressed).

Needless to say, this code can be vastly improved. I welcome pull requests, thank you. I will, of course, put that on my backburner as well!

## How to run and test this app

Let us see how you can, step by step, set up your environment and run this app as a demo

### On the google cloud side

1. Create a GCE VM in your desired region
  * Use Ubuntu 14.04
  * 1 vCPU and 3.75 GB of memory will suffice. I used 16 GB of persistent Stanbdard Disk as I was dealing with large datasets, you can go less if you just restrict yourself to the bestbuy dataset that this demo uses
  * You will need access to Cloud Datastore API, so turn on "Allow full access to all Cloud APIs" right now, will save some time later (See number 2 in the pre-reqsuisite list here: https://cloud.google.com/datastore/docs/datastore-api-tutorial)
  * Allow HTTP and HTTPS traffic
  * use SSH key if you have one
2. Create a project on GCP cloud console
  * Download service account cradentials JSON file for your project from https://console.developers.google.com, and save it somewhere on the VM you created
  * Create an App Engine instance and deploy it - does not matter what's in it, you need this app enabled to access Datastore API-s. (See number 3 in the pre-reqsuisite list here: https://cloud.google.com/datastore/docs/datastore-api-tutorial)
3. If you have completed the above steps successfully, you should be all set to start tinkering with the VM you just now created

### On the VM you created

1. Log in (use your SSH key if needed)
2. Run "sudo apt-get update", and then "sudo apt-get install apache2 php5"
3. Test if apache is working - browse to the external IP address of the VM from your favorite browser
4. Run "sudo apt-get install git", you will need to clone this repo
5. Run "https://github.com/kbxkb/google-cloud-datastore-php.git" from anywhere meaningful, cd into google-cloud-datastore-php
6. Run "sudo chmod -R 777 /var/www" - see the security warning in the initial paragraph of this README
7. Copy calldatastore.php, form.html, loaddatastore.php, loaddatastore.sh, products.json into /var/www/html, use sudo as needed
8. Test access - browse to {your IP address}/form.html - you are seeing the rudimentary front end of my PHP application. Go ahead and type something in the textbox, the output area will show error, as it will try to access Datastore, but we have not set it up yet
9. Now, you need to add an environment variable to this VM. A good, permamnent way to do this is to edit /etc/environment and add a line to it. The line should be (without the quotes): "GOOGLE_APPLICATION_CREDENTIALS=/path/to/credentials.json" (remember you downloaded this file in the step 2 of the previous section?). If the path has spaces, put the value of the variable (i.e., the path) in double quotes. Once you save this file, you will have to log back out and in for it to take effect
10. cd into /var/www/html
11. Now, we will install composer so that we can install other PHP libraries and dependencies. Inside /var/www/html, Run: "sudo curl -sS https://getcomposer.org/installer | php"
12. Run "php composer.phar require google/auth" -> this installs the auth library needed to authenticate against the Google Cloud
13. Run "php composer.phar require google/cloud" -> this installs the general GCP cloud library needed to access datastore
14. If you list the contents of /var/www/html now, you will see a vendor directory created with an autoload.php file in it. if you are wondering what is PHP auto-loading, read this: http://ditio.net/2008/11/13/php-autoload-best-practices/
Change the PHP code to point at *your* project instead of mine:
  * In loaddatastore.php, change the line "$projectId = 'triple-cab-162115';" - update the value to the project id to whatever your Google Cloud Project id is (the cloud console is a good place to grab this from)
  * Same for calldatastore.php
15. 

### Get the code and run it

<TODO>
