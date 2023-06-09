<?php 
    require("connect-db.php");
    require("club-db.php");
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location: index.php");
    }
    else{
        $post = getPost($_POST['id']);
        if($post == null){
            header("Location: index.php");
        }
        else{
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Yes")){
                    deleteEvent($_POST['id']);
                    deletePost_Plans_Relationship($_POST['id']);
                    deletePost_Faculty_Attending_Relationship($_POST['id']);
                    deletePost_Students_Attending_Relationship($_POST['id']);
                    deletePost_Likes_Relationship($_POST['id']);
                    deletePost($_POST['id']);                  
                    header("location: ".$_POST['source']);
                    exit();
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
        <body style = "background: #232D4B; font-family: Lato; color: #E57200;">
        <?php 
            if(!isset($_SESSION['user'])){
                include("nonuserHeader.php");
            }
            else{
                include("userHeader.php");  
            }
        ?>
            &nbsp
            <div style = "position:absolute; top: 40%; right:0; left:0;">
                <p style = "text-align:center; font-size: 20px;">
                    Are you sure you want to delete this post?
                    &nbsp
                </p>
                <div style = "text-align:center;">
                    <form action = "deletePost.php" method = "post" style = "display:inline-block;"     >
                        <input type='hidden' name='id' value=<?php echo $post['Post_ID'];?> />
                        <input type="hidden" name="source" value= <?php echo $_POST['deleteSource']; ?> />
                        <input type = "submit" name = "actionBtn" value = "Yes" class = "btn btn-dark" 
                        title = "Click Yes to delete this post" style = "margin-right:100px;"/>
                    </form>
                    <form action = <?php echo $_POST['deleteSource'] ?> method = "post" style = "display:inline-block;">
                        <?php if (isset($_POST['clubName'])) : ?>
                            <input type='hidden' name='clubName' value= <?php echo $_POST['clubName']; ?> />
                        <?php endif; ?>
                        <input type = "submit" class = "btn btn-danger" name = "actionBtn" value = "No" 
                            title = "Click no to return to the previous page"/>
                    </form>
                </div>
            </div>
        </body>
</html>