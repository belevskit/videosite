<!DOCTYPE html>
<?php

if(isset($_REQUEST['errors'])) {
    //$errors = json_decode(htmlspecialchars_decode($_REQUEST['errors']));
    $errors = unserialize(urldecode($_REQUEST['errors']));
    //var_dump($errors);
    echo "<p>Errors:</p>";
    echo "<ul>";
    foreach($errors as $error){
        echo "<li> - $error</li>";
    }
    echo "</ul>";
}

?>
<html>
<head>
    <?php
        if(isset($_GET['initial']) && strcmp($_GET['initial'],'login')==0) { ?>
                <title>Login</title>
        <?php
        } else {
            ?>
            <title>Register</title>
        <?php
        }
    ?>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- Custom Theme files -->
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
    <!-- //Custom Theme files -->
    <!-- web font -->
    <link href="//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
    <!-- //web font -->
    <script>
        $(document).ready(function() {
            var formTitle = $("#form-title")[0].textContent;
            if(formTitle == "Login"){
                $("#input-password-confirm").hide();
                $("#input-password-confirm").attr("required", false);
                $("#input-user").hide();
                $("#input-user").attr("required", false);
            }else {
                $("#input-password-confirm").show();
                $("#input-password-confirm").attr("required", true);
                $("#input-user").show();
                $("#input-user").attr("required", true);
            }
            $("#login-signup-toogle" ).click(function() {
                //console.log('click');
                var stat = $("#login-signup-text").attr('data-status');
                if(stat == "register") {
                    window.document.title = "Login";
                    $("#login-signup-toogle")[0].innerHTML = "Register Now!";
                    $($("#login-signup-text")[0]).attr('data-status', 'login');
                    document.querySelector('#login-signup-text').childNodes[0].nodeValue = "Don't have an Account? ";
                    $("#input-password-confirm").hide();
                    $("#input-password-confirm").attr("required", false);
                    $("#input-user").hide();
                    $("#input-user").attr("required", false);
                    $("#input-submit").val("LOGIN");
                    $("#form-title")[0].textContent = "Login";
                    $("#input-hidden-action").val("login");
                }
                else {
                    window.document.title = "Register";
                    $("#login-signup-toogle")[0].innerHTML = "Login Now!";
                    $($("#login-signup-text")[0]).attr('data-status', 'register');
                    document.querySelector('#login-signup-text').childNodes[0].nodeValue = 'Already have an Account? ';
                    $("#input-password-confirm").show();
                    $("#input-password-confirm").attr("required", true);
                    $("#input-user").show();
                    $("#input-user").attr("required", true);
                    $("#input-submit").val("SIGNUP");
                    $("#form-title")[0].textContent = "Register";
                    $("#input-hidden-action").val("register");
                }
            });
        });
    </script>
</head>
<body>
<!-- main -->
<div class="main-w3layouts wrapper">
    <?php
    if(isset($_GET['initial']) && strcmp($_GET['initial'],'login')==0) { ?>
        <h1 id="form-title">Login</h1>
        <div class="main-info">
            <div class="agileits-top">
                <form action="actions.php" method="post" class="form-register">
                    <input id="input-user" class="text" type="text" name="user" placeholder="Username" required="">
                    <input id="input-email" class="text email" type="email" name="email" placeholder="Email" required="">
                    <input id="input-password" class="text" type="password" name="password1" placeholder="Password" required="">
                    <input id="input-password-confirm" class="text w3lpass" type="password" name="password2" placeholder="Confirm Password" required="">
                    <input id="input-hidden-action" type="hidden" name="form_action" value="login">
                    <div class="clear"> </div>
                    <input id="input-submit" type="submit" value="LOGIN">
                </form>
                <div id="login-signup-content">
                    <p id="login-signup-text" data-status="login">Don't have an Account? <a id="login-signup-toogle" href="#">Register Now!</a></p>
                    <p><a href="../index.php">Go back</a></p>
                </div>
            </div>
        </div>
            <?php
    } else {
        ?>
        <h1 id="form-title">Register</h1>
        <div class="main-info">
            <div class="agileits-top">
                <form action="actions.php" method="post" class="form-register">
                    <input id="input-user" class="text" type="text" name="user" placeholder="Username" required="">
                    <input id="input-email" class="text email" type="email" name="email" placeholder="Email" required="">
                    <input id="input-password" class="text" type="password" name="password1" placeholder="Password" required="">
                    <input id="input-password-confirm" class="text w3lpass" type="password" name="password2" placeholder="Confirm Password" required="">
                    <input id="input-hidden-action" type="hidden" name="form_action" value="register">
                    <div class="clear"> </div>
                    <input id="input-submit" type="submit" value="SIGNUP">
                </form>
                <div id="login-signup-content">
                    <p id="login-signup-text" data-status="register">Already have an Account? <a id="login-signup-toogle" href="#">Login Now!</a></p>
                    <p><a href="../index.php">Go back</a></p>
                </div>
            </div>
        </div>
        <?php
    }
    ?>


    <ul class="bubbles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
<!-- //main -->
</body>
</html>