<?php

session_start();

// variable declaration
$username = "";
$email    = "";
$errors = array();
$_SESSION['success'] = "";

// connect to database
$db = mysqli_connect('localhost', 'root', '', 'trajche');

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
            $password = md5($password1);//encrypt the password before saving in the database
            $query = "INSERT INTO users (username, email, password) 
					  VALUES('$user', '$email', '$password')";
            mysqli_query($db, $query);

            $_SESSION['user'] = $username;
            $_SESSION['success'] = "You are now logged in";
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
                $_SESSION['user'] = $email;
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