<?php 
    require("connect-db.php");
    require("club-db.php");
    require("password.php");
    $currentStudent = NULL;
    $tryRegister = 0;
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Add account"))
        {
            $password_hash = password_hash($_POST['userPassword'], PASSWORD_DEFAULT);
            if(!empty($_POST['userName'])){
                addUser($_POST['userComputingID'], $_POST['userName'], $password_hash);
            }
            else{
                addUser($_POST['userComputingID'], NULL, $password_hash);
            }
            if($_POST['userAffiliation'] == "student"){
                if(!empty($_POST['userMajor'])){
                    addStudent($_POST['userComputingID'], $_POST['userMajor'], $_POST['userYear']);
                }
                else{
                    addStudent($_POST['userComputingID'], NULL, $_POST['userYear']); 
                }
                $currentStudent = getStudent($_POST['userComputingID']);
                if($currentStudent == null){
                    deleteUser($_POST['userComputingID']);
                    $tryRegister = 1;
                }
                
            }
            else if($_POST['userAffiliation'] == "faculty"){
                if(!empty($_POST['userDepartment'])){
                    addFaculty($_POST['userComputingID'], $_POST['userDepartment']);
                }
                else{
                    addFaculty($_POST['userComputingID'], NULL); 
                }
            }
            if($tryRegister == 0){
                header("Location: login.php");
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
    <div>
        <?php 
            if(!isset($_SESSION['user'])){
                include("nonuserHeader.php");
            }
            else{
                include("userHeader.php");  
            }
        ?>
    </div>
    <br>

    <p class = "text-decoration-underline" style = "text-align: center; font-size: 25px;">
        Club Hub Registration
    </p>

    <div>
        <form name = "registerForm" action = "register.php" method = "POST" style = "text-align: center">
            <?php if($currentStudent == null && $tryRegister == 1) : ?>
                <div class = "row mb-0 mx-3">
                    <div class = "alert alert-danger">
                        <ul class = "m-0">
                            <li>
                                You have entered a wrong student year. Please change it to 1-4 to be able to register.
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            <div class = "row mb-4 mx-3">
            Computing ID* <br/>
                <input type = "text" class = "form-control" name = "userComputingID" maxlength = "7" 
                    style = "border: 2px solid black;" placeholder = "Your computing ID..." required
                />
                <small id = "computingIDInformation" class = "form-text text-muted" style="color:#E57200 !important; text-align:left;"> Required. 
                    7 characters or fewer. Letters and digits only. 
                </small> 
            </div>
            <div class = "row mb-4 mx-3">
            Password*
                <input type = "password" class = "form-control" name = "userPassword" maxlength = "100" minlength = "8" 
                    style = "border: 2px solid black;" placeholder = "Your password..." required
                />
                <small id = "passwordInformation" class = "form-text text-muted" style="color:#E57200 !important; text-align:left;">
                    Required. 8 characters minimum.
                </small> 
            </div>
            <div class = "row mb-4 mx-3">
            Name
                <input type = "text" class = "form-control" name = "userName" 
                    style = "border: 2px solid black;" placeholder = "Your name..."
                />
                <small id = "nameInformation" class = "form-text text-muted" style="color:#E57200 !important; text-align:left;">
                    First Name and Last Name
                </small> 
            </div>
            <div class = "row mb-4 mx-3">
            Student or Faculty*
                <select onchange = "checkValues(this)" id = "userAffiliation" name = "userAffiliation"  
                    style = "border: 2px solid black; height: 35px;">
                    <option value = "..."> ... </option>
                    <option value = "student"> Student </option>
                    <option value = "faculty"> Faculty </option>
                </select>
                <small id = "affiliationInformation" class = "form-text text-muted" style="color:#E57200 !important; text-align:left; "> 
                    Required.
                </small> 
            </div>
            <div class = "row mb-4 mx-3" id = "studentOptionOne" style = "display: none; text-align:left;">
            Major
                <input type = "text" class = "form-control" name = "userMajor" 
                    style = "border: 2px solid black;" placeholder = "Your major..."
                />
            </div>
            <div class = "row mb-4 mx-3" id = "studentOptionTwo" style = "display: none; text-align:left;">
            Year
            <input type = "number" class = "form-control" name = "userYear" 
                    style = "border: 2px solid black;" placeholder = "Your year..."
                />
            </div>
            <div class = "row mb-4 mx-3" id = "facultyOption" style = "display: none; text-align:left;">
            Department
                <input type = "text" class = "form-control" name = "userDepartment" 
                    style = "border: 2px solid black;" placeholder = "Your department..."
                />
            </div>
            <div class="row mb-4 mx-3">
                <input type = "submit" class = "btn" name = "actionBtn" value = "Add account" 
                title = "Click to register account" style = "width: 10%; display: block; margin: auto; background-color: #E57200; color: #232D4B;"
                />
            </div>
    </div>

    <script>
        var studentOptionOne;
        var studentOptionTwo;
        var facultyOption;
        function checkValues(select){
           studentOptionOne = document.getElementById('studentOptionOne');
           studentOptionTwo = document.getElementById('studentOptionTwo');
           facultyOption = document.getElementById('facultyOption');
           if(select.options[select.selectedIndex].value == "student"){
            studentOptionOne.style.display = 'block';
            studentOptionTwo.style.display = 'block';
            facultyOption.style.display = 'none';
           } 
           else if (select.options[select.selectedIndex].value == "faculty"){
            studentOptionOne.style.display = 'none';   
            studentOptionTwo.style.display = 'none';  
            facultyOption.style.display = 'block';
           }
           else{
            studentOptionOne.style.display = 'none';   
            studentOptionTwo.style.display = 'none'; 
            facultyOption.style.display = 'none';
           }
        }
    </script>
</form>
</body>
</html>