<?php
require 'vendor/autoload.php';

// Define your service account credentials
$credentialsPath = './credentials.json';

// Create a new Google_Client instance
$client = new Google_Client();
$client->setAuthConfig($credentialsPath);
$client->addScope(Google_Service_Drive::DRIVE);

// Create a Google_Service_Drive instance
$service = new Google_Service_Drive($client);

// Function to upload the file to Google Drive
function uploadToDrive($service, $filePath, $folderId) {
    $fileMetadata = new Google_Service_Drive_DriveFile(array(
        'name' => basename($filePath),
        'parents' => array($folderId)
    ));
    $content = file_get_contents($filePath);
    $file = $service->files->create($fileMetadata, array(
        'data' => $content,
        'mimeType' => 'application/octet-stream',
        'uploadType' => 'multipart'
    ));
    return $file->id;
}

// Check if a file was uploaded
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $uploadedFile = $_FILES['file'];
    $tempFilePath = $uploadedFile['tmp_name'];
    // url for folder: https://drive.google.com/drive/folders/1loZyugvFZmn7I6VPi4UidNlAzBD5OpBk?usp=drive_link
    // Set the destination folder ID in Google Drive
    $destinationFolderId = '1loZyugvFZmn7I6VPi4UidNlAzBD5OpBk';

    try {
        // Upload the file to Google Drive
        $fileId = uploadToDrive($service, $tempFilePath, $destinationFolderId);
        echo 'File uploaded successfully. File ID: ' . $fileId;
    } catch (Exception $e) {
        echo 'An error occurred: ' . $e->getMessage();
    }
} else {
    echo 'No file uploaded or an error occurred during upload.';
}
?>