<?php 
    require("connect-db.php");
    require("club-db.php");
    session_start();
    function addRSVP($compID, $pid, $speaking){
        global $db;
        if(getStudent($compID)){
            $query = "INSERT INTO Students_Attending VALUES (:is_speaker, :Post_ID, :computing_id)";
            $statement = $db->prepare($query);
            $statement->bindValue(':Post_ID', $pid);
            $statement->bindValue(':computing_id', $compID);
            $statement->bindValue(':is_speaker', $speaking);
            $statement->execute();
            $statement->closeCursor();
        }else{//is faculty
            $query = "INSERT INTO Faculty_Attending VALUES (:computing_id, :Post_ID, :is_speaker)";
            $statement = $db->prepare($query);
            $statement->bindValue(':Post_ID', $pid);
            $statement->bindValue(':computing_id', $compID);
            $statement->bindValue(':is_speaker', $speaking);
            $statement->execute();
            $statement->closeCursor();
        }

    }

    $event = null;
    if(!isset($_SESSION['user'])){
        header("Location: login.php");
    }
    else{
        $user = getUser($_SESSION['computingID']);

    }
    $resDisplay = 'none';
    $display = 'position:relative';
    if(!hasRSVP($_SESSION['pid'], $_SESSION['computingID']) && isset($_SESSION['pid'])){
        $event = getEvent($_SESSION['pid']);
    }else if(isset($_SESSION['pid'])){
        $display = 'none';
        echo '<b>Already RSVP\'d to the event!</b>';
    }else{
        header("Location: index.php");
    }
    //Adds the post to the database ---also adds the event if needed
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Submit RSVP")){
            if($_POST['isAttending'] == "Yes"){
                $speaking = 0;
                if($_POST['isSpeaking'] == "Yes"){
                    $speaking = 1;
                }
                addRSVP($_SESSION['computingID'], $_SESSION['pid'], $speaking);
            }
            $display = 'none';
            $resDisplay = 'position:relative';
            $_SESSION['pid'] = null;
            
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
</head>
<body style = "background: #5be7a9; font-family: Lato;" style = "position:absolute; top: 20%; text-align: center;">
    <?php include("header.php") ?>
    <br>
    <?php echo '<p class = "text-decoration-underline" style = "font-size: 25px;" >' . $event['Title'] . ' RSVP FORM:</p>';?>
<form name = "rsvpForm" enctype="multipart/form-data" action = "rsvp.php" method = "post" style = "display:<?php echo $display; ?>;">
    <div class = "row mb-4 mx-3">
        Will you be attending?*
        <select id = "attending" name = "isAttending"  
            style = "border: 2px solid black; height: 35px;">
            <option value = "No"> No, I cannot be there. </option>
            <option value = "Yes"> Yes, I'll be there! </option>
        </select>
        <small id = "attendingQuestionInfo" class = "form-text text-muted" style="color:black !important; text-align:left; "> 
            Required.
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Will you be speaking at the event?*
        <select id = "speaking" name = "isSpeaking"  
            style = "border: 2px solid black; height: 35px;">
            <option value = "No"> No. </option>
            <option value = "Yes"> Yes, I'll be speaking! </option>
        </select>
        <small id = "speakingInfo" class = "form-text text-muted" style="color:black !important; text-align:left; "> 
            Required.
        </small> 
    </div>
    <div class="row mb-4 mx-3">
      <input type = "submit" class = "btn btn-dark" name = "actionBtn" value = "Submit RSVP" 
        title = "Click to submit" style = "width: 10%; display: block; margin: auto;"/>
    </div>
</form>
<b class = "text" style = "font-size: 25px; display:<?php echo $resDisplay; ?>"> RSVP Form Submitted! </b>

</body>
</html>
