<?php
session_start();

$target_dir = "../uploads/";

// connect to database
$db = mysqli_connect('localhost', 'root', '', 'trajche');
$user = $_SESSION['user'];

// Count # of uploaded files in array
$total = count($_FILES['file']['name']);
//var_dump($total);
//var_dump($_FILES);

// Loop through each file
for( $i=0 ; $i < $total ; $i++ ) {
    if($_FILES['file']['size']<=0){
        continue;
    }
    //Get the temp file path
    $tmpFilePath = $_FILES['file']['tmp_name'][$i];

    //Make sure we have a file path
    if ($tmpFilePath != ""){
        //Setup our new file path
        $newFilePath = "../uploads/" . $_FILES['file']['name'][$i];
        //var_dump($newFilePath);

        //Upload the file into the temp dir
        if(move_uploaded_file($tmpFilePath, $newFilePath)) {

            $query = "INSERT INTO videos (email, filename) 
					  VALUES('$user', '$newFilePath')";
            mysqli_query($db, $query);
        }

    }
}

header('location: ../index.php');
?>