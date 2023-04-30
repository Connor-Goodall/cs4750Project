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
    }
    $display = 'position:relative';
    if (!$student) {
        $display = 'none';
        echo '<b>Only students may create clubs!!</b>';
    }
    $logoData = null;
    $consData = null;
    $appData = null;
    $bylawsData = null;
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Create Club")){
            if($_POST['clubName']){
                if (count($_FILES) > 0) {
                    if (is_uploaded_file($_FILES['logo']['tmp_name'])) {
                        $logoData = file_get_contents($_FILES['logo']['tmp_name']);
                    }else{
                        $logoData = $_POST['logo'];
                    }
                    if (is_uploaded_file($_FILES['constitution']['tmp_name'])) {
                        $consData = file_get_contents($_FILES['constitution']['tmp_name']);
                    }else{
                        $consData = $_POST['constitution'];
                    }
                    if (is_uploaded_file($_FILES['application']['tmp_name'])) {
                        $appData = file_get_contents($_FILES['application']['tmp_name']);
                    }else{
                        $appData = $_POST['application'];
                    }
                    if (is_uploaded_file($_FILES['bylaws']['tmp_name'])) {
                        $bylawsData = file_get_contents($_FILES['bylaws']['tmp_name']);
                    }else{
                        $bylawsData = $_POST['bylaws'];
                    }
                }
                $clubName = $_POST['clubName'];
                if(!checkClubName($clubName)){
                    $clubID = addClub($_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $logoData, $_POST['dues'], $consData, $appData, $bylawsData, $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                    addMember($clubID, $_SESSION['computingID']);
                    setLeader($clubID, $_SESSION['computingID']);
                    echo "<b> " . $clubName . " has been added to the database!</b>";
                }else{
                    echo "<b> " . $clubName . " has already been added! Try a different name.</b>";

                }

            }else{
                echo "<b>Must have a club name to create club!!</b>";
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
<body style = "background: #232D4B; font-family: Lato; color: #E57200;" style = "position:absolute; top: 20%; text-align: center;">
    <?php include("header.php") ?>
    <br>
    <p class = "text-decoration-underline" style = "font-size: 25px; text-align:center;" >Club Creation Form</p>
<form name = "clubCreationForm" enctype="multipart/form-data" action = "createClub.php" method = "post" style = "display:<?php echo $display; ?>;">
    <div class = "row mb-4 mx-3">
        Club Name* <br/>
        <input type = "text" class = "form-control" name = "clubName" maxlength = "255" 
            style = "border: 2px solid black;" placeholder = "Your club's name..." required
        />
        <small class = "form-text text-muted" style="color:#E57200 !important"> Required. 
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Club Nickname <br/>
        <input type = "text" class = "form-control" name = "nickname" maxlength = "10" 
            style = "border: 2px solid black;" placeholder = "Nickname"
        />
        <small class = "form-text text-muted" style="color:#E57200 !important"> Usually an abbreviation or acronym of the club's name
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Concentration <br/>
        <input type = "text" class = "form-control" name = "concentration" maxlength = "255" 
            style = "border: 2px solid black;" placeholder = "Enter the club's concentration(s)"
        />
        <small class = "form-text text-muted" style="color:#E57200 !important"> If your club has multiple concentrations, make sure to separate them using "," 
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Website <br/>
        <input type="url" class = "form-control"  name="website" maxlength = "500" placeholder = "Enter the club's website url">
    </div>
    <div class = "row mb-4 mx-3">
        Mission_Statement <br/>
        <textarea rows= "6" onkeyup="textCounter(this,'counter',500);" name = "missionStatement" placeholder = "Your Club's mission statement..." maxlength = "500" style="border:solid 2px black;"></textarea>
        <input disabled maxlength="3" size="3" value ="500" id="counter"/>
    </div>
    <div class = "row mb-4 mx-3">
        Description <br/>
        <textarea rows= "6" onkeyup="textCounter(this,'counter2',1000);" name = "description" placeholder = "Your Club's description..." maxlength = "1000" style="border:solid 2px black;"></textarea>
        <input disabled maxlength="4" size="4" value ="1000" id="counter2"/>
    </div>

    <div class = "row mb-4 mx-3">
        Logo <br/>
        <input type = "file" class = "form-control" name = "logo" id="logo" accept = "image/*" id = "imgInp" />
        <small id = "nameInformation" class = "form-text text-muted" style="color:#E57200 !important">
            Upload an image file for the club's logo
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Dues $ <br/>
        <input type="number" class="form-control" placeholder="0.00"  name="dues" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'" oninput="validity.valid||(value='');">
        <small class = "form-text text-muted" style="color:#E57200 !important">
            Enter the amount members are expected to pay yearly in club dues
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Costs $ <br/>
        <input type="number" class="form-control" placeholder="0.00"  name="costs" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'" oninput="validity.valid||(value='');">
        <small class = "form-text text-muted" style="color:#E57200 !important">
            Enter the amount members are expected to pay yearly in non-dues associated costs
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Constitution <br/>
        <input name="constitution"  id="constitution" type="file" class="form-control" accept=".pdf, .docx, .doc" />
        <small class = "form-text text-muted" style="color:#E57200 !important">
            Upload a PDF/DOC/DOCX file for your club's constituion
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Application <br/>
        <input name="application" id="application" type="file" class="form-control" accept=".pdf, .docx, .doc" />
        <small class = "form-text text-muted" style="color:#E57200 !important">
            Upload a PDF/DOC/DOCX file for your club's application
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Bylaws <br/>
        <input name="bylaws" id="bylaws" type="file" class="form-control" accept=".pdf, .docx, .doc" />
        <small class = "form-text text-muted" style="color:#E57200 !important">
            Upload a PDF/DOC/DOCX file for your club's bylaws
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Funding Source <br/>
        <input type = "text" class = "form-control" name = "fundingSource" maxlength = "500" 
            style = "border: 2px solid black;" placeholder = "Enter the club's funding source(s)"
        />
        <small class = "form-text text-muted" style="color:#E57200 !important"> If your club has multiple sources, make sure to separate them using "," 
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Founding Date<br/>
        <input type="date" class = "form-control" id="datePicker" name="foundingDate" onload="setDate()">
        <small class = "form-text text-muted" style="color:#E57200 !important"> Enter the date the club was founded 
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Meeting Days<br/>
        <input type = "text" class = "form-control" name = "meetingDays" maxlength = "20" 
            style = "border: 2px solid black;" placeholder = "MoTuWeThFrSaSu"
        />
        <small class = "form-text text-muted" style="color:#E57200 !important"> Enter your the days your club meets. I.E."MoTu"
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Meeting Time<br/>
        <input type="time" class = "form-control" name="meetingTime">
        <small class = "form-text text-muted" style="color:#E57200 !important"> Enter the club meeting time 
        </small> 
    </div>
    <div class = "row mb-4 mx-3">
        Meeting Location<br/>
        <input type = "text" class = "form-control" name = "meetingLocation" maxlength = "255" 
            style = "border: 2px solid black;" placeholder = "Enter the club's meeting location..."
        />
        <small class = "form-text text-muted" style="color:#E57200 !important"> I.E. "Rice 120"
        </small> 
    </div>
    <div class="row mb-4 mx-3">
      <input type = "submit" class = "btn" name = "actionBtn" value = "Create Club" 
        title = "Click to create club" style = "width: 10%; display: block; margin: auto; background-color: #E57200; color: #232D4B;"/>
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
        function setDate(){
            const today = new Date();
            const yyyy = today.getFullYear();
            let mm = today.getMonth() + 1; // Months start at 0!
            let dd = today.getDate();
            if (dd < 10) dd = '0' + dd;
            if (mm < 10) mm = '0' + mm;
            const formattedToday = dd + '-' + mm + '-' + yyyy;
            document.getElementById('datePicker').value = formattedToday;
        }
    </script>
    <script>
        const logo = document.getElementById("logo");
        const cons = document.getElementById("constitution");
        const app = document.getElementById("application");
        const bylaws = document.getElementById("bylaws");

        logo.addEventListener('change', (event) => {
            const target = event.target
                if (target.files && target.files[0]) {
                const maxAllowedSize = 16777215;
                if (target.files[0].size > maxAllowedSize) {
                    // Here you can ask your users to load correct file
                    alert("File is too big! Must be less than 16.7 MB!");
                    target.value = ''
                }
            }
        })
        cons.addEventListener('change', (event) => {
            const target = event.target
                if (target.files && target.files[0]) {
                const maxAllowedSize = 16777215;
                if (target.files[0].size > maxAllowedSize) {
                    // Here you can ask your users to load correct file
                    alert("File is too big! Must be less than 16.7 MB!");
                    target.value = ''
                }
            }
        })
        app.addEventListener('change', (event) => {
            const target = event.target
                if (target.files && target.files[0]) {
                const maxAllowedSize = 16777215;
                if (target.files[0].size > maxAllowedSize) {
                    // Here you can ask your users to load correct file
                    alert("File is too big! Must be less than 16.7 MB!");
                    target.value = ''
                }
            }
        })
        bylaws.addEventListener('change', (event) => {
            const target = event.target
                if (target.files && target.files[0]) {
                const maxAllowedSize = 16777215;
                if (target.files[0].size > maxAllowedSize) {
                    // Here you can ask your users to load correct file
                    alert("File is too big! Must be less than 16.7 MB!");
                    target.value = ''
                }
            }
        })
        
    </script>
</form>
</body>
</html>
