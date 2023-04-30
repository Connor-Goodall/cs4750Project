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
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Yes")){
                deleteClub_MemberOf_Relationship($_POST['id']);
                deleteClub_Sponsors_Relationship($_POST['id']);
                deleteClub_Leads_Relationship($_POST['id']);
                deleteClub_Plans_Relationship($_POST['id']);
                $posts = getPostsFromClub($_POST['id']);
                foreach ($posts as $post) {
                    deleteEvent($post['Post_ID']);
                    deletePost_Plans_Relationship($post['Post_ID']);
                    deletePost_Faculty_Attending_Relationship($post['Post_ID']);
                    deletePost_Students_Attending_Relationship($post['Post_ID']);
                    deletePost_Likes_Relationship($post['Post_ID']);
                    deletePost($post['Post_ID']);  
                }  
                deleteClub($_POST['id']);
                header("location: clubSearch.php");
                exit();
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
        <body style = "background: #232D4B; font-family: Lato; color: #E57200;">
            <?php include("header.php") ?>
            &nbsp
            <div style = "position:absolute; top: 40%; right:0; left:0;">
                <p style = "text-align:center; font-size: 20px;">
                    Are you sure you want to delete this club? (<?php echo $club['Name']; ?>)
                    &nbsp
                </p>
                <div style = "text-align:center;">
                    <form action = "deleteClub.php" method = "post" style = "display:inline-block;"     >
                        <input type='hidden' name='id' value=<?php echo $club['Club_ID'];?> />
                        <input type = "submit" name = "actionBtn" value = "Yes" class = "btn btn-dark" 
                        title = "Click Yes to delete this club" style = "margin-right:100px;"/>
                    </form>
                    <form action = "clubPage.php?id=<?php echo $_POST['id']; ?>" method = "post" style = "display:inline-block;">
                        <input type = "submit" class = "btn btn-danger" name = "actionBtn" value = "No" 
                            title = "Click no to return to the club page"/>
                    </form>
                </div>
            </div>
        </body>
</html>