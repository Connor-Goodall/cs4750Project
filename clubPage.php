<?php 
    require("connect-db.php");
    require("club-db.php");
    session_start();
    $club = null;
    $userSponsor = null;
    if(!isset($_SESSION['user'])){
       $user = null;
       $student = null;
       $faculty = null;
    }
    else{
        $user = getUser($_SESSION['computingID']);
        $student = getStudent($_SESSION['computingID']);
        $faculty = getFaculty($_SESSION['computingID']); 
        $userSponsor = getSponsor($_SESSION['computingID'], $_GET['id']);
        $userMember = getMember($_SESSION['computingID'], $_GET['id']);
        $userLeader = getLeader($_SESSION['computingID'], $_GET['id']);
    }
    $club = getClub($_GET['id']);
?>
<!DOCTYPE html>
<html>
<?php if($club != null) : ?>
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
        <?php echo $club['Name']; ?>
    </p>
    <div style="text-align: center">
    <form name = "gotoBulletin" action = "bulletin.php" method = "POST">
                    <input type='hidden' name='clubName' value= <?php echo $club['Name']; ?> />
                    <input type = "submit" class = "btn" name = "actionBtn" value = "Bulletin" style = "background-color: #E57200; color: #232D4B;"/>
                </form>
    </div>
    <br>
    <div class = "container">
        <div class = "row">
            <div class = "col-7">
                <div class = "row">
                    <div class = "col">
                        <div class = "text-decoration-underline" style = "font-weight: bold; display: inline-block;">
                            Founding Date:
                        </div>
                        <div style = "display: inline-block;">
                            <?php if($club['Founding_date'] == null) : ?>
                                    <?php echo "No founding date." ?>
                                <?php else: ?>
                                    <?php echo date('F d, Y', strtotime($club['Founding_date'])); ?>
                                <?php endif; ?>
                        </div>
                    </div> 
                    <div class = "col">
                        <div class = "text-decoration-underline" style = "font-weight: bold; display: inline-block;">
                            Club Nickname or Acronym:
                        </div>
                        <div style = "display: inline-block;">
                            <?php if($club['Nickname'] == null) : ?>
                                        <?php echo "None" ?>
                                    <?php else: ?>
                                        <?php echo $club['Nickname']; ?>
                                    <?php endif; ?>
                        </div>
                    </div>  
                </div>
                &nbsp
                <div class = "row">
                    <div class = "text-decoration-underline" style = "font-weight: bold; display: inline-block; ">
                        Description:
                    </div>
                    <div style = "display: inline-block;">
                        <?php echo $club['Description']; ?>
                    </div>
                </div>
                &nbsp
                <div class = "row">
                    <div class = "col">
                        <div class = "text-decoration-underline" style = "font-weight: bold; display: inline-block; ">
                            Documents:
                            </div>
                    </div>
                    <br/>
                    <div class = "col-10">
                        <?php if($club['Constitution'] != null) : ?>
                            <?php if (substr($club['Constitution'], 0, 4) == "%PDF") : ?>
                                <a title = "Download <?php echo $club['Nickname']; ?>'s Constitution" 
                                    download = "<?php echo $club['Nickname']; ?>'s Constitution.pdf" 
                                    href = "data:application/pdf;base64,<?php echo base64_encode($club['Constitution']) ?>" 
                                    type="application/pdf" style="height:200px;width:60%"><?php echo $club['Nickname']; ?>'s Constitution</a>
                            <?php elseif(strpos($club['Constitution'], ".xml") <= 75 && strpos($club['Constitution'], ".xml") != false) : ?>
                                <a title = "Download <?php echo $club['Nickname']; ?>'s Constitution" 
                                    download = "<?php echo $club['Nickname']; ?>'s Constitution.docx" 
                                    href = "data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,<?php echo base64_encode($club['Constitution']) ?>" 
                                    type="application/vnd.openxmlformats-officedocument.wordprocessingml.document" 
                                    style="height:200px;width:60%"><?php echo $club['Nickname']; ?>'s Constitution</a>
                            <?php else : ?>
                                <a title = "Download <?php echo $club['Nickname']; ?>'s Constitution" 
                                        download = "<?php echo $club['Nickname']; ?>'s Constitution.doc" 
                                        href = "data:application/msword;base64,<?php echo base64_encode($club['Constitution']) ?>" 
                                        type="application/msword" style="height:200px;width:60%"><?php echo $club['Nickname']; ?>'s Constitution</a>
                            <?php endif; ?>
                        <?php else : ?>
                            No Constitution
                        <?php endif; ?>
                        <br/>
                        <?php if($club['Application'] != null) : ?>
                            <?php if (substr($club['Application'], 0, 4) == "%PDF") : ?>
                                <a title = "Download <?php echo $club['Nickname']; ?>'s Application" 
                                    download = "<?php echo $club['Nickname']; ?>'s Application.pdf" 
                                    href = "data:application/pdf;base64,<?php echo base64_encode($club['Application']) ?>" 
                                    type="application/pdf" style="height:200px;width:60%"><?php echo $club['Nickname']; ?>'s Application</a>
                            <?php elseif(strpos($club['Application'], ".xml") <= 75 && strpos($club['Application'], ".xml") != false) : ?>
                                <a title = "Download <?php echo $club['Nickname']; ?>'s Application" 
                                download = "<?php echo $club['Nickname']; ?>'s Application.docx" 
                                href = "data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,<?php echo base64_encode($club['Application']) ?>" 
                                type="application/vnd.openxmlformats-officedocument.wordprocessingml.document" 
                                style="height:200px;width:60%"><?php echo $club['Nickname']; ?>'s Application</a>
                            <?php else : ?>
                                <a title = "Download <?php echo $club['Nickname']; ?>'s Application" 
                                        download = "<?php echo $club['Nickname']; ?>'s Application.doc" 
                                        href = "data:application/msword;base64,<?php echo base64_encode($club['Application']) ?>" 
                                        type="application/msword" style="height:200px;width:60%"><?php echo $club['Nickname']; ?>'s Application</a>
                            <?php endif; ?>
                        <?php else : ?>
                            No Application
                        <?php endif; ?>
                        <br/>
                        <?php if($club['Bylaws'] != null) : ?>
                            <?php if (substr($club['Bylaws'], 0, 4) == "%PDF") : ?>
                                <a title = "Download <?php echo $club['Nickname']; ?>'s Bylaws" 
                                    download = "<?php echo $club['Nickname']; ?>'s Bylaws.pdf" 
                                    href = "data:application/pdf;base64,<?php echo base64_encode($club['Bylaws']) ?>" 
                                    type="application/pdf" style="height:200px;width:60%"><?php echo $club['Nickname']; ?>'s Bylaws</a>
                            <?php elseif(strpos($club['Bylaws'], ".xml") <= 75 && strpos($club['Bylaws'], ".xml") != false) : ?>
                                <a title = "Download <?php echo $club['Nickname']; ?>'s Bylaws" 
                                    download = "<?php echo $club['Nickname']; ?>'s Bylaws.docx" 
                                    href = "data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,<?php echo base64_encode($club['Bylaws']) ?>" 
                                    type="application/vnd.openxmlformats-officedocument.wordprocessingml.document" style="height:200px;width:60%"><?php echo $club['Nickname']; ?>'s Bylaws</a>
                            <?php else : ?>
                                <a title = "Download <?php echo $club['Nickname']; ?>'s Bylaws" 
                                        download = "<?php echo $club['Nickname']; ?>'s Bylaws.doc" 
                                        href = "data:application/msword;base64,<?php echo base64_encode($club['Bylaws']) ?>" 
                                        type="application/msword" style="height:200px;width:60%"><?php echo $club['Nickname']; ?>'s Bylaws</a>
                            <?php endif; ?>
                        <?php else : ?>
                            No Bylaws
                        <?php endif; ?>
                    </div>
                </div>
                &nbsp
                <div class = "row">
                    <div class = "col">
                        <div class = "text-decoration-underline" style = "font-weight: bold; display: inline-block;">
                            Mission Statement:
                        </div>
                        <div style = "display: inline-block;">
                            <?php if($club['Mission_Statement'] == null) : ?>
                                <?php echo "No mission statement." ?>
                            <?php else: ?>
                                <?php echo $club['Mission_Statement']; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class = "col">
                        <div class = "text-decoration-underline" style = "font-weight: bold; display: inline-block;">
                            Concentration:
                        </div>
                        <div style = "display: inline-block;">
                            <?php echo $club['Concentration']; ?>
                        </div>
                    </div>
                </div>
                &nbsp
                <div class = "row">
                    <div class = "col">
                        <div class = "text-decoration-underline" style = "font-weight: bold; display: inline-block;">
                            Meeting Time:
                        </div>
                        <div style = "display: inline-block;">
                            <?php if($club['meeting_days'] == null || $club['meeting_time'] == null) : ?>
                                <?php echo "No meeting time." ?>
                            <?php else: ?>
                                    <?php echo $club['meeting_days']; ?>
                                    <?php echo date('h:i A', strtotime($club['meeting_time'])); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class = "col">
                        <div class = "text-decoration-underline" style = "font-weight: bold; display: inline-block;">
                            Meeting Location:
                        </div>
                        <div style = "display: inline-block;">
                            <?php if($club['meeting_location'] == null) : ?>
                                    <?php echo "No meeting location." ?>
                                <?php else: ?>
                                    <?php echo $club['meeting_location']; ?>

                                <?php endif; ?>
                        </div>
                    </div>
                </div>
                &nbsp
                <div class = "row">
                    <div class = "col">
                        <div class = "text-decoration-underline" style = "font-weight: bold; display: inline-block;">
                            Website:
                        </div>
                        <div style = "display: inline-block;">
                            <?php if($club['Website'] == null) : ?>
                                <?php echo "No website." ?>
                            <?php else: ?>
                                <a href = '<?php echo $club['Website']; ?>'>
                                    <?php echo $club['Website']; ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class = "col">
                        <div class = "text-decoration-underline" style = "font-weight: bold; display: inline-block;">
                            Dues:
                            
                        </div>
                        <div style = "display: inline-block;">
                            <?php if($club['Dues'] == 0.00) : ?>
                                    <?php echo "No dues." ?>
                                <?php else: ?>
                                    <?php echo "$" . number_format($club['Dues'], 2) . " per Year"; ?>

                                <?php endif; ?>
                        </div>
                    </div>
                </div>
                &nbsp
                <div class = "row">
                    <div class = "col">
                        <div class = "text-decoration-underline" style = "font-weight: bold; display: inline-block;">
                            Sponsor:
                        </div>
                        <?php 
                            $sponsorResults = getAllSponsors($club['Club_ID']);
                            if($sponsorResults != null){
                              foreach($sponsorResults as $sponsorRow){
                                $sponsor = getUser($sponsorRow['computing_id']);
                                echo "<br>";
                                echo $sponsor['Name'];
                              }
                            }
                            else{
                                echo "<br>";
                                echo "No Sponsors!";
                            }
                        ?>
                    </div>
                    <div class = "col">
                        <div class = "text-decoration-underline" style = "font-weight: bold; display: inline-block;">
                                Leader(s):
                            </div>
                            <?php 
                                    $leaderResults = getLeaders($club['Club_ID']);
                                    if($leaderResults != null){
                                        foreach($leaderResults as $leaderRow){
                                            $leader = getUser($leaderRow['computing_id']);
                                            echo "<br>";
                                            echo $leader['Name']; 
                                            echo " (" . $leaderRow['Exec_Role'] . ")";
                                        }
                                    }
                                    else{
                                        echo "<br>";
                                        echo "No Leaders!";
                                    }
                                ?>
                    </div>
                </div>
            </div>
            <div class = "col">
                <div class = "row">
                    <div class = "text-decoration-underline d-flex justify-content-center" style = "font-weight: bold;">
                        Logo:

                    </div>
                    &nbsp
                    <?php if($club['Logo'] == null) : ?>
                        <div class="d-flex justify-content-center">
                            <img class = "account-img" src = "https://t3.ftcdn.net/jpg/04/62/93/66/240_F_462936689_BpEEcxfgMuYPfTaIAOC1tCDurmsno7Sp.jpg" style = "min-width: 250px; min-height: 250px; width: 250px; height: 250px;">
                        </div>
                    <?php else: ?>
                        <div class="d-flex justify-content-center">
                            <?php echo '<img class = "account-img" src="data:image/jpeg;base64,'.base64_encode($club['Logo']).'" style = "width: 80%; max-height: 20vw; object-fit: scale-down;">'; ?> 
                        </div>
                    <?php endif; ?> 
                </div>
                &nbsp
                <div class = "row">
                    <div class="text-decoration-underline d-flex justify-content-center" style = "font-weight: bold;">
                        Financial Info 
                    </div>
                </div>
                &nbsp
                <div class = "row" style = "margin-left : 30px;">
                    <div class="text-decoration-underline" style = "font-weight: bold; display: inline-block;">
                        Funding Source(s):
                    </div>
                    <div style = "display: inline-block;">
                        <?php if($club['Funding_source'] == null) : ?>
                                <?php echo "No funding source." ?>
                            <?php else: ?>
                                    <?php echo $club['Funding_source']; ?>
                            <?php endif; ?>
                    </div>
                </div>
                &nbsp
                <div class = "row" style = "margin-left : 30px;">
                    <div class="text-decoration-underline" style = "font-weight: bold; display: inline-block;">
                        Costs (Non-Dues):
                    </div>
                    <div style = "display: inline-block;">
                        <?php if($club['Costs'] == 0.00) : ?>
                                <?php echo "No costs (non-dues)." ?>
                            <?php else: ?>
                                <?php echo "$" . number_format($club['Costs'], 2) . " per Year"; ?>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    &nbsp
    <?php if($userSponsor != null) : ?>
        <div style = "text-align: center">
            <form name = "deleteSponsorForm" action = "clubInformation.php" method = "POST">
                <input type='hidden' name='id' value=<?php echo $club['Club_ID'];?> />
                <input type = "submit" class = "btn btn" name = "actionBtn" value = "Remove Your Sponsor" 
                                title = "Click to remove your sponsor" style = "background-color: #E57200; color: #232D4B;"/>
            </form>
        </div>
        <?php else : ?>
        <?php if($faculty != null && $sponsor == null) : ?>
            <div style = "text-align: center">
                <form name = "addSponsorForm" action = "clubInformation.php" method = "POST">
                <input type='hidden' name='id' value=<?php echo $club['Club_ID'];?> />
                    <input type = "submit" class = "btn" name = "actionBtn" value = "Sponsor This Club" 
                                title = "Click to sponsor this club" style = "background-color: #E57200; color: #232D4B;"/>
                </form>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if($userMember != null && $userLeader == null) : ?>
        <div style = "text-align: center">
            <form name = "deleteMemberForm" action = "clubInformation.php" method = "POST">
                <input type='hidden' name='id' value=<?php echo $club['Club_ID'];?> />
                <input type = "submit" class = "btn" name = "actionBtn" value = "Leave This Club" 
                                title = "Click to leave this club" style = "background-color: #E57200; color: #232D4B;"/>
            </form>
        </div>
    <?php else : ?>
        <?php if($student != null && $userLeader == null) : ?>
            <div style = "text-align: center">
                <form name = "addMemberForm" action = "clubInformation.php" method = "POST">
                    <input type='hidden' name='id' value=<?php echo $club['Club_ID'];?> />
                    <input type = "submit" class = "btn btn-dark" name = "actionBtn" value = "Join This Club" 
                                    title = "Click to join this club" style = "background-color: #E57200; color: #232D4B;"/>
                </form>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    &nbsp
    <?php if($userLeader != null) : ?>
        <div style = "text-align: center">
            <?php if($userLeader['Exec_Role'] == "President") : ?>
                <form action = "updateClub.php" method = "POST" style = "display:inline-block;" >
                        <input type='hidden' name='id' value=<?php echo $club['Club_ID'];?> />
                        <input type = "submit" name = "actionBtn" value = "Update Club Info" class = "btn btn-dark" 
                        title = "Click to update information about your club" style = "margin-right:200px;"/>
                </form>
                <form action = "editMembers.php" method = "POST" style = "display:inline-block;" >
                        <input type='hidden' name='id' value=<?php echo $club['Club_ID'];?> />
                        <input type = "submit" name = "actionBtn" value = "Edit Your Enrollment" class = "btn btn-secondary" 
                        title = "Click to edit your enrollment" style = "margin-right:300px;"/>
                </form>
            <?php else : ?>
                <form action = "updateClub.php" method = "POST" style = "display:inline-block;" >
                        <input type='hidden' name='id' value=<?php echo $club['Club_ID'];?> />
                        <input type = "submit" name = "actionBtn" value = "Update Club Info" class = "btn btn-dark" 
                        title = "Click to update information about your club"/>
                </form>
            <?php endif; ?>
            <?php if($userLeader['Exec_Role'] == "President") : ?>
                <form action = "deleteClub.php" method = "post" style = "display:inline-block;">
                    <input type='hidden' name='id' value=<?php echo $club['Club_ID'];?> />
                    <input type = "submit" class = "btn btn-danger" name = "actionBtn" value = "Delete" 
                                title = "Click to Delete club" style = " width: 100%;"/>
                </form>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    </body>
<?php else : ?>
    <p> Cannot find Club! </p>
<?php endif; ?>
</html>
