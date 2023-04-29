<?php 
    require("connect-db.php");
    require("club-db.php");
    session_start();
    $club = null;
    $userLeader = getLeader($_SESSION['computingID'], $_POST['id']);
    if(!isset($_SESSION['user']) || $userLeader == null){
        header('Location: index.php');
    }
    else{
        $user = getUser($_SESSION['computingID']);
        $student = getStudent($_SESSION['computingID']);
        $club = getClub($_POST['id']);
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Confirm Update")){
                if (count($_FILES) > 0) {
                    if (is_uploaded_file($_FILES['logo']['tmp_name'])) {
                        $logoData = file_get_contents($_FILES['logo']['tmp_name']);
                    }
                    if (is_uploaded_file($_FILES['constitution']['tmp_name'])) {
                        $constData = file_get_contents($_FILES['constitution']['tmp_name']);
                    }
                    if (is_uploaded_file($_FILES['application']['tmp_name'])) {
                        $appData = file_get_contents($_FILES['application']['tmp_name']);
                    }
                    if (is_uploaded_file($_FILES['bylaws']['tmp_name'])) {
                        $byData = file_get_contents($_FILES['bylaws']['tmp_name']);
                    }
                }
                if($logoData != null){
                    if($constData != null){
                        if($appData != null){
                            if($byData != null){
                                updateClub($club['Club_ID'], $_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $logoData, $_POST['dues'], $constData, $appData, $byData, $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                            }
                            else{
                                updateClub($club['Club_ID'], $_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $logoData, $_POST['dues'], $constData, $appData, $club['Bylaws'], $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                            }
                        }
                        else{
                            if($byData != null){
                                updateClub($club['Club_ID'], $_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $logoData, $_POST['dues'], $constData, $club['Application'], $byData, $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                            }
                            else{
                                updateClub($club['Club_ID'], $_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $logoData, $_POST['dues'], $constData, $club['Application'], $club['Bylaws'], $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                            }
                        }
                    }
                    else{
                        if($appData != null){
                            if($byData != null){
                                updateClub($club['Club_ID'], $_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $logoData, $_POST['dues'], $club['Constitution'], $appData, $byData, $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                            }
                            else{
                                updateClub($club['Club_ID'], $_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $logoData, $_POST['dues'], $club['Constitution'], $appData, $club['Bylaws'], $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                            }
                        }
                        else{
                            if($byData != null){
                                updateClub($club['Club_ID'], $_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $logoData, $_POST['dues'], $club['Constitution'], $club['Application'], $byData, $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                            }
                            else{
                                updateClub($club['Club_ID'], $_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $logoData, $_POST['dues'], $club['Constitution'], $club['Application'], $club['Bylaws'], $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                            } 
                        }
                    }
                }
                else{
                    if($constData != null){
                        if($appData != null){
                            if($byData != null){
                                updateClub($club['Club_ID'], $_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $club['Logo'], $_POST['dues'], $constData, $appData, $byData, $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                            }
                            else{
                                updateClub($club['Club_ID'], $_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $club['Logo'], $_POST['dues'], $constData, $appData, $club['Bylaws'], $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                            }
                        }
                        else{
                            if($byData != null){
                                updateClub($club['Club_ID'], $_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $club['Logo'], $_POST['dues'], $constData, $club['Application'], $byData, $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                            }
                            else{
                                updateClub($club['Club_ID'], $_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $club['Logo'], $_POST['dues'], $constData, $club['Application'], $club['Bylaws'], $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                            } 
                        }
                    }
                    else{
                        if($appData != null){
                            if($byData != null){
                                updateClub($club['Club_ID'], $_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $club['Logo'], $_POST['dues'], $club['Constitution'], $appData, $byData, $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                            }
                            else{
                                updateClub($club['Club_ID'], $_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $club['Logo'], $_POST['dues'], $club['Constitution'], $appData, $club['Bylaws'], $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                            }
                        }
                        else{
                            if($byData != null){
                                updateClub($club['Club_ID'], $_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $club['Logo'], $_POST['dues'], $club['Constitution'], $club['Application'], $byData, $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                            }
                            else{
                                updateClub($club['Club_ID'], $_POST['clubName'], $_POST['missionStatement'], $_POST['nickname'], $_POST['concentration'], $_POST['description'], $club['Logo'], $_POST['dues'], $club['Constitution'], $club['Application'], $club['Bylaws'], $_POST['website'], $_POST['fundingSource'], $_POST['foundingDate'], $_POST['costs'], $_POST['meetingTime'], $_POST['meetingDays'], $_POST['meetingLocation'], $_SESSION['computingID']);
                            } 
                        }   
                    } 
                }
                header('Location: clubPage.php?id=' . $club['Club_ID']);
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
            <p class = "text-decoration-underline" style = "text-align: center; font-size: 25px;">
                Club Update Page
            </p>
            <form enctype="multipart/form-data" name = "updateUserForm" action = "updateClub.php" method = "POST">
            <div class = "row mb-4 mx-3">
                Club Name <br/>
                <input type = "text" class = "form-control" name = "clubName" maxlength = "255" 
                    style = "border: 2px solid black;" value = "<?php if ($club != null) echo $club['Name']; ?>" required
                />
            </div>
            <div class = "row mb-4 mx-3">
                Club Nickname <br/>
                <input type = "text" class = "form-control" name = "nickname" maxlength = "10" 
                    style = "border: 2px solid black;" value = "<?php if ($club != null) echo $club['Nickname']; ?>"
                />
                <small class = "form-text text-muted" style="color:#E57200 !important"> 
                    Usually an abbreviation or acronym of the club's name
                </small> 
            </div>
            <div class = "row mb-4 mx-3">
                Concentration <br/>
                <input type = "text" class = "form-control" name = "concentration" maxlength = "255" 
                    style = "border: 2px solid black;" value = "<?php if ($club != null) echo $club['Concentration']; ?>"
                />
                <small class = "form-text text-muted" style="color:#E57200 !important"> If your club has multiple concentrations, make sure to separate them using "," 
                </small> 
            </div>
            <div class = "row mb-4 mx-3">
                Website <br/>
                <input type="url" class = "form-control"  name="website" maxlength = "500" style = "border: 2px solid black;" value = "<?php if ($club != null) echo $club['Website']; ?>">
            </div>
            <div class = "row mb-4 mx-3">
                Mission_Statement <br/>
                <textarea rows= "6" onkeyup="textCounter(this,'counter',500);" name = "missionStatement" maxlength = "500" style="border:solid 2px black;"><?php if ($club != null) echo $club['Mission_Statement']; ?></textarea>
                <input disabled maxlength="3" size="3" value ="500" id="counter"/>
            </div>
            <div class = "row mb-4 mx-3">
                Description <br/>
                <textarea rows= "6" onkeyup="textCounter(this,'counter2',1000);" name = "description" placeholder = "Your Club's description..." maxlength = "1000" style="border:solid 2px black;"><?php if ($club != null) echo $club['Description']; ?></textarea>
                <input disabled maxlength="4" size="4" value ="1000" id="counter2"/>
            </div>
            <div class = "row mb-4 mx-3">
                Logo <br/>
                <input type = "file" class = "form-control" name = "logo" id="logo" accept = "image/*" id = "imgInp" />
            </div>
            <div class = "row mb-4 mx-3">
                Dues $ <br/>
                <input type="number" class="form-control" value = "<?php if ($club != null) echo number_format($club['Dues'], 2); ?>" name="dues" min="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" />
                <small class = "form-text text-muted" style="color:#E57200 !important">
                    Enter the amount members are expected to pay yearly in club dues
                </small> 
            </div>
            <div class = "row mb-4 mx-3">
                Costs $ <br/>
                <input type="number" class="form-control" name="costs" min="0" value = "<?php if ($club != null) echo number_format($club['Costs'], 2); ?>" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" />
                <small class = "form-text text-muted" style="color:#E57200 !important">
                    Enter the amount members are expected to pay yearly in non-dues associated costs
                </small> 
            </div>
            <div class = "row mb-4 mx-3">
                Constitution <br/>
                <input name="constitution" id="constitution" type="file" class="form-control" accept=".pdf, .docx, .doc" />
                <small class = "form-text text-muted" style="color:#E57200 !important">
                    PDF/DOC/DOCX file ONLY
                </small> 
            </div>
            <div class = "row mb-4 mx-3">
                Application <br/>
                <input name="application" id="application" type="file" class="form-control" accept=".pdf, .docx, .doc" />
                <small class = "form-text text-muted" style="color:#E57200 !important">
                    PDF/DOC/DOCX file ONLY
                </small> 
            </div>
            <div class = "row mb-4 mx-3">
                Bylaws <br/>
                <input name="bylaws" id="bylaws" type="file" class="form-control" accept=".pdf, .docx, .doc" />
                <small class = "form-text text-muted" style="color:#E57200 !important">
                    PDF/DOC/DOCX file ONLY
                </small> 
            </div>
            <div class = "row mb-4 mx-3">
                Funding Source <br/>
                <input type = "text" class = "form-control" name = "fundingSource" maxlength = "500" 
                    style = "border: 2px solid black;" value = "<?php if ($club != null) echo $club['Funding_source']; ?>"
                />
                <small class = "form-text text-muted" style="color:#E57200 !important"> If your club has multiple sources, make sure to separate them using "," 
                </small> 
            </div>
            <div class = "row mb-4 mx-3">
                Founding Date<br/>
                <input type="date" class = "form-control" id="datePicker" name="foundingDate" value = '<?php echo date('Y-m-d', strtotime($club['Founding_date'])); ?>'
                onload="setDate()">
            </div>
            <div class = "row mb-4 mx-3">
                Meeting Days<br/>
                <input type = "text" class = "form-control" name = "meetingDays" maxlength = "20" 
                    style = "border: 2px solid black;" value = "<?php if ($club != null) echo $club['meeting_days']; ?>"
                />
                <small class = "form-text text-muted" style="color:#E57200 !important"> Enter your the days your club meets. I.E."MoTu"
                </small> 
            </div>
            <div class = "row mb-4 mx-3">
                Meeting Time<br/>
                <input type="time" class = "form-control" name="meetingTime" value = '<?php echo date('H:i', strtotime($club['meeting_time'])); ?>'>
            </div>
            <div class = "row mb-4 mx-3">
                Meeting Location<br/>
                <input type = "text" class = "form-control" name = "meetingLocation" maxlength = "255" 
                    style = "border: 2px solid black;" value = "<?php if ($club != null) echo $club['meeting_location']; ?>"
                />
                <small class = "form-text text-muted" style="color:#E57200 !important"> I.E. "Rice 120"
                </small> 
            </div>
            <div class="row mb-4 mx-3">
                    <input type='hidden' name='id' value=<?php echo $club['Club_ID'];?> />
                    <input type = "submit" class = "btn btn-dark" name = "actionBtn" value = "Confirm Update" 
                        title = "Click to update club" style = "width: 20%; display: block; margin: auto;"
                    />
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
            </form>
        </body>
</html>