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
        <div class = "media">
            &nbsp
            <div style = "text-align: center">
                <?php if($user['Profile_Picture'] == null) : ?>
                    <img class = "rounded-circle account-img" src = "profile_pics\default.jpg" style = "text-align: center; width: 300px; height: 300px;">
                <?php else: ?>
                    <?php echo '<img class = "rounded-circle account-img" src="data:image/jpeg;base64,'.base64_encode($user['Profile_Picture']).'" style = "text-align: center;">'; ?> 
                <?php endif; ?> 
            </div>
            <div class = "media-body">
                <h2 class = "account-heading" style = "text-align: center">Name: <?php echo $user['Name'];?> </h2>
                &nbsp
                <p class = "text-secondary" style = "color: black !important; font-size: 20px; text-align: center">
                    Bio: <?php echo $user['Bio'];?>
                </p>
                <?php if($student != null) : ?>
                    &nbsp
                    <p class = "text-secondary" style = "color: black !important; font-size: 20px; text-align: center">
                        Major: <?php echo $student['Major'];?>
                    </p>
                    &nbsp
                    <p class = "text-secondary" style = "color: black !important; font-size: 20px; text-align: center">
                        Year: <?php echo $student['Year'];?>
                    </p>
                <?php elseif($faculty != null) : ?>
                    &nbsp
                    <p class = "text-secondary" style = "color: black !important; font-size: 20px; text-align: center">
                        Department: <?php echo $faculty['Department'];?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <form action = "updateProfile.php" method = "post" style = "text-align:center"     >
            <input type = "submit" name = "actionBtn" value = "Update" class = "btn btn-dark" />
          </form>
        </body>
</html>