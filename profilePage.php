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
        $memberResults = getClubsFromMember($_GET['user']);
        $leaderResults = getClubsFromLeader($_GET['user']);
        $sponsorResults = getClubsFromSponsor($_GET['user']);
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
            <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
        </head>
        <body style = "background: #5be7a9; font-family: Lato;">
        <?php include("header.php") ?>
        <div class = "media">
            &nbsp
            <div class = "row">
                <div class = "col-3" style = "margin-left: 400px;">
                    <div style = "text-align: center" >
                        <?php if($user['Profile_Picture'] == null) : ?>
                            <img class = "rounded-circle account-img" src = "profile_pics\default.jpg" style = "width: 200px; height: 200px;">
                        <?php else: ?>
                            <?php echo '<img class = "rounded-circle account-img" src="data:image/jpeg;base64,'.base64_encode($user['Profile_Picture']).'" style = "text-align: center; width: 200px; height: 200px;">'; ?> 
                        <?php endif; ?> 
                        <h2 class = "account-heading"><?php echo $user['Name'];?> </h2>
                    </div>
                </div>
                <div class = "col-4">
                    <div class = "media-body">
                        <p class = "text-decoration-underline" style = "color: black !important; font-size: 20px; font-weight: bold;">
                            Profile Info
                        </p>
                        <p class = "text-secondary" style = "color: black !important; font-size: 15px;">
                            Bio: <?php echo $user['Bio'];?>
                        </p>
                        <?php if($student != null) : ?>
                            &nbsp
                            <p class = "text-secondary" style = "color: black !important; font-size: 15px;">
                                Major: <?php echo $student['Major'];?>
                            </p>
                            &nbsp
                            <p class = "text-secondary" style = "color: black !important; font-size: 15px;">
                                Year: <?php echo $student['Year'];?>
                            </p>
                            &nbsp
                            <?php 
                                $memberCount = 0;
                                    if($memberResults != null){
                                        echo '<div class = "text-secondary" style = "color: black !important; font-size: 15px;">Member Of: </div>';
                                        foreach($memberResults as $memberRow){
                                            if($memberCount != 0){
                                                echo ", ";
                                            }
                                            $memberClub = getClub($memberRow['Club_ID']);
                                            echo $memberClub['Name']; 
                                            echo " (" . $memberClub['Nickname'] . ")";
                                            echo " (Time Active: " . $memberRow['time_active'] . " months)";
                                            $memberCount = $memberCount + 1;
                                        }
                                    }
                                ?>
                            &nbsp
                            &nbsp
                                <?php 
                                    $leaderCount = 0;
                                        if($leaderResults != null){
                                            echo '<div class = "text-secondary" style = "color: black !important; font-size: 15px;">Leader Of: </div>';
                                            foreach($leaderResults as $leaderRow){
                                                if($leaderCount != 0){
                                                    echo ", ";
                                                }
                                                $leaderClub = getClub($leaderRow['Club_ID']);
                                                echo $leaderClub['Name']; 
                                                echo " (" . $leaderClub['Nickname'] . ")";
                                                echo " (" . $leaderRow['Exec_Role'] . ")";
                                                $leaderCount = $leaderCount + 1;
                                            }
                                        }
                                    ?>
                        <?php elseif($faculty != null) : ?>
                            &nbsp
                            <p class = "text-secondary" style = "color: black !important; font-size: 15px;">
                                Department: <?php echo $faculty['Department'];?>
                            </p>
                            &nbsp
                            <?php 
                                $sponsorCount = 0;
                                    if($sponsorResults != null){
                                        echo '<div class = "text-secondary" style = "color: black !important; font-size: 15px;">Sponsor Of: </div>';
                                        foreach($sponsorResults as $sponsorRow){
                                            if($sponsorCount != 0){
                                                echo ", ";
                                            }
                                            $sponsorClub = getClub($sponsorRow['Club_ID']);
                                            echo $sponsorClub['Name']; 
                                            echo " (" . $sponsorClub['Nickname'] . ")";
                                            $sponsorCount = $sponsorCount + 1;
                                        }
                                    }
                                ?>
                        <?php endif; ?>
                    </div>
                    &nbsp
                </div>
            </div>
            &nbsp
        </div>
        </body>
    <?php else : ?>
        <?php http_response_code(404); ?>
        <p> User Not Found! </p>
    <?php endif; ?>
</html>