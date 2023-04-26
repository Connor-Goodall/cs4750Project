<?php 
    require("connect-db.php");
    require("club-db.php");
    session_start();
    //MOVE THIS TO club-db EVENTUALLY ----------------------------------
    function getLeadingClubs($computingID){
        global $db;
        $query = "select `Exec_Role`, `Club_ID`, `Name`, `Nickname` from `Leads` NATURAL JOIN `Club` where computing_id=:id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $computingID);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        return $results;
    }
    function addPost($computingID, $clubID, $postDate, $picture, $title, $downvotes,  $body, $upvotes){
        global $db;
        $sql = "SELECT COUNT(*) FROM `Post`";
        $res = $db->query($sql);
        $postID = $res->fetchColumn();
        $query = "insert into `Post` values (:computing_id, :Club_ID, :Post_Date, :Picture, :Title, :Downvotes, :Body_Text, :Upvotes, :Post_ID)";
        $statement = $db->prepare($query);
        $statement->bindValue(':computing_id', $computingID);
        $statement->bindValue(':Club_ID', $clubID);
        $statement->bindValue(':Post_Date', $postDate);
        $statement->bindValue(':Picture', $picture);
        $statement->bindValue(':Title', $title);
        $statement->bindValue(':Downvotes', $downvotes);
        $statement->bindValue(':Body_Text', $body);
        $statement->bindValue(':Upvotes', $upvotes);
        $statement->bindValue(':Post_ID', $postID);
        $statement->execute();
        $statement->closeCursor();
        return $postID;
    }
    function addEvent($meetingTime, $location, $partnerships, $postID){
        global $db;
        $query = "insert into `Event` values (:Event_Meeting_Time, :Event_Location, :Partnerships, :Post_ID)";
        $statement = $db->prepare($query);
        //Wow that's a lot of bindValues 0_0
        $statement->bindValue(':Event_Meeting_Time', $meetingTime);
        $statement->bindValue(':Event_Location', $location);
        $statement->bindValue(':Partnerships', $partnerships);
        $statement->bindValue(':Post_ID', $postID);
        $statement->execute();
        $statement->closeCursor();
        return $postID;
    }
    //------------------------------------------------------------------
    if(!isset($_SESSION['user'])){
        header("Location: login.php");
    }
    else{
        $user = getUser($_SESSION['computingID']);
        $student = getStudent($_SESSION['computingID']);
        $faculty = getFaculty($_SESSION['computingID']); 
    }
    $display = 'position:relative';
    if($student){
        $leadsIn = getLeadingClubs($_SESSION['computingID']);
        if(!$leadsIn){
            $display = 'none';
            echo '<b>You are not a club leader!</b>';
        }
    }else{
        $display = 'none';
        echo '<b>Only students may create a post!</b>';
    }
    //Adds the post to the database ---also adds the event if needed
    $picData = null;
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Create Post")){
            if($_POST['clubName']){
                if (count($_FILES) > 0) {
                    if (is_uploaded_file($_FILES['picture']['tmp_name'])) {
                        $picData = file_get_contents($_FILES['picture']['tmp_name']);
                    }else{
                        $picData = $_POST['picture'];
                    }
                }
                $clubName = $_POST['clubName'];
                global $db;
                $query = "select `Club_ID` from `Club` where `Name`=:clubName";
                $statement = $db->prepare($query);
                $statement->bindValue(':clubName', $clubName);
                $statement->execute();
                $clubID = $statement->fetchColumn();
                $statement->closeCursor();
                $postID = addPost($_SESSION['computingID'], $clubID, date('Y-m-d h:i', time()), $picData, $_POST['title'], 0, $_POST['body'], 0);
                if($_POST['postType'] == "Yes"){//IS AN EVENT
                    addEvent($_POST['eventMeetingTime'], $_POST['eventLocation'], $_POST['partnerships'], $postID);
                    echo "<b> You have created an event post for " . $clubName . " ! </b>";
                }else{
                    echo "<b> You have created a post for " . $clubName . " ! </b>";
                }

            }else{
                echo "<b>You need to select a club to create a post!</b>";
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
<body style = "background: #5be7a9; font-family: Lato;" style = "position:absolute; top: 20%; text-align: center;">
    <?php include("header.php") ?>
    <br>
    <p class = "text-decoration-underline" style = "font-size: 25px;" >Post Creation Form</p>
<form name = "postCreationForm" enctype="multipart/form-data" action = "createPost.php" method = "post" style = "display:<?php echo $display; ?>;">
    <div class = "row mb-4 mx-3">
        Club to create post for:* <br/>
        <select name="clubName">
            <option selected="selected" disabled required >...</option>
            <?php            
            foreach($leadsIn as $club){
                echo '<option>'. $club['Name'] .'</option>';
            }
            ?>
        </select>
        <small class = "form-text text-muted" style="color:black !important"> Required. 
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Post Title <br/>
        <input type = "text" class = "form-control" name = "title" maxlength = "255" 
            style = "border: 2px solid black;" placeholder = "Post Title"
        />
        <small class = "form-text text-muted" style="color:black !important"> I.E. "Reminder to pay dues!" or "Club dinner this Friday 10/11!"
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Post Body <br/>
        <textarea rows= "8" onkeyup="textCounter(this,'counter',3000);" name = "body" placeholder = "Information about your post..." maxlength = "3000" style="border:solid 2px black;"></textarea>
        <input disabled maxlength="3" size="3" value ="3000" id="counter"/>
        <small class = "form-text text-muted" style="color:black !important"> Describe the post in detail.
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Picture <br/>
        <input type = "file" class = "form-control" name = "picture" id="picture" accept = "image/*" id = "imgInp" />
        <small id = "pictureInformation" class = "form-text text-muted" style="color:black !important">
            Upload a picture for the post if you want.
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Is this an event post?*
        <select onchange = "checkValues(this)" id = "postType" name = "postType"  
            style = "border: 2px solid black; height: 35px;">
            <option value = "No"> No </option>
            <option value = "Yes"> Yes </option>
        </select>
        <small id = "postTypeInformation" class = "form-text text-muted" style="color:black !important; text-align:left; "> 
            Required.
        </small> 
        
    </div>
    <!-- FOR EVENTS !-->
    <div class = "row mb-4 mx-3" id="eventOptionOne" style = "display: none; text-align:left;">
        When is the event?* <br/>
        <input type="datetime-local" class = "form-control" name="eventMeetingTime" id="eventTime" min="<?=date('Y-m-d h:i', time())?>" >
        <small class = "form-text text-muted" style="color:black !important"> Required. Enter the time the event starts.
        </small> 
    </div>
    <div class = "row mb-4 mx-3" id="eventOptionTwo" style = "display: none; text-align:left;">
        Event Location* <br/>
        <input type = "text" class = "form-control" name = "eventLocation" id="eventLocation" maxlength = "255" 
            style = "border: 2px solid black;" placeholder = "Enter the club's meeting location..."
        />
        <small class = "form-text text-muted" style="color:black !important">Required. I.E. "Rice 120"
        </small> 
    </div>
    <div class = "row mb-4 mx-3" id="eventOptionThree" style = "display: none; text-align:left;">
        Any Partnerships?<br/>
        <input type = "text" class = "form-control" name = "partnerships" maxlength = "500" 
            style = "border: 2px solid black;" placeholder = "Enter the club's meeting location..."
        />
        <small class = "form-text text-muted" style="color:black !important"> If your club event has multiple partnerships, make sure to separate them using "," 
        </small> 
    </div>
    <div class="row mb-4 mx-3">
      <input type = "submit" class = "btn btn-dark" name = "actionBtn" value = "Create Post" 
        title = "Click to create post" style = "width: 10%; display: block; margin: auto;"/>
    </div>
    <script>
        function textCounter(field,field2,maxlimit){
            var countfield = document.getElementById(field2);
            if ( field.value.length > maxlimit ) {
                field.value = field.value.substring(0, maxlimit );
                return false;
            } else {
                countfield.value = maxlimit - field.value.length;
            }
        }
    </script>
    <script>
        const picture = document.getElementById("picture");
        picture.addEventListener('change', (event) => {
            const target = event.target
                if (target.files && target.files[0]) {
                const maxAllowedSize = 65535;
                if (target.files[0].size > maxAllowedSize) {
                    // Here you can ask your users to load correct file
                    alert("File is too big! Must be less than 65,535B!");
                    target.value = ''
                }
            }
        })
        
        
    </script>
    <script>
        //Different forms depending on if it is an event or not
        var eventOptionOne;
        var eventOptionTwo;
        var eventOptionThree;
        function checkValues(select){
           eventOptionOne = document.getElementById('eventOptionOne');
           eventOptionTwo = document.getElementById('eventOptionTwo');
           eventOptionThree = document.getElementById('eventOptionThree');
           if(select.options[select.selectedIndex].value == "Yes"){//is an event
            eventOptionOne.style.display = 'block';
            eventOptionTwo.style.display = 'block';
            eventOptionThree.style.display = 'block';
            var eventTime = document.getElementById('eventTime');
            var eventLocation = document.getElementById('eventLocation');
            eventTime.required = true;
            eventLocation.required = true;

           }else{//not an event
            eventOptionOne.style.display = 'none';   
            eventOptionTwo.style.display = 'none'; 
            eventOptionThree.style.display = 'none';
           }
        }
    </script>
</form>
</body>
</html>
