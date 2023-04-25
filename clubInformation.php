<?php 
    require("connect-db.php");
    require("club-db.php");
    session_start();
    $user = null;
    $student = null;
    $faculty = null;
    $club = null;
    $userSponsor = null;
    if(!isset($_SESSION['user'])){
        header('login.php');
    }
    else {
        $user = getUser($_SESSION['computingID']);
        $student = getStudent($_SESSION['computingID']);
        $faculty = getFaculty($_SESSION['computingID']); 
        $userSponsor = getSponsor($_SESSION['computingID'], $_POST['id']);
        $club = getClub($_GET['id']);
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Sponsor This Club"))
            {
                addSponsor($_SESSION['computingID'], $_POST['id']);
                header('Location: clubPage.php?id=' . $_POST['id']);
            }
            else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Remove Your Sponsor")){
                deleteSponsor($_SESSION['computingID'], $_POST['id']);
                header('Location: clubPage.php?id=' . $_POST['id']);
            }
            else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Join This Club")){
                addMember($_POST['id'], $_SESSION['computingID']);
                header('Location: clubPage.php?id=' . $_POST['id']);
            }
            else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Leave This Club")){
                deleteMember($_SESSION['computingID'], $_POST['id']);
                header('Location: clubPage.php?id=' . $_POST['id']);
            }
        }
    }
?>