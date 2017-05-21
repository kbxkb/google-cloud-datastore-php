# A PHP web application implementing autocomplete using google cloud datastore 

This is a quick and dirty PHP web application that accesses google cloud datastore. The intent of this code is to demonstrate the technique only. This code, purposefully, in order to save time and effort, does not adhere to even minimum security standards (e.g., in order to quickly run the PHP code, it asks you to "chmod 777 /var/www/html" - it is your responsibility to understand the gravity of this and remove the VM as soon as you are done running the demo (or tighten things up yourself). Similarly, the code does not handle errors, does not log, and uses poor performance optimization (e.g., it does not connection-pool the datastore connection, instead it connects to Datastore every time a key is pressed)

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
3. 

### Get the code and run it

<TODO>
