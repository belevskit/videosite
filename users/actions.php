<?php
include_once "../config/config.php";
session_start();

// variable declaration
$username = "";
$email    = "";
$errors = array();
$_SESSION['success'] = "";

// connect to database
$db = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DATABASE_NAME);

// REGISTER USER
if (isset($_REQUEST['form_action'])) {
    $form_action = $_REQUEST['form_action'];
    if($form_action == "register") {
        // receive all input values from the form
        $user = mysqli_real_escape_string($db, $_POST['user']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password1 = mysqli_real_escape_string($db, $_POST['password1']);
        $password2 = mysqli_real_escape_string($db, $_POST['password2']);

        // form validation: ensure that the form is correctly filled
        if (empty($user)) { array_push($errors, "Username is required"); }
        if (empty($email)) { array_push($errors, "Email is required"); }
        if (empty($password1)) { array_push($errors, "Password is required"); }

        if ($password1 != $password2) {
            array_push($errors, "Passwords must match");
        }

        // register user if there are no errors in the form
        if (count($errors) == 0) {
            $query = "SELECT * FROM users WHERE email='$email'";
            $results = mysqli_query($db, $query);

            if (mysqli_num_rows($results) == 1) {
                array_push($errors, "There is already an account with the given email. Please login or use a different email!");
                header('location: ../index.php');
            }

            $password = md5($password1);//encrypt the password before saving in the database
            $query = "INSERT INTO users (username, email, password) 
					  VALUES('$user', '$email', '$password')";
            mysqli_query($db, $query);

            $query = "SELECT id FROM users WHERE email='$email'";
            $results = mysqli_query($db, $query);

            if (mysqli_num_rows($results) == 1) {
                $id = mysqli_fetch_assoc($results);
                $_SESSION['user'] = $email;
                $_SESSION['userid'] = $id['id'];
                $_SESSION['success'] = "You are now logged in";
            }
            else {
                array_push($errors, "Failed to register user in database, please try again or contact system admin!");
            }
            header('location: ../index.php');
        }
        else{
            header('location: users.php?errors=' . urlencode(serialize($errors)));
        }
    }
    else if($form_action == "login"){
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password = mysqli_real_escape_string($db, $_POST['password1']);

        if (empty($email)) {
            array_push($errors, "Username is required");
        }
        if (empty($password)) {
            array_push($errors, "Password is required");
        }

        if (count($errors) == 0) {
            $password = md5($password);
            $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
            $results = mysqli_query($db, $query);

            if (mysqli_num_rows($results) == 1) {
                $id = mysqli_fetch_assoc($results);
                $_SESSION['user'] = $email;
                $_SESSION['userid'] = $id['id'];
                $_SESSION['success'] = "You are now logged in";
                header('location: ../index.php');
            }else {
                array_push($errors, "Wrong username and/or password!");
            }
        }
        else{
            header('location: users.php?errors=' . urlencode(serialize($errors)));
        }
    }
    else{
        array_push($errors, "Invalid action!");
    }
}

?>