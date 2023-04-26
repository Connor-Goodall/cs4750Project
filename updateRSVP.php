<?php 
    require("connect-db.php");
    require("club-db.php");
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location: index.php");
    }
    else{
        $user = getUser($_SESSION['computingID']);
        $post = getPost($_POST['pid']);
        if($post == null){
            header("Location: index.php");
        }
        else{
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Confirm Update")){
                    if(getStudent($_SESSION['computingID']) != null){
                        $currentRSVP = getStudentEnrollment($_SESSION['computingID'], $_POST['pid']);
                    }
                    else{
                        $currentRSVP = getFacultyEnrollment($_SESSION['computingID'], $_POST['pid']);
                    }
                    if($_POST['isSpeaking'] != $currentRSVP['is_speaker']){
                        if(getStudent($_SESSION['computingID']) != null){
                            if($_POST['isSpeaking'] == "Yes"){
                                updateStudentEnrollment($_SESSION['computingID'], $_POST['pid'], 1);
                            }
                            else{
                                updateStudentEnrollment($_SESSION['computingID'], $_POST['pid'], 0);  
                            }
                        }
                        else{
                            if($_POST['isSpeaking'] == "Yes"){
                                updateFacultyEnrollment($_SESSION['computingID'], $_POST['pid'], 1); 
                            }
                            else{
                                updateFacultyEnrollment($_SESSION['computingID'], $_POST['pid'], 0); 
                            } 
                        }
                    }
                    header("Location: index.php");
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
        </head>
        <body style = "background: #5be7a9; font-family: Lato;">
        <?php include("header.php") ?>
            &nbsp
            <p class = "text-decoration-underline" style = "text-align: center; font-size: 25px;">
                RSVP Update Page
            </p>
            <form enctype="multipart/form-data" name = "updateRSVPForm" action = "updateRSVP.php" method = "post" style = "position:absolute; top: 20%; right:0;
            left:0;">
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
                    <input type="hidden" name="pid" value= <?php echo $post['Post_ID']; ?> />
                    <input type = "submit" class = "btn btn-dark" name = "actionBtn" value = "Confirm Update" 
                        title = "Click to update post" style = "width: 20%; display: block; margin: auto;"
                    />
                    </div>
            </form>
        </body>
</html>