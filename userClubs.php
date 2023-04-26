<?php
    require("connect-db.php");
    require("club-db.php");
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

    <?php 

    session_start();
    if(!isset($_SESSION['user'])) {
        header("Location: login.php");
    }

    $user = getUser($_SESSION['computingID']);
    $ID = $user['computing_id'];
    
    global $db;

    try {
        $statement = $db->prepare("SELECT `Name`, `Nickname`, `Concentration`, `Club_ID`, `Logo` FROM `Club` NATURAL JOIN `MemberOf` AS m WHERE m.computing_id = :computingID");
        $statement->bindValue(':computingID', $ID);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
    } catch (Exception $e) {
        print("Exception caught.");
    }
    ?>

    <br>
        <p class = "text-decoration-underline" style = "text-align: center; font-size: 25px;">
            Your Clubs:
        </p>

    <div class="container mt-5" style="text-align: center">
        <?php
            if ($results) {
                foreach ($results as $row) {
                    echo '<div class="card mx-auto" style="width: 18rem; text-align: center">';
                    if($row['Logo'] == null){
                        echo '<div class="d-flex justify-content-center">';
                        echo '<img src = "profile_pics\noImage.jpg" style = "height: 150px; width: 150px;" class = "card-img-top">';
                        echo '</div>';
                    }
                    else{
                        echo '<div class="d-flex justify-content-center">';
                        echo '<img src="data:image/jpeg;base64,'.base64_encode($row['Logo']).'" style = "width: 100%; height: 10vw; object-fit: scale-down;" class = "card-img-top">';
                        echo '</div>';
                    }
                        echo '<div class="card-body">';
                            echo '<h5 class="card-title" style="font-size:18px"> <a href = "clubPage.php?id=' . $row['Club_ID'] . '">' . $row['Name'] . (isset($row['Nickname']) ? ' (' . $row['Nickname'] . ')' : '') .'</a> </h5>';
                                echo '<p class="card-text" style="font-size:12px">' . $row['Concentration'] . '</p>';
                        echo '</div>';
                    echo '</div>';
                    echo '<br>';
                }
            } else {
                echo '<h3>Not in any clubs yet...</h3>';
            }
        ?>
    </div>

    </body>
</html>