<?php 
    require("connect-db.php");
    require("club-db.php");
    session_start();
    $user = null;
    $student = null;
    $faculty = null;
    if(!empty($_GET['user'])){
        $user = getUser($_GET['user']);
        $student = getStudent($_GET['user']);
        $faculty = getFaculty($_GET['user']);
    }
    else{
        http_response_code(404);
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
        <?php include("header.php") ?>
        <div class = "media">
            &nbsp
            <div style = "text-align: center">
                <?php if($user['Profile_Picture'] == null) : ?>
                    <img class = "rounded-circle account-img" src = "profile_pics\default.jpg" style = "text-align: center; min-width: 200px; min-height: 200px; width: 200px; height: 200px;">
                <?php else: ?>
                    <?php echo '<img class = "rounded-circle account-img" src="data:image/jpeg;base64,'.base64_encode($user['Profile_Picture']).'" style = "text-align: center; height: 200px; width: 200px;">'; ?> 
                <?php endif; ?> 
            </div>
            <div class = "media-body">
                <h2 class = "account-heading" style = "text-align: center">Name: <?php echo $user['Name'];?> </h2>
                &nbsp
                <p class = "text-secondary" style = "color: black !important; font-size: 20px; text-align: center">
                    Bio: <?php echo $user['Bio'];?>
                </p>
                &nbsp
                <p class = "text-secondary" style = "color: black !important; font-size: 20px; text-align: center">
                    Date Joined: <?php echo $user['Date_Joined'];?>
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
        </body>
    <?php else : ?>
        <?php http_response_code(404); ?>
        <p> User Not Found! </p>
    <?php endif; ?>
</html>