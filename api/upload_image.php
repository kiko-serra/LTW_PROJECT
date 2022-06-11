<?php
require_once(__DIR__ . "/../database/connection.php");

if (isset($_FILES["image"]["error"])) {

    switch ($_FILES['image']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            $error_messege = "No file to be uploaded";
            break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $error_messege = "File exeeds filesize limit";
            break;
        default:
            $error_messege = "Error while uploading file";
            break;
    }
    if (isset($error_messege)) {
        die(json_encode($error_messege));
    }
}
else
    die(json_encode("Error is not set! Unexpected Error"));
// Checking filesize again because..
if ($_FILES['image']['size'] > 1000000) {
    die(json_encode('Exceeded filesize limit.'));
}

// Check MIME Type by yourself. (the content/extension of a file)
// If file not in the files we allow we won't save it
$file_info = new finfo(FILEINFO_MIME_TYPE);
if (false === $extension = array_search(
    $file_info->file($_FILES['image']['tmp_name']),
    array(
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
    ),
    true
)) {
    die(json_encode("Invalid File Format"));
}

// Now we can check if folder exists
$image_dir = __DIR__ . "/../images/";
if (!is_dir($image_dir)) mkdir($image_dir);

// We can use the unique id of the photos to provide a unique name/filepath
try{
$db = getDatabaseConnection();

// Dummy Insert to get ID
$stmt = $db->prepare("insert into Photo values(NULL,NULL)");
$stmt->execute();

$id = $db->lastInsertId();
// We dont use the upload name as the final name to prevent injection in htm 
$filename = $image_dir . $id . ".".$extension;

// Upadte the db with the real name
$stmt = $db->prepare("update Photo set link= ? where id_photo = ?");
$stmt->execute(array($filename,$id));
}catch(Exception $e){
    die(json_encode("Error While accessing database ". $e));
}

// Uploading the image to the server
move_uploaded_file($_FILES['image']['tmp_name'], $filename);

echo json_encode("Correctly Uploaded Image ". $filename);
