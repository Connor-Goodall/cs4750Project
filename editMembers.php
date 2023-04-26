<?php 
    require("connect-db.php");
    require("club-db.php");
    session_start();
    $club = null;
    $userLeader = getLeader($_SESSION['computingID'], $_POST['id']);
    if(!isset($_SESSION['user']) || $userLeader == null){
        header("Location: index.php");
    }
    else{
        $club = getClub($_POST['id']);
        $leaders = getLeaders($_POST['id']);
        $members = getMembers($_POST['id']);
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Delete Member")){
                deleteMember($_POST['member_to_delete'], $_POST['id']);
                header('Location: clubPage.php?id=' . $_POST['id']);
            }
            else if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Delete Leader")){
                deleteLeader($_POST['leader_to_delete'], $_POST['id']);
                header('Location: clubPage.php?id=' . $_POST['id']);
            }
            else if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Update Role")){
                $leaderToUpdate = getLeader($_POST['leader_to_find'], $_POST['id']);
            }
            else if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Confirm Update")){
                updateLeader($_POST['leader_to_update'], $_POST['id'], $_POST['leaderRole']);
                header('Location: clubPage.php?id=' . $_POST['id']);
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
        </head>
        <body style = "background: #5be7a9;">
            <?php include("header.php") ?>
            &nbsp
            <p class = "text-decoration-underline" style = "text-align: center; font-size: 25px;">
                <?php echo $club['Name']; ?>
            </p>
            &nbsp
                <div class = "container">
                    <div class = "row">
                        <div class = "col-7">
                            <div class = "row">
                                <div class = "text-decoration-underline" style = "font-weight: bold; font-size: 20px; display: inline-block;">
                                    Leaders
                                </div>
                            </div> 
                            <?php foreach ($leaders as $leader): ?>
                                    <div class = "row" >
                                        <div class = "col-3">
                                            <div style = "display: inline-block;">
                                                <?php $leaderName = getUser($leader['computing_id']); ?>
                                                <?php echo $leaderName['Name']; ?>
                                                    <br/>
                                                <?php if ($leaderToUpdate != null && $leaderToUpdate['computing_id'] == $leader['computing_id']) : ?>
                                                    <form action = "editMembers.php" method = "post" style = "display:inline-block;">
                                                        <input type = "text" class = "form-control" name = "leaderRole"
                                                        style = "border: 2px solid black;" value = "<?php if ($leaderToUpdate != null) echo $leaderToUpdate['Exec_Role']; ?>"
                                                        />
                                            </div>
                                        </div>
                                        <div class = "col-3">
                                                            <input type='hidden' name='leader_to_update' value=<?php echo $leader['computing_id'];?> />
                                                            <input type='hidden' name='id' value=<?php echo $club['Club_ID'];?> />
                                                            <input type = "submit" class = "btn btn-dark" name = "actionBtn" value = "Confirm Update" 
                                                                title = "Click to Confirm role update"/>
                                                        </form>
                                        </div>
                                                <?php else : ?>
                                                    (<?php echo $leader['Exec_Role']; ?>)
                                            </div>
                                        </div>
                                        <div class = "col-3">
                                                <form action = "editMembers.php" method = "post" style = "display:inline-block;">
                                                    <input type='hidden' name='leader_to_find' value=<?php echo $leader['computing_id'];?> />
                                                    <input type='hidden' name='id' value=<?php echo $club['Club_ID'];?> />
                                                    <input type = "submit" class = "btn btn-dark" name = "actionBtn" value = "Update Role" 
                                                        title = "Click to Update role"/>
                                                </form>
                                        </div>
                                                <?php endif; ?>
                    
                                        <div class = "col">
                                            <form action = "editMembers.php" method = "post" style = "display:inline-block;">
                                                <input type='hidden' name='leader_to_delete' value=<?php echo $leader['computing_id'];?> />
                                                <input type='hidden' name='id' value=<?php echo $club['Club_ID'];?> />
                                                <input type = "submit" class = "btn btn-danger" name = "actionBtn" value = "Delete Leader" 
                                                    title = "Click to Delete leader"/>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                        </div>   
                        <div class = "col">
                                <div class = "row">
                                    <div class = "text-decoration-underline" style = "font-weight: bold; font-size: 20px; display: inline-block;">
                                        Members
                                    </div>
                                </div>
                                <?php foreach ($members as $member): ?>
                                    <?php if (getLeader($member['computing_id'], $club['Club_ID']) == null) : ?>
                                        <div class = "row" >
                                            <div class = "col-5">
                                                <div style = "display: inline-block;">
                                                        <?php $memberName = getUser($member['computing_id']); ?>
                                                        <?php echo $memberName['Name']; ?>
                                                </div>
                                            </div>
                                            <div class = "col">
                                                <form action = "editMembers.php" method = "post" style = "display:inline-block;">
                                                    <input type='hidden' name='member_to_delete' value=<?php echo $member['computing_id'];?> />
                                                    <input type='hidden' name='id' value=<?php echo $club['Club_ID'];?> />
                                                    <input type = "submit" class = "btn btn-danger" name = "actionBtn" value = "Delete Member" 
                                                            title = "Click to Delete member"/>
                                                </form>
                                            </div>
                                        </div>
                                        &nbsp
                                    <?php endif; ?>
                                <?php endforeach; ?>
                        </div>
                    </div>
                </div>
        </body>
</html>