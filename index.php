<?php 
require("connect-db.php");
require("club-db.php");

function getUserPosts ($ID)  // given a search for a club name, returns relevant info about all the posts created by that club
{
    global $db;
    $query = "SELECT `Title`, `Body_Text`, `Name`, `Post_Date`, `Picture`, `Upvotes`, `Downvotes` 
    FROM `Post` AS p NATURAL JOIN `Club` INNER JOIN `MemberOf` AS m ON m.Club_ID = p.Club_ID WHERE m.computing_id = :computingID ORDER BY `Name`,  `Post_Date`";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $ID);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $results;

}

// home page has my bulletin
// club info page has a button for the clubs individual bulletin page


function printPosts ($array) // prints each post
{
    
    if ($array) {
        $firstClub = $array[0]['Name'];
        echo '<h3 style="text-align: center">Posts by ' . $firstClub . '<h3>';

        foreach ($array as $row) {
           if ($row['Name'] != $firstClub){
            echo '<h3 style="text-align: center" >Posts by ' . $row['Name'] . '<h3>';
            $firstClub = $row['Name'];
           }
                
                
                echo '<div class="card mx-auto" style="width: 50rem; text-align: center">';
                echo '<div class="card-body">';
                    echo '<h5 class="card-title" style="font-size:22px">' . $row['Title'] . '</h5>';
                    echo '<p class="text-muted" style="font-size:12px"> Posted:  '. $row['Post_Date'] . '</p>';
                    echo '<p class="card-text" style="font-size:18px">' . $row['Body_Text'] . '</p>';
                    echo '<p class="card-footer" style="font-size:15px"> Upvotes:  ' . $row['Upvotes'] . '             Downvotes:  ' . $row['Downvotes'] . '</p'; 
                echo '</div>';
            echo '</div>';
            echo '</div>';
           
            
        }
    } else {
        echo '<h3>No posts found</h3>';
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
<h1 style="text-align: center"> Welcome to your Bulletin Page!</h1>
<h4 style="text-align: center">Check out what your clubs have been up to </h4>


<?php 
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
else{
    $user = getUser($_SESSION['computingID']);
}
$ID = $user['computing_id'];   
$posts = getUserPosts($ID);
printPosts($posts);

?>



</html>