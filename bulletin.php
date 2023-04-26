<?php
require("club-db.php");
error_reporting(E_ERROR | E_PARSE);


function findPosts ($name)  // given a search for a club name, returns relevant info about all the posts created by that club
{
    $l = "%";
    $regex = $l.$name.$l;
    global $db;
    $query = "SELECT `Name`, `Title`, `Body_Text`, `Post_Date`, `Picture`, `Upvotes`, `Post_ID`, `Downvotes` FROM `Post` 
    NATURAL JOIN `Club` WHERE Club.Name LIKE :Regex OR Club.Nickname LIKE :Regex";
    $statement = $db->prepare($query);
    $statement->bindValue(':Regex', $regex);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $results;

}
function verify_like($computing_id, $pid) {
    global $db;
        $query = "SELECT * FROM `likes` WHERE `computing_id` = :computing_id AND `Post_ID` = :pid";
        $statement = $db->prepare($query);
        $statement->bindValue(':computing_id', $computing_id);
        $statement->bindValue(':pid', $pid);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        if (!$results){
            // no like/dislike has occured
            return FALSE;
        }
        else {
            return TRUE;
        }
       
        }





function upvote($pid, $ID){
    $check = verify_like($ID, $pid);
    if (!$check){
        global $db;
        $query = "UPDATE Post SET `Upvotes` = `Upvotes` + 1 WHERE `Post_ID`= :pid;";
        $statement = $db->prepare($query);
        $statement->bindValue(':pid', $pid);
        $statement->execute();
        $query2 = "INSERT INTO `likes`(`computing_id`, `Post_ID`, `Dislike`) VALUES (:ID,:pid,0)";
        $statement = $db->prepare($query2);
        $statement->bindValue(':ID', $ID);
        $statement->bindValue(':pid', $pid);
        $statement->execute();
        $statement->closeCursor();
        header("refresh", 0);
        
    }
    
    
}

function downvote($pid, $ID){
    $check = verify_like($ID, $pid);
    if (!$check) {
        global $db;
        $query = "UPDATE Post SET `Downvotes` = `Downvotes` + 1 WHERE `Post_ID`= :pid;";
        $statement = $db->prepare($query);
        $statement->bindValue(':pid', $pid);
        $statement->execute();
        $query2 = "INSERT INTO `likes`(`computing_id`, `Post_ID`, `Dislike`) VALUES (:ID,:pid,1)";
        $statement = $db->prepare($query2);
        $statement->bindValue(':ID', $ID);
        $statement->bindValue(':pid', $pid);
        $statement->execute();
        $statement->closeCursor();
        header("refresh", 0);
        
    }
    
}

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
           $pid = $row['Post_ID'];

                echo '<div class="card mx-auto" style="width: 50rem; text-align: center">';
                echo '<div class="card-body">';
                    echo '<h5 class="card-title" style="font-size:22px">' . $row['Title'] . '</h5>';
                    echo '<p class="text-muted" style="font-size:12px"> Posted:  '. $row['Post_Date'] . ' by '. $row['author'] . '</p>';
                    echo '<p class="card-text" style="font-size:18px">' . $row['Body_Text'] . '</p>';
                    echo '<div style="text-align:  left">';
                    echo '<div  class = "btn-group";>';
                        echo '<form action = "bulletin.php" method = "post"> 
                            <input type = "hidden" name = "upvotebtn" value='.$pid. '>
                            <input type = "hidden" name = "clubName" value =' .$row['Name'] . '>
                            <input type = "submit" class = "btn btn-success mx-2" data-inline="true" name = "actionBtn" value = "Upvotes:  ' . $row['Upvotes'] .'"/>
                            </form>'; 
                        echo '<form action = "bulletin.php" method = "post"> 
                        <input type = "hidden" name = "downvotebtn" value='.$pid . '>
                        <input type = "hidden" name = "clubName" value =' . $row['Name'] . '>
                        <input type = "submit" class = "btn btn-danger" data-inline="true" name = "actionBtn" value = "Downvotes:  ' . $row['Downvotes'] . '"/>
                        </form>';  
                echo '</div>';
                echo '</div>'; 
                echo '</div>';
                if($row['author'] == $ID){
                    echo '<form action = "updatePost.php" method = "POST" style = "display:inline-block; text-align: center;" >
                    <input type="hidden" name="id" value='.$row['Post_ID'] . '/>
                    <input type="hidden" name="updateSource" value= "bulletin.php"/>
                    <input type = "submit" name = "actionBtn" value = "Update Post" class = "btn btn-dark" 
                    title = "Click to update information about your post" style = "margin-right:100px;"/>
                    </form>';
                    echo '<form action = "deletePost.php" method = "post" style = "display:inline-block;">
                    <input type="hidden" name="id" value='.$row['Post_ID'] . '/>
                    <input type="hidden" name="clubName" value='.$row['Name'] . '/>
                    <input type="hidden" name="deleteSource" value= "bulletin.php"/>
                    <input type = "submit" class = "btn btn-danger" name = "actionBtn" value = "Delete" 
                                title = "Click to Delete post"/>
                    </form>';
                } 
            echo '</div>';
           
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
<h1 style = "text-align:center"> Welcome to the Bulletin Page!</h1>

<form action="bulletin.php" method="post" style = "text-align:center">
What club are you looking for? <input type="text" name="clubName">
<input type="submit" class = "btn btn-dark btn-block" style = "text-align:center">
</form>


<!-- <form action = "bulletin.php" id = "postForm" method="post">
<label for="postType">Choose a Post Type:</label>
<select name="postType" id="postType" form = "postForm">
  <option value="event" name = "event" >Event Posts</option>
  <option value="nonEvent" name = "nonEvent" >Non-Event Posts</option>
  <option value="all" name = "all" selected>All posts</option>
</select>
<input type="submit"> -->
</form>



<br>

<?php 
    if(!isset($_SESSION['user'])){
        header("Location: login.php");
    }
    else{
        $user = getUser($_SESSION['computingID']);
    }
    $ID = $user['computing_id'];
    


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST["upvotebtn"]) {
            upvote($_POST["upvotebtn"], $ID);
        }
        if ($_POST["downvotebtn"]){
            downvote($_POST["downvotebtn"], $ID);
        }
        if ($_POST["postType"]) {
            echo("postType");
            // if ($_POST["postType"] = "event"){

            // }
            // else if ($_POST["postType"] = "nonEvent") {

            // }
            // else {
            //     $_POST["clubName"] 
            // }

        }
        if ($_POST["clubName"]) {
            $clubName = $_POST["clubName"];
            $posts = findPosts($clubName);
            printPosts($posts);
        }
       
    }
}
else{
    $user = getUser($_SESSION['computingID']);
    $ID = $user['computing_id'];   
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $clubName = $_POST["clubName"];
        $posts = findPosts($clubName);
        printPosts($posts, $ID);
    }
}
?>



</html>


