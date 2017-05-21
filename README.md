# A PHP web application that accesses google cloud datastore - WIP 

This is a quick and dirty PHP web application that acces google cloud datastore

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

### On VM you created

1. 

### Get the code and run it

<TODO>
