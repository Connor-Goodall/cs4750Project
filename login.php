<?php 
    session_start();
    require("connect-db.php");
    require("club-db.php");
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Login"))
        {
           $user = getLoginInformation($_POST['loginComputingID'], $_POST['loginPassword']);
           if($user != NULL){
                $_SESSION['user'] = $user;
                header("Location: index.php");
           } 
           else{
            header("Location: login.php");
           }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body style = "background: #5be7a9;">
    <?php include("header.php") ?>
    <br>
    <p class = "text-decoration-underline" style = "font-size: 25px; text-align:center;">
        Club Finder Login
    </p>
    <form name = "loginForm" action = "login.php" method = "post" style = "position:absolute; top: 20%; right:0;
    left:0;">
      <div class = "row mb-4 mx-3">
        Computing ID* <br/>
        <input type = "text" class = "form-control" name = "loginComputingID" maxlength = "6" 
            style = "border: 2px solid black;" placeholder = "Your computing ID..." required
        />
    </div>
    <div class = "row mb-4 mx-3">
        Password*
        <input type = "password" class = "form-control" name = "loginPassword" maxlength = "100" minlength = "8" 
            style = "border: 2px solid black;" placeholder = "Your password..." required
        /> 
    </div>
    <div class="row mb-4 mx-3">
      <input type = "submit" class = "btn btn-dark" name = "actionBtn" value = "Login" 
        title = "Click to login into your account" style = "width: 10%; display: block; margin: auto;"
      />
    </div>
    </form>
</body>