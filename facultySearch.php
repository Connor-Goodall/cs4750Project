<?php
session_start();
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
        <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    </head>
    <body style = "background: #232D4B; font-family: Lato; color: #E57200;">
    <?php 
        if(!isset($_SESSION['user'])){
            include("nonuserHeader.php");
        }
        else{
            include("userHeader.php");  
        }
    ?>

    <?php
    $keyword = NULL;
    $results = NULL;
    if (isset($_GET['keyword'])){
        global $db; 
        $keyword = $_GET['keyword'];
        $statement = $db->prepare("select `Department`, `Name`, User.computing_id, User.Profile_Picture from `Faculty` join `User` on User.computing_id = Faculty.computing_id
                                 where `Department` like '%$keyword%' or `Name` like '%$keyword%' ");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
    }
    else{
        global $db; 
        $statement = $db->prepare("select `Department`, `Name`, User.computing_id, User.Profile_Picture from `Faculty` join `User` on User.computing_id = Faculty.computing_id ");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
    }
    ?>

    <br>
    <p class = "text-decoration-underline" style = "text-align: center; font-size: 25px;">
        Club Hub Faculty Search
    </p>
    <br>
    <form name=facultySearch action=facultySearch.php method="GET" style="text-align: center">
        <div class = "row mb-4 mx-3">
            <input type = "text" class = "form-control" name = "keyword" style = "border: 2px solid black;" placeholder = "Search Faculty..."/>
        </div>
        <input type = "submit" class = "btn" name = "actionBtn" value = "Search Faculty"
        title = "Search" style = "width: 10%; display: block; margin: auto; background-color: #E57200; color: #232D4B;"
        />
    </form>

    <div class="container mt-5" style="text-align: center">
        <?php
            if ($results) {
                foreach ($results as $row) {
                    echo '<div class="card mx-auto" style="width: 18rem; text-align: center">';
                    echo '&nbsp';
                    if($row['Profile_Picture'] == null){
                        echo '<div class="d-flex justify-content-center">';
                        echo '<img class = "rounded-circle account-img card-img-top" src = "https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg?20200418092106" style = "height: 120px; width: 120px;">';
                        echo '</div>'; 
                    }
                    else{
                        echo '<div class="d-flex justify-content-center">';
                        echo '<img class = "rounded-circle account-img" src="data:image/jpeg;base64,'.base64_encode($row['Profile_Picture']).'" style = "text-align: center; width: 120px; height: 120px;">';
                        echo '</div>';  
                    }
                        echo '<div class="card-body">';
                            echo '<h5 class="card-title" style="font-size:18px"> <a href = "profilePage.php?user=' . $row['computing_id'] . '">' . $row['Name'] . ' (' . $row['computing_id'] . '@virginia.edu)' . '</a> </h5>';
                                echo '<p class="card-text" style="font-size:12px">' . $row['Department'] . '</p>';
                        echo '</div>';
                    echo '</div>';
                    echo '<br>';
                }
            } else {
                echo '<h3>No search results found...</h3>';
            }
        ?>
    </div>

    </body>
</html>