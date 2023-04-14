<?php 
    require("connect-db.php");
    require("club-db.php");
    session_start();
    $club = null;
    $userLeader = getLeader($_SESSION['computingID'], $_POST['id']);
    if(!isset($_SESSION['user']) || $userLeader == null){
        header("Location: index.php");
    }
    else{
        $club = getClub($_POST['id']);
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Yes")){
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
            &nbsp
        </body>
</html>