# A PHP web application implementing autocomplete using google cloud datastore 

This is a *quick and dirty* PHP web application that accesses google cloud datastore. The intent of this code is to demonstrate the technique only. This code, purposefully, in order to save time and effort, does not adhere to even minimum security standards (e.g., in order to quickly run the PHP code, it asks you to "chmod 777 /var/www/html" - it is your responsibility to understand the gravity of this and remove the VM as soon as you are done running the demo (or tighten things up yourself). Similarly, the code does not handle errors, does not log, and uses poor performance optimization (e.g., it does not connection-pool the datastore connection, instead it connects to Datastore every time a key is pressed).

Needless to say, this code can be vastly improved. I welcome pull requests, thank you. I will, of course, put that on my backburner as well!

## How to run and test this app

Let us see how you can, step by step, set up your environment and run this app as a demo

### On the google cloud side

1. Create a GCE VM in your desired region
  * Use Ubuntu 14.04
  * 1 vCPU and 3.75 GB of memory will suffice. I used 16 GB of persistent Standard Disk as I was dealing with large datasets, you can go less if you just restrict yourself to the bestbuy dataset that this demo uses.
  * You will need access to Cloud Datastore API, so turn on "Allow full access to all Cloud APIs" right now, will save some time later (See number 2 in the pre-reqsuisite list here: https://cloud.google.com/datastore/docs/datastore-api-tutorial)
  * Allow HTTP and HTTPS traffic
  * use SSH key if you have one
2. Create a project on GCP cloud console
  * Download service account credentials JSON file for your project from https://console.developers.google.com, and save it somewhere on the VM you created. You might need to SCP it into your VM, or just copy-paste the contents into a new file on your VM
  * Create an App Engine instance and deploy it - does not matter what's in it, you need this app enabled to access Datastore API-s. (See number 3 in the pre-reqsuisite list here: https://cloud.google.com/datastore/docs/datastore-api-tutorial)
3. If you have completed the above steps successfully, you should be all set to start tinkering with the VM you just now created

### On the VM you created

1. Log in (use your SSH key if needed)
2. Run "sudo apt-get update", and then "sudo apt-get install apache2 php5 php5-memcached memcached"

Note: We are installing memcached and php 5's memcache extension so that we can use memcache for RAM-based caching

3. Test if apache is working - browse to the external IP address of the VM from your favorite browser
4. Run "sudo apt-get install git", you will need to clone this repo
5. Run "git clone https://github.com/kbxkb/google-cloud-datastore-php.git" from anywhere meaningful, cd into google-cloud-datastore-php
6. Run "sudo chmod -R 777 /var/www" - see the security warning in the initial paragraph of this README
7. Copy calldatastore.php, form.html, loaddatastore.php, loaddatastore.sh, products.json into /var/www/html, use sudo as needed
8. Test access - browse to {your IP address}/form.html. You will see the rudimentary front end of my PHP application. Go ahead and type something in the textbox, the output area will show error, as it will try to access Datastore, but we have not set it up yet
9. Now, you need to add an environment variable to this VM. A good, permamnent way to do this is to edit /etc/environment and add a line to it. The line should be (without the quotes): "GOOGLE_APPLICATION_CREDENTIALS=/path/to/credentials.json" (remember you downloaded this file in the step 2 of the previous section?). If the path has spaces, put the value of the variable (i.e., the path) in double quotes. Once you save this file, you will have to log back out and in for it to take effect
10. cd into /var/www/html
11. Now, we will install composer so that we can install other PHP libraries and dependencies. Inside /var/www/html, Run: "sudo curl -sS https://getcomposer.org/installer | php"
12. Run "php composer.phar require google/auth" -> this installs the auth library needed to authenticate against the Google Cloud
13. Run "php composer.phar require google/cloud" -> this installs the general GCP cloud library needed to access datastore
14. If you list the contents of /var/www/html now, you will see a vendor directory created with an autoload.php file in it. if you are wondering what is PHP auto-loading, read this: http://ditio.net/2008/11/13/php-autoload-best-practices/
15. Change the PHP code to point at *your* project instead of mine:
  * In loaddatastore.php, change the line "$projectId = 'triple-cab-162115';" - update the value to the project id to whatever your Google Cloud Project id is (the cloud console is a good place to grab this from)
  * Same for calldatastore.php

### Load test data into Cloud Datastore

1. Obviously, you have to do this once. I have used the publicly available BestBuy dataset here: https://github.com/BestBuyAPIs/open-data-set. In fact, the only file I have used from this dataset is products.json, and I have included that file in my repository, so you have it copied inside your /var/www/html folder right now (if you have followed the above steps)
2. You will have to run this command to load the data into Cloud datastore, the script and the file are already in /var/www/html by now, just run this command from that directory: "./loaddatastore.sh products.json". Before you attempt this, here is something you should note:
  * Make sure that the sh file is an executable, set +x on it if needed
  * There are almost 52K records in products.json. This command will take around 4-5 hours to complete
  * The script that loads it (both the sh file and the php file that it calls repeatedly for each line) is **poorly optimized**. It is horrible to be precise. It just connects to datastore for every line on the JSON file, and runs a tight loop writing the entities into Datastore. I have used sed to extract the SKU and the Product Name fields only, that is all I write. The intent is to only demo auto-complete on the Product name, hence...
  * Run this command and take a break, it will take a while

### Demo auto-complete!

After loading is complete, go back to the form.html on the browser, and start typing something in the text box, see what happens! If everything was successful, it should auto-complete.

### Caching is working!

You might notice that the first time you type in a letter, it takes a little while to show the results. But if you type the same sequence of letters again, the results show up a lot quicker. This is because we are using memcache to cache the results for every unique letter-sequence in the code

Still feeling a sluggish? No wonder! Though we have used caching, performance optimization is still **quite poor** in this demo as of now. As you type, every key-press results in a call to datastore, but instead of connection-pooling, the code creates a new connection every time. That is not good, especially if you care about the end user's experience for auto-complete

### A small case in point

GQL queries used against datastore are case-sensitive. That is why I use strtolower(...) in the file loaddatastore.php. That means all those 52K records are stored in datastore in lowercase. So if there is a product called "Battery", it will match if you start typing "battery". However, it will *not* match if you start typing "Battery" unless we convert everything you type to lowercase before issuing the query.

  ### Clean-up
  
Do not forget to stop the VM, remove the GAE App and clean up Datastore. This is a metered platform, treat it like your own electricity bill, even if you are using an account with credits!

