* Go to the GCP Console: https://console.cloud.google.com/
* Create a service account and download the JSON key file
* Add the contents of the json to credentials.json
* Adjust the $destinationFolderId in upload.php to the folder id you want to upload to. (You can find the folder id in the URL when you get the link to share the folder)
* Make sure that the folder is shared with the service account address and has permissions to upload files
* Run the following command to install the required libraries:
```
composer install
```
* start the server:
```
docker-compose up -d
```
* Open the browser and go to http://localhost:81