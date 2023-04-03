<?php 
    require("connect-db.php");
    require("club-db.php");
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Add account"))
        {
            if(!empty($_POST['userName'])){
                addUser($_POST['userComputingID'], $_POST['userName'], $_POST['userPassword']);
            }
            else{
                addUser($_POST['userComputingID'], NULL, $_POST['userPassword']);
            }
            if($_POST['userAffiliation'] == "student"){
                if(!empty($_POST['userMajor'])){
                    addStudent($_POST['userComputingID'], $_POST['userMajor'], $_POST['userYear']);
                }
                else{
                    addStudent($_POST['userComputingID'], NULL, $_POST['userYear']); 
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
<?php include("header.html") ?>
    <br>
    <p class = "text-decoration-underline" style = "text-align: center; font-size: 25px;">
        Club Finder Registration
    </p>
<form name = "registerForm" action = "register.php" method = "post" style = "position:absolute; top: 20%; right:0;
    left:0;">
    <div class = "row mb-4 mx-3">
        Computing ID* <br/>
        <input type = "text" class = "form-control" name = "userComputingID" maxlength = "6" 
            style = "border: 2px solid black;" placeholder = "Your computing ID..." required
        />
        <small id = "computingIDInformation" class = "form-text text-muted" style="color:black !important"> Required. 
            7 characters or fewer. Letters and digits only. 
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Password*
        <input type = "password" class = "form-control" name = "userPassword" maxlength = "100" minlength = "8" 
            style = "border: 2px solid black;" placeholder = "Your password..." required
        />
        <small id = "passwordInformation" class = "form-text text-muted" style="color:black !important">
            Required. 8 characters minimum.
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Name
        <input type = "text" class = "form-control" name = "userName" 
            style = "border: 2px solid black;" placeholder = "Your name..."
        />
        <small id = "nameInformation" class = "form-text text-muted" style="color:black !important">
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
        <small id = "affiliationInformation" class = "form-text text-muted" style="color:black !important"> 
            Required.
        </small> 
    </div>
    <div class = "row mb-4 mx-3" id = "studentOptionOne" style = "display: none">
    Major
    <input type = "text" class = "form-control" name = "userMajor" 
            style = "border: 2px solid black;" placeholder = "Your major..."
        />
    </div>
    <div class = "row mb-4 mx-3" id = "studentOptionTwo" style = "display: none">
    Year
        <select id = "userYear" name = "userYear"  
            style = "border: 2px solid black; height: 35px;">
            <option value = "1"> First </option>
            <option value = "2"> Second </option>
            <option value = "3"> Third </option>
            <option value = "4"> Fourth </option>
        </select>
    </div>
    <div class = "row mb-4 mx-3" id = "facultyOption" style = "display: none">
    Department
    <input type = "text" class = "form-control" name = "userDepartment" 
            style = "border: 2px solid black;" placeholder = "Your department..."
        />
    </div>
    <div class="row mb-4 mx-3">
      <input type = "submit" class = "btn btn-dark" name = "actionBtn" value = "Add account" 
        title = "Click to register account" style = "width: 10%; display: block; margin: auto;"
      />
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