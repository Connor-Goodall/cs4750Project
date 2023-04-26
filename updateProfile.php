<?php 
    require("connect-db.php");
    require("club-db.php");
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location: login.php");
    }
    else{
        $user = getUser($_SESSION['computingID']);
        $student = getStudent($_SESSION['computingID']);
        $faculty = getFaculty($_SESSION['computingID']); 
        $imgData = null;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Confirm Update")){
                if (count($_FILES) > 0) {
                    if (is_uploaded_file($_FILES['userPicture']['tmp_name'])) {
                        $imgData = file_get_contents($_FILES['userPicture']['tmp_name']);
                    }
                }
                if($imgData != null){
                    updateUser($_SESSION['computingID'], $_POST['userName'], $_POST['userBio'], $imgData);
                }
                else{
                    updateUser($_SESSION['computingID'], $_POST['userName'], $_POST['userBio'], $user['Profile_Picture']);
                }
                if($student != null){
                    if($_POST['userYear'] == "..."){
                        updateStudent($_SESSION['computingID'], $_POST['userMajor'], $student['Year']);
                    }
                    else{
                        updateStudent($_SESSION['computingID'], $_POST['userMajor'], $_POST['userYear']);
                    }
                }
                elseif($faculty != null){
                    updateFaculty($_SESSION['computingID'], $_POST['userDepartment']);
                }
                header("Location: userProfile.php");
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
                Profile Update Page
            </p>
            <form enctype="multipart/form-data" name = "updateUserForm" action = "updateProfile.php" method = "post" style = "position:absolute; top: 20%; right:0;
            left:0;">
                <div class = "row mb-2 mx-2">
                    Profile Picture <br/>
                    <input id="image" type="file" name="userPicture"/>
                </div>
                <div class = "row mb-4 mx-3">
                    Name <br/>
                    <input type = "text" class = "form-control" name = "userName"
                        style = "border: 2px solid black;" value = "<?php if ($user != null) echo $user['Name']; ?>"
                    />
                </div>
                <div class = "row mb-4 mx-3">
                    Bio <br/>
                    <textarea type = "text" class = "form-control" name = "userBio"
                        style = "border: 2px solid black;"><?php if ($user != null) echo $user['Bio']; ?></textarea>
                </div>
                <?php if($student != null) : ?>
                    <div class = "row mb-4 mx-3">
                        Major <br/>
                        <input type = "text" class = "form-control" name = "userMajor"
                            style = "border: 2px solid black;" value = "<?php if ($user != null) echo $student['Major']; ?>"
                        />
                    </div>
                    <div class = "row mb-4 mx-3">
                        Year
                        <select id = "userYear" name = "userYear"  
                            style = "border: 2px solid black; height: 35px;" required>
                            <option value = "..."> ... </option>
                            <option value = "1"> First </option>
                            <option value = "2"> Second </option>
                            <option value = "3"> Third </option>
                            <option value = "4"> Fourth </option>
                        </select>
                    </div>
                <?php elseif($faculty != null) : ?>
                    <div class = "row mb-4 mx-3">
                        Department <br/>
                        <input type = "text" class = "form-control" name = "userDepartment"
                            style = "border: 2px solid black;" value = "<?php if ($user != null) echo $faculty['Department']; ?>" required
                        />
                    </div>
                <?php endif; ?>
                <div class="row mb-4 mx-3">
                    <input type = "submit" class = "btn btn-dark" name = "actionBtn" value = "Confirm Update" 
                        title = "Click to update account" style = "width: 20%; display: block; margin: auto;"
                    />
                    </div>
            </form>
        </body>
</html>