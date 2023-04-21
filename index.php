<?php 
require("connect-db.php");
require("club-db.php");
error_reporting(E_ERROR | E_PARSE);

function getUserPosts ($ID)  // given a search for a club name, returns relevant info about all the posts created by that club
{
    global $db;
    $query = "SELECT `Title`, `Body_Text`, `Name`, `Post_Date`, `Picture`, `Upvotes`, `Downvotes`, `Post_ID`, p.computing_id AS author 
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

function upvote($pid){
    global $db;
    $query = "UPDATE Post SET `Upvotes` = `Upvotes` + 1 WHERE `Post_ID`= :pid;";
    $statement = $db->prepare($query);
    $statement->bindValue(':pid', $pid);
    $statement->execute();
    $statement->closeCursor();
}

function downvote($pid){
    global $db;
    $query = "UPDATE Post SET `Downvotes` = `Downvotes` + 1 WHERE `Post_ID`= :pid;";
    $statement = $db->prepare($query);
    $statement->bindValue(':pid', $pid);
    $statement->execute();
    $statement->closeCursor();
}

function printPosts ($array, $ID) // prints each post
{
    
    if ($array) {
        $firstClub = $array[0]['Name'];
        echo '<h3 style="text-align: center">Posts by ' . $firstClub . '<h3>';

        foreach ($array as $row) {
           if ($row['Name'] != $firstClub){
            echo '<h3 style="text-align: center" >Posts by ' . $row['Name'] . '<h3>';
            $firstClub = $row['Name'];
           }
           $pid = $row['Post_ID'];

                echo '<div class="card mx-auto" style="width: 50rem; text-align: center">';
                echo '<div class="card-body">';
                    echo '<h5 class="card-title" style="font-size:22px">' . $row['Title'] . '</h5>';
                    echo '<p class="text-muted" style="font-size:12px"> Posted:  '. $row['Post_Date'] . ' by '. $row['author'] . '</p>';
                    echo '<p class="card-text" style="font-size:18px">' . $row['Body_Text'] . '</p>';
                    echo '<div style="text-align:  left">';
                    echo '<div  class = "btn-group";>';
                        echo '<form action = "index.php" method = "post"> 
                            <input type = "hidden" name = "upbtn" value='.$pid . '>
                            <input type = "submit" class = "btn btn-success mx-2" data-inline="true" name = "actionBtn" value = "Upvotes:  ' . $row['Upvotes'] .'"/>
                            </form>'; 
                        echo '<form action = "index.php" method = "post"> 
                        <input type = "hidden" name = "downbtn" value='.$pid . '>
                        <input type = "submit" class = "btn btn-danger" data-inline="true" name = "actionBtn" value = "Downvotes:  ' . $row['Downvotes'] . '"/>
                        </form>';  
                echo '</div>';
                echo '</div>';
                if($row['author'] == $ID){
                    echo '<form action = "updatePost.php" method = "POST" style = "display:inline-block;" >
                    <input type="hidden" name="id" value='.$row['Post_ID'] . '/>
                    <input type = "submit" name = "actionBtn" value = "Update Post" class = "btn btn-dark" 
                    title = "Click to update information about your post"/>
                    </form>';
                } 
                echo '</div>';
            echo '</div>';
            echo '</div>';
           
        }
    } else {
        echo '<h3>No posts found</h3>';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["upbtn"]) {
        upvote($_POST["upbtn"]);
    }
    if ($_POST["downbtn"]){
        downvote($_POST["downbtn"]);
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
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
else{
    $user = getUser($_SESSION['computingID']);
}
$ID = $user['computing_id'];   
$posts = getUserPosts($ID);
printPosts($posts, $ID);

?>



</html>