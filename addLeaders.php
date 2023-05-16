<?php 
    require("connect-db.php");
    require("club-db.php");
    session_start();
    $club = null;
    $student = null;
    $leader = null;
    $tryStudent = 0;
    $sameLeader = 0;
    $userLeader = getLeader($_SESSION['computingID'], $_POST['id']);
    if(!isset($_SESSION['user']) || $userLeader == null){
        header("Location: index.php");
    }
    else{
        $club = getClub($_POST['id']);
        $leaders = getLeaders($_POST['id']);
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Confirm Leader")){
                $student = getStudent($_POST['leaderID']);
                if($student != null){
                    $leader = getLeader($_POST['leaderID'], $_POST['id']);
                    if($leader == null){
                        $member = getMember($_POST['leaderID'], $_POST['id']);
                        if($member != null){
                            addLeader($_POST['leaderID'], $_POST['id'], $_POST['leaderRole']);
                        }
                        else{
                            addMember($_POST['id'], $_POST['leaderID']);
                            addLeader($_POST['leaderID'], $_POST['id'], $_POST['leaderRole']);
                        }
                        header('Location: clubPage.php?id=' . $_POST['id']);
                    }
                    else{
                        $sameLeader = 1;
                    }
                }
                else{
                    $tryStudent = 1;
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
<body style = "background: #232D4B; font-family: Lato; color: #E57200;" style = "position:absolute; top: 20%; text-align: center;">
        <?php 
            if(!isset($_SESSION['user'])){
                include("nonuserHeader.php");
            }
            else{
                include("userHeader.php");  
            }
        ?>
    <br>
    <p class = "text-decoration-underline" style = "font-size: 25px; text-align: center;" >Add a Leader to <?php echo $club['Name'] ?> </p>
<form name = "leaderCreationForm" enctype="multipart/form-data" action = "addLeaders.php" method = "post">
    <?php if($student == null && $tryStudent == 1) : ?>
            <div class = "row mb-0 mx-3">
                <div class = "alert alert-danger">
                    <ul class = "m-0">
                        <li>
                            You have not entered a students computing ID correctly. Please enter it again.
                        </li>
                    </ul>
                </div>
            </div>
    <?php endif; ?>
    <?php if($leader != null && $sameLeader == 1) : ?>
            <div class = "row mb-0 mx-3">
                <div class = "alert alert-danger">
                    <ul class = "m-0">
                        <li>
                            Leader is already a part of the club. Please try a different computing ID.
                        </li>
                    </ul>
                </div>
            </div>
    <?php endif; ?>
    <div class = "row mb-4 mx-3">
        Computing ID <br/>
        <input type = "text" class = "form-control" name = "leaderID" maxlength = "7" 
            style = "border: 2px solid black;" placeholder = "Leader Computing ID..."
        required />
        <small class = "form-text text-muted" style="color:#E57200 !important"> Computing ID of the leader you will add. Required. 
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Role <br/>
        <input type = "text" class = "form-control" name = "leaderRole" maxlength = "255" 
            style = "border: 2px solid black;" placeholder = "Leader Role..."
        required />
        <small class = "form-text text-muted" style="color:#E57200 !important"> Role of the leader you will add (I.E. Treasurer or Vice President). Required. 
        </small> 
    </div>
    <input type='hidden' name='id' value=<?php echo $club['Club_ID'];?> />
    <div class="row mb-4 mx-3">
      <input type = "submit" class = "btn btn-dark" name = "actionBtn" value = "Confirm Leader" 
        title = "Click to confirm new leader" style = "width: 10%; display: block; margin: auto; background-color: #E57200; color: #232D4B;"/>
    </div>