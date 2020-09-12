<?php
$target_dir = "../uploads/";
/*$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}*/
// Count # of uploaded files in array
$total = count($_FILES['file']['name']);
var_dump($total);
var_dump($_FILES);

// Loop through each file
for( $i=0 ; $i < $total ; $i++ ) {

    //Get the temp file path
    $tmpFilePath = $_FILES['file']['tmp_name'][$i];

    //Make sure we have a file path
    if ($tmpFilePath != ""){
        //Setup our new file path
        $newFilePath = "../uploads/" . $_FILES['file']['name'][$i];
        var_dump($newFilePath);
        /*
        //Upload the file into the temp dir
        if(move_uploaded_file($tmpFilePath, $newFilePath)) {

            //Handle other code here

        }
        */
    }
}
?>