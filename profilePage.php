<?php 
    require("connect-db.php");
    require("club-db.php");
    $user = null;
    if(!empty($_GET['user'])){
        $user = getUser($_GET['user']);
        echo $_GET['user'];
        echo $user['computing_id'];
        echo $user['Bio'];
    }
    else{
        echo "HTTP/1.0 404 Not Found";
       
    }
?>
<!DOCTYPE html>
<html>
    <?php if($user != null) : ?>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        </head>
        <body style = "background: #5be7a9;">
        <?php include("header.html") ?>
        <div class = "media">
        <div class = "media-body">
            &nbsp
            <h2 class = "account-heading" style = "text-align: center">Computing ID: <?php echo $user['computing_id'];?> </h2>
            &nbsp
            <p class = "text-secondary" style = "color: black !important; font-size: 20px; text-align: center">
                Bio: <?php echo $user['Bio'];?>
            </p>
            &nbsp
            <p class = "text-secondary" style = "color: black !important; font-size: 20px; text-align: center">
                Date Joined: <?php echo $user['Date_Joined'];?>
            </p>
        </div>
    </div>
        </body>
    <?php else : ?>
        <p> HELLO </p>
    <?php endif; ?>
</html>