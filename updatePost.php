<?php 
    require("connect-db.php");
    require("club-db.php");
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location: index.php");
    }
    else{
        $user = getUser($_SESSION['computingID']);
        $post = getPost($_POST['id']);
        if($post == null){
            header("Location: index.php");
        }
        else{
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Confirm Update")){
                    if (count($_FILES) > 0) {
                        if (is_uploaded_file($_FILES['postPicture']['tmp_name'])) {
                            $imgData = file_get_contents($_FILES['postPicture']['tmp_name']);
                        }
                    }
                    if($imgData != null){
                        updatePost($_POST['id'], $_POST['postTitle'], $_POST['postBody'], $imgData);
                    }
                    else{
                        updatePost($_POST['id'], $_POST['postTitle'], $_POST['postBody'], $post['Picture']);
                    }
                header("location: ".$_POST['source']);
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
        </head>
        <body style = "background: #5be7a9;">
        <?php include("header.php") ?>
            &nbsp
            <p class = "text-decoration-underline" style = "text-align: center; font-size: 25px;">
                Post Update Page
            </p>
            <form enctype="multipart/form-data" name = "updatePostForm" action = "updatePost.php" method = "post" style = "position:absolute; top: 20%; right:0;
            left:0;">
                <div class = "row mb-2 mx-2">
                    Post Picture <br/>
                    <input id="image" type="file" name="postPicture"/>
                </div>
                <div class = "row mb-4 mx-3">
                    Title <br/>
                    <input type = "text" class = "form-control" name = "postTitle"
                        style = "border: 2px solid black;" value = "<?php if ($post != null) echo $post['Title']; ?>"
                    />
                </div>
                <div class = "row mb-4 mx-3">
                    Body Text <br/>
                    <textarea type = "text" class = "form-control" name = "postBody"
                        style = "border: 2px solid black;"><?php if ($post != null) echo $post['Body_Text']; ?></textarea>
                </div>
                <div class="row mb-4 mx-3">
                    <input type="hidden" name="id" value= <?php echo $post['Post_ID']; ?> />
                    <input type="hidden" name="source" value= <?php echo $_POST['updateSource']; ?> />
                    <input type = "submit" class = "btn btn-dark" name = "actionBtn" value = "Confirm Update" 
                        title = "Click to update post" style = "width: 20%; display: block; margin: auto;"
                    />
                    </div>
            </form>
        </body>
</html>