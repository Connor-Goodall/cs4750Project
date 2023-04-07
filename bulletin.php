<?php
require("connect-db.php");


function findPosts ($name)  // given a search for a club name, returns relevant info about all the posts created by that club
{
    $l = "%";
    $regex = $l.$name.$l;
    global $db;
    $query = "SELECT `Name`, `Title`, `Body_Text`, `Post_Date`, `Picture`, `Upvotes`, `Downvotes` FROM `post` 
    NATURAL JOIN `club` WHERE club.Name LIKE :Regex OR club.Nickname LIKE :Regex";
    $statement = $db->prepare($query);
    $statement->bindValue(':Regex', $regex);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $results;

}

function printPosts ($array) // prints each post
{
    
    if ($array) {
        $firstClub = $array[0]['Name'];
        echo '<h3>Showing Posts for ' . $firstClub . '<h3>';
        echo '<br>';
        foreach ($array as $row) {
            if ($row['Name'] == $firstClub) { //only show the posts for one club, which ever comes first if multiple clubs are returned by their search
                echo '<div class="card" text-align: left">';
                echo '<div class="card-body">';
                    echo '<h5 class="card-title" style="font-size:22px">' . $row['Title'] . '</h5>';
                    echo '<p class="text-muted" style="font-size:12px"> Posted:  '. $row['Post_Date'] . '</p>';
                    echo '<p class="card-text" style="font-size:18px">' . $row['Body_Text'] . '</p>';
                    echo '<p class="card-footer" style="font-size:15px"> Upvotes:  ' . $row['Upvotes'] . '             Downvotes:  ' . $row['Downvotes'] . '</p'; 
                echo '</div>';
            echo '</div>';
            }
        }
    } else {
        echo '<h3>No posts found</h3>';
    }
}

// notes:  one bulletin page for each club and a user-based bulletin page, perhaps happens after login
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
<h1> Welcome to the Bulletin Page!</h1>

<form action="bulletin.php" method="post">
What club are you looking for? <input type="text" name="clubName"><br>
<input type="submit">
</form>
<br>

<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $clubName = $_POST["clubName"];
        $posts = findPosts($clubName);
        printPosts($posts);
    }

?>



</html>


