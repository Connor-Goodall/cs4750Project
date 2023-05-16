<?php 
require("connect-db.php");
require("club-db.php");
$upvotesArray = array(-1, -2);
error_reporting(E_ERROR | E_PARSE);

function getUserPosts ($ID)  // given a search for a club name, returns relevant info about all the posts created by that club
{
    global $db;
    //if student
    if(getStudent($ID)){
        $query = "SELECT `Title`, `Body_Text`, `Name`, `Post_Date`, `Picture`, `Upvotes`, `Downvotes`, `Post_ID`, p.computing_id AS author 
        FROM `Post` AS p NATURAL JOIN `Club` INNER JOIN `MemberOf` AS m ON m.Club_ID = p.Club_ID WHERE m.computing_id = :computingID ORDER BY `Name`,  `Post_Date`";
        $statement = $db->prepare($query);
        $statement->bindValue(':computingID', $ID);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $results;
    }
    //if faculty
    $query = "SELECT `Title`, `Body_Text`, `Name`, `Post_Date`, `Picture`, `Upvotes`, `Downvotes`, `Post_ID`, p.computing_id AS author 
    FROM `Post` AS p NATURAL JOIN `Club` INNER JOIN `Sponsors` AS s ON s.Club_ID = p.Club_ID WHERE s.computing_id = :computingID ORDER BY `Name`,  `Post_Date`";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $ID);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $results;
    

}
function getUserEvents ($ID) 
{
    global $db;
    if(getStudent($ID)){
        $query = "SELECT `Title`, `Body_Text`, `Name`, `Post_Date`, `Picture`, `Upvotes`, `Downvotes`, `Post_ID`, p.computing_id AS author 
        FROM `Post` AS p NATURAL JOIN `Club` NATURAL JOIN `Event` INNER JOIN `MemberOf` AS m ON m.Club_ID = p.Club_ID WHERE m.computing_id = :computingID ORDER BY `Name`,  `Post_Date`";
        $statement = $db->prepare($query);
        $statement->bindValue(':computingID', $ID);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $results;
    }
    $query = "SELECT `Title`, `Body_Text`, `Name`, `Post_Date`, `Picture`, `Upvotes`, `Downvotes`, `Post_ID`, p.computing_id AS author 
    FROM `Post` AS p NATURAL JOIN `Club` NATURAL JOIN `Event` INNER JOIN `Sponsors` AS s ON s.Club_ID = p.Club_ID WHERE s.computing_id = :computingID ORDER BY `Name`,  `Post_Date`";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $ID);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $results;
    
}
// home page has my bulletin
// club info page has a button for the clubs individual bulletin page
function verify_like($computing_id, $pid) {
    global $db;
    $query = "SELECT * FROM `likes` WHERE `computing_id`= :computing_id AND `Post_ID`= :pid";
    $statement = $db->prepare($query);
    $statement->bindValue(':computing_id', $computing_id);
    $statement->bindValue(':pid', $pid);
    $statement->execute();
    $results = $statement->fetch();
    $statement->closeCursor();
    return $results;
       
}

function upvote($pid, $ID){
    $check = verify_like($ID, $pid);
    if ($check == null){
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
    else if($check['Dislike'] == 0){
        global $db;
        $query = "UPDATE Post SET `Upvotes` = `Upvotes` - 1 WHERE `Post_ID`= :pid;";
        $statement = $db->prepare($query);
        $statement->bindValue(':pid', $pid);
        $statement->execute();
        $query2 = "DELETE FROM `likes` WHERE `Post_ID`= :pid AND `computing_id`= :ID;";
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
    if ($check == null) {
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
    else if($check['Dislike'] == 1){
        global $db;
        $query = "UPDATE Post SET `Downvotes` = `Downvotes` - 1 WHERE `Post_ID`= :pid;";
        $statement = $db->prepare($query);
        $statement->bindValue(':pid', $pid);
        $statement->execute();
        $query2 = "DELETE FROM `likes` WHERE `Post_ID`= :pid AND `computing_id`= :ID;";
        $statement = $db->prepare($query2);
        $statement->bindValue(':ID', $ID);
        $statement->bindValue(':pid', $pid);
        $statement->execute();
        $statement->closeCursor();
        header("refresh", 0); 
    }
    
}




function printPosts ($array, $ID, $filterEvent) // prints each post
{
    
    if ($array) {
        $firstClub = $array[0]['Name'];
        if($filterEvent == 1){
            echo '<h3 style="text-align: center">Events by ' . $firstClub . '<h3>';
        }
        else{
            echo '<h3 style="text-align: center">Posts by ' . $firstClub . '<h3>';    
        }

        foreach ($array as $row) {
           if ($row['Name'] != $firstClub){
            if($filterEvent == 1){
                echo '<h3 style="text-align: center" >Events by ' . $row['Name'] . '<h3>';
            }
            else{
                echo '<h3 style="text-align: center" >Posts by ' . $row['Name'] . '<h3>';
            }
            $firstClub = $row['Name'];
           }
           $pid = $row['Post_ID'];
           $check = verify_like($ID, $pid);
           if(checkEvent($pid)){//if event
                $event = getEvent($pid);
                echo '<div class="card mx-auto" style="width: 50rem; text-align: center; background: #232D4B; border-width: 5px; border-color: black;">';
                echo '<div class="card-body">';
                    echo '<h5 class="card-title" style="font-size:22px"> <b>' . $row['Title'] . ' </b></h5>';
                    echo '<p class="text-muted" style="font-size:12px"> Event Posted:  '. $row['Post_Date'] . ' by '. $row['author'] . '</p>';
                    echo '<p class="card-text" style="font-size:18px">' . $row['Body_Text'] . '</p>';
                    if($row['Picture'] != null){
                        echo '<div class="d-flex justify-content-center">';
                        echo '<img src="data:image/jpeg;base64,'.base64_encode($row['Picture']).'" style = "width: 100%; height: 20vw; object-fit: scale-down;" class = "card-img-top">';
                        echo '</div>'; 
                    }
                    echo '<div style="text-align:  left">';
                    echo '<div  class = "btn-group";>';
                        echo '<form action = "index.php" method = "post"> 
                            <input type = "hidden" name = "upbtn" value='.$pid. '>
                            <button type = "submit" class = "btn" data-inline="true" name = "actionBtn">'; 
                                if($check['Dislike'] == 0 && $check != null){
                                    echo '<i class="fas fa-long-arrow-alt-up" style = " font-size: 36px; color: #4BB543; -webkit-text-stroke-width: 1px;-webkit-text-stroke-color: #000000;"></i>';
                                }
                                else{
                                    echo '<i class="fas fa-long-arrow-alt-up" style = " font-size: 36px; color: transparent; -webkit-text-stroke-width: 1px;-webkit-text-stroke-color: #000000;"></i>';
                                }
                                echo '<p style = "font-size: 15px; color: #E57200;">  ';
                                echo $row['Upvotes'];
                            echo '</p></button>
                            </form>'; 
                        echo '<form action = "index.php" method = "post"> 
                        <input type = "hidden" name = "downbtn" value='. $pid . '>
                        <button type = "submit" class = "btn" data-inline="true" name = "actionBtn" style = "margin-right:350px;">';
                            if($check['Dislike'] == 1){
                                echo '<i class="fas fa-long-arrow-alt-down" style = " font-size: 36px; color: #FF0000; -webkit-text-stroke-width: 1px;-webkit-text-stroke-color: #000000;"></i>';
                            }
                            else{
                                echo '<i class="fas fa-long-arrow-alt-down" style = " font-size: 36px; color: transparent; -webkit-text-stroke-width: 1px;-webkit-text-stroke-color: #000000;"></i>';
                            }
                            echo '<p style = "font-size: 15px; color: #E57200;">  ';
                            echo $row['Downvotes'];
                        echo '</p></button>
                        </form>';  
                    if($row['author'] == $ID){
                        echo '<form action = "updatePost.php" method = "POST" style = "display:inline-block;" >
                        <input type="hidden" name="id" value='.$row['Post_ID'] . '/>
                        <input type="hidden" name="updateSource" value= "index.php"/>
                        <input type = "submit" name = "actionBtn" value = "Update Post" class = "btn btn-dark" 
                        title = "Click to update information about your post" style = "margin-right:50px;"/>
                        </form>';
                        echo '<form action = "deletePost.php" method = "post" style = "display:inline-block;">
                        <input type="hidden" name="id" value='.$row['Post_ID'] . '/>
                        <input type="hidden" name="deleteSource" value= "index.php"/>
                        <input type = "submit" class = "btn btn-danger" name = "actionBtn" value = "Delete" 
                                    title = "Click to Delete post"/>
                        </form>';
                    } 
                echo '</div>';
                echo '</div>';
                //event info
                echo '<div class="card-body">';
                    echo '<hr style="border: 1px #5be7a9; width: 50%; margin: auto;">';
                    echo '<h5 class="card-title" style="font-size:22px"> <b>  Event Information: </b>  </h5>';
                    echo '<p class="card-text" style="font-size:18px"><u> Event Location: </u> ' . $event['Event_Location'] . '</p>';
                    echo '<p class="card-text" style="font-size:18px"> <u> Event Time: </u> ' . date("l\, F jS, Y \@ h:iA", strtotime($event['Event_Meeting_Time'])) . '</p>';
                    echo '<p class="card-text" style="font-size:18px"> <u>  Partnerships: </u> ' . $event['Partnerships'] . '</p>';
                if(!hasRSVP($pid, $ID)){//if user has not submitted an rsvp yet
                    echo '<div style="text-align:  center">';
                    echo '<div  class = "btn-group";>';
                            echo '<form action = "index.php" method = "post">
                                <input type="hidden" name="pid" value='. $pid .'>
                                <input type = "submit" class = "btn btn-info" data-inline="true" name = "actionBtn" value = "RSVP"/>
                                </form>'; 
                    echo '</div>';
                    echo '</div>';
                }else{
                    echo '<b class="card-text" style="font-size:18px">Attending :)</b>';
                    echo '<br/>';
                    echo '<div  class = "btn-group";>';
                        echo '<form action = "index.php" method = "post">
                        <input type="hidden" name="pid" value='. $pid .'>
                        <input type = "submit" class = "btn btn-danger" data-inline="true" name = "actionBtn" value = "Un-RSVP" style = "margin-right:50px;"/>
                        </form>'; 
                        echo '<form action = "updateRSVP.php" method = "post">
                        <input type="hidden" name="pid" value='. $pid .'>
                        <input type = "submit" class = "btn btn-dark" data-inline="true" name = "actionBtn" value = "Update RSVP"/>
                        </form>'; 
                        echo '</div>';
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
           }else{
            echo '<div class="card mx-auto" style="width: 50rem; text-align: center; background: #232D4B; border-width: 5px; border-color: black;"">';
            echo '<div class="card-body">';
                echo '<h5 class="card-title" style="font-size:22px">' . $row['Title'] . '</h5>';
                echo '<p class="text-muted" style="font-size:12px"> Posted:  '. $row['Post_Date'] . ' by '. $row['author'] . '</p>';
                echo '<p class="card-text" style="font-size:18px">' . $row['Body_Text'] . '</p>';
                echo '<div style="text-align:  left">';
                echo '<div  class = "btn-group";>';
                    echo '<form action = "index.php" method = "post"> 
                    <input type = "hidden" name = "upbtn" value='.$pid. '>
                    <button type = "submit" class = "btn" data-inline="true" name = "actionBtn">'; 
                        if($check['Dislike'] == 0 && $check != null){
                            echo '<i class="fas fa-long-arrow-alt-up" style = " font-size: 36px; color: #4BB543; -webkit-text-stroke-width: 1px;-webkit-text-stroke-color: #000000;"></i>';
                        }
                        else{
                            echo '<i class="fas fa-long-arrow-alt-up" style = " font-size: 36px; color: transparent; -webkit-text-stroke-width: 1px;-webkit-text-stroke-color: #000000;"></i>';
                        }
                        echo '<p style = "font-size: 15px; color: #E57200;">  ';
                        echo $row['Upvotes'];
                    echo '</p></button>
                    </form>'; 
                        echo '<form action = "index.php" method = "post"> 
                        <input type = "hidden" name = "downbtn" value='. $pid . '>
                        <button type = "submit" class = "btn" data-inline="true" name = "actionBtn" style = "margin-right:350px;">';
                            if($check['Dislike'] == 1){
                                echo '<i class="fas fa-long-arrow-alt-down" style = " font-size: 36px; color: #FF0000; -webkit-text-stroke-width: 1px;-webkit-text-stroke-color: #000000;"></i>';
                            }
                            else{
                                echo '<i class="fas fa-long-arrow-alt-down" style = " font-size: 36px; color: transparent; -webkit-text-stroke-width: 1px;-webkit-text-stroke-color: #000000;"></i>';
                            }
                            echo '<p style = "font-size: 15px; color: #E57200;">  ';
                            echo $row['Downvotes'];
                        echo '</p></button>
                        </form>';  
                
                if($row['author'] == $ID){
                    echo '<form action = "updatePost.php" method = "POST" style = "display:inline-block;" >
                    <input type="hidden" name="id" value='.$row['Post_ID'] . '/>
                    <input type="hidden" name="updateSource" value= "index.php"/>
                    <input type = "submit" name = "actionBtn" value = "Update Post" class = "btn btn-dark" 
                    title = "Click to update information about your post" style = "margin-right:100px;"/>
                    </form>';
                    echo '<form action = "deletePost.php" method = "post" style = "display:inline-block;">
                    <input type="hidden" name="id" value='.$row['Post_ID'] . '/>
                    <input type="hidden" name="deleteSource" value= "index.php"/>
                    <input type = "submit" class = "btn btn-danger" name = "actionBtn" value = "Delete" 
                                title = "Click to Delete post"/>
                    
                    </form>';
                } 
            echo '</div>';
            echo '</div>'; 
            echo '</div>';
            echo '</div>';
            }
        echo '&nbsp';  
        }
    } else {
        echo '<h3>No posts found</h3>';
    }
}
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
else{
    $user = getUser($_SESSION['computingID']);
}
$ID = $user['computing_id'];   
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["upbtn"]) {
        upvote($_POST["upbtn"], $ID);
    }
    if ($_POST["downbtn"]){
        downvote($_POST["downbtn"], $ID);
    }
    if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Filter")){
        if($_POST['filterPost'] == "Post"){
            $filterEvent = 0;
        }
        else if($_POST['filterPost'] == "Event"){
            $filterEvent = 1;
        }
    }
    if($_POST["pid"]){
        if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "RSVP")){
            $_SESSION['pid'] = $_POST["pid"];
            header("Location: rsvp.php");
        }
        else if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Un-RSVP")){
            if(getStudent($_SESSION['computingID']) != null){
                deleteStudentAttendee($_SESSION['computingID'], $_POST['pid']);
            }
            else{
                deleteFacultyAttendee($_SESSION['computingID'], $_POST['pid']);  
            }
        }
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
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">

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
<h1 style="text-align: center"> Welcome to your Bulletin Page!</h1>
<h4 style="text-align: center">Check out what your clubs have been up to </h4>
<div style = "text-align: center">
    <form action = "index.php" method = "post" style = "display: inline-block;">
        Filter By?
        <div class = "row mb-4 mx-3">
            <select id = "filterPost" name = "filterPost"  
                                style = "border: 2px solid black; width: 200px;">
                                <?php if ($_POST['filterPost'] == "Event") : ?>
                                    <option value = "Event"> Event </option>
                                    <option value = "Post"> Post </option>
                                <?php else : ?>
                                    <option value = "Post"> Post </option>
                                    <option value = "Event"> Event </option>
                                <?php endif ?>
            </select>
        </div>
        <div class = "row mb-4 mx-auto">
            <input type = "submit" name = "actionBtn" value = "Filter" class = "btn" title = "Click to filter your posts" style = "background-color: #E57200; color: #232D4B;"/>
        </div>
    </form>
</div>
<?php 
    if($filterEvent == 0){
        $posts = getUserPosts($ID);
        printPosts($posts, $ID, $filterEvent);
    }
    else{
        $events = getUserEvents($ID); 
        printPosts($events, $ID, $filterEvent);
    }
?>

</html>