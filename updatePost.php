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
        $event = getEvent($_POST['id']);
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
                    if($event != null){
                        updateEvent($_POST['id'], $_POST['eventMeetingTime'], $_POST['eventLocation'], $_POST['eventPartnerships']);
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
                <?php if($event != null) : ?>
                    <div class = "row mb-4 mx-3">
                        Meeting Time <br/>
                        <input type="datetime-local" class = "form-control" name="eventMeetingTime" id="eventTime" min="<?=date('Y-m-d h:i', time())?>" 
                        value = "<?php if ($event != null) echo $event['Event_Meeting_Time']; ?>" />
                    </div>
                    <div class = "row mb-4 mx-3">
                        Event Location <br/>
                        <input type = "text" class = "form-control" name = "eventLocation"
                            style = "border: 2px solid black;" value = "<?php if ($event != null) echo $event['Event_Location']; ?>"
                        />
                    </div>
                    <div class = "row mb-4 mx-3">
                        Partnerships <br/>
                        <input type = "text" class = "form-control" name = "eventPartnerships"
                            style = "border: 2px solid black;" value = "<?php if ($event != null) echo $event['Partnerships']; ?>"
                        />
                    </div>
                <?php endif; ?>
                <div class="row mb-4 mx-3">
                    <input type="hidden" name="id" value= <?php echo $post['Post_ID']; ?> />
                    <input type="hidden" name="source" value= <?php echo $_POST['updateSource']; ?> />
                    <input type = "submit" class = "btn" name = "actionBtn" value = "Confirm Update" 
                        title = "Click to update post" style = "width: 20%; display: block; margin: auto; background-color: #E57200; color: #232D4B;"
                    />
                    </div>
            </form>
        </body>
</html>