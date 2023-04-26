<?php 
    require("connect-db.php");
    require("club-db.php");
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location: login.php");
    }
    else{
        $user = getUser($_SESSION['computingID']);
        $student = getStudent($_SESSION['computingID']);
        $faculty = getFaculty($_SESSION['computingID']); 
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Yes")){
                deleteUser($_SESSION['computingID']);
                if($student != null){
                    deleteStudent($_SESSION['computingID']);
                }
                elseif($faculty != null){
                    deleteFaculty($_SESSION['computingID']);
                }
                session_destroy();
                header("location: index.php");
                exit();
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
            <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
        </head>
        <body style = "background: #232D4B; font-family: Lato; color: #E57200;">
            <?php include("header.php") ?>
            &nbsp
            <div style = "position:absolute; top: 40%; right:0; left:0;">
                <p style = "text-align:center; font-size: 20px;">
                    Are you sure you want to delete your account?
                    &nbsp
                </p>
                <div style = "text-align:center;">
                    <form action = "deleteUser.php" method = "post" style = "display:inline-block;"     >
                        <input type = "submit" name = "actionBtn" value = "Yes" class = "btn btn-dark" 
                        title = "Click Yes to delete account" style = "margin-right:100px;"/>
                    </form>
                    <form action = "userProfile.php" method = "post" style = "display:inline-block;">
                        <input type = "submit" class = "btn btn-danger" name = "actionBtn" value = "No" 
                            title = "Click no to return to profile"/>
                    </form>
                </div>
            </div>
        </body>
</html>