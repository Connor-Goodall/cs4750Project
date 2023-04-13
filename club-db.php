<?php
function addUser($computingID, $name, $password)
{
    global $db;
    $query = "insert into `User` values (:Name, :Bio, CURDATE(), :Profile_Picture, :computing_id, :Password)";
    $statement = $db->prepare($query);
    $statement->bindValue(':Name', $name);
    $statement->bindValue(':Bio', NULL);
    $statement->bindValue(':Profile_Picture', NULL);
    $statement->bindValue(':computing_id', $computingID);
    $statement->bindValue(':Password', $password);
    $statement->execute();
    $statement->closeCursor();
}
function addStudent($computingID, $major, $year)
{
    global $db;
    $query = "insert into `Student` values (:Year, :Major, :computing_id)";
    $statement = $db->prepare($query);
    $statement->bindValue(':Year', $year);
    $statement->bindValue(':Major', $major);
    $statement->bindValue(':computing_id', $computingID);
    $statement->execute();
    $statement->closeCursor();
}
function addFaculty($computingID, $department)
{
    global $db;
    $query = "insert into `Faculty` values (:Department, :computing_id)";
    $statement = $db->prepare($query);
    $statement->bindValue(':Department', $department);
    $statement->bindValue(':computing_id', $computingID);
    $statement->execute();
    $statement->closeCursor();
}
function addSponsor($computingID, $clubID){
    global $db;
    $query = "insert into `Sponsors` values (:computing_id, :Club_ID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':computing_id', $computingID);
    $statement->bindValue(':Club_ID', $clubID);
    $statement->execute();
    $statement->closeCursor();
}
function addClub($name, $missionStatement, $nickname, $concentration, $description, $logo, $dues, $constitution, $application, $bylaws, $website, $fundingSource, $foundingDate, $costs, $meetingTime, $meetingDays, $meetingLocation)
{
    global $db;
    $sql = "SELECT COUNT(*) FROM `Club`";
    $res = $db->query($sql);
    $clubID = $res->fetchColumn();
    $query = "insert into `Club` values (:Name, :Mission_Statement, :Nickname, :Concentration, :Description, :Logo, :Dues, :Constitution, :Application, :Bylaws, :Website, :Funding_source, :Founding_date, :Costs, :meeting_time, :meeting_days, :meeting_location, :Club_ID)";
    $statement = $db->prepare($query);
    //Wow that's a lot of bindValues 0_0
    $statement->bindValue(':Name', $name);
    $statement->bindValue(':Mission_Statement', $missionStatement);
    $statement->bindValue(':Nickname', $nickname);
    $statement->bindValue(':Concentration', $concentration);
    $statement->bindValue(':Description', $description);
    $statement->bindValue(':Logo', $logo);
    $statement->bindValue(':Dues', $dues);
    $statement->bindValue(':Constitution', $constitution);
    $statement->bindValue(':Application', $application);
    $statement->bindValue(':Bylaws', $bylaws);
    $statement->bindValue(':Website', $website);
    $statement->bindValue(':Funding_source', $fundingSource);
    if(empty($foundingDate)){//weird bug that won't create with empty foundingDate
        $statement->bindValue(':Founding_date', NULL);
    }else{
        $statement->bindValue('Founding_date', $foundingDate);
    }
    $statement->bindValue(':Costs', $costs);
    if(empty($meetingTime)){//weird bug that won't create with empty meetingTime
        $statement->bindValue(':meeting_time', NULL);
    }else{
        $statement->bindValue(':meeting_time', $meetingTime);
    }
    $statement->bindValue(':meeting_days', $meetingDays);
    $statement->bindValue(':meeting_location', $meetingLocation);
    $statement->bindValue(':Club_ID', $clubID);
    $statement->execute();
    $statement->closeCursor();
    return $clubID;
}
function addMember($clubID, $computingID){
    global $db;
    $query = "insert into `MemberOf` values (:computing_id, :Club_ID, :time_active)";
    $statement = $db->prepare($query);
    $statement->bindValue(':computing_id', $computingID);
    $statement->bindValue(':Club_ID', $clubID);
    $statement->bindValue(':time_active', 1);
    $statement->execute();
    $statement->closeCursor();
}
function setLeader($clubID, $computingID){
    global $db;
    $query = "insert into `Leads` values (:Exec_Role, :Club_ID, :computing_id)";
    $statement = $db->prepare($query);
    $statement->bindValue(':computing_id', $computingID);
    $statement->bindValue(':Club_ID', $clubID);
    $statement->bindValue(':Exec_Role', 'President');
    $statement->execute();
    $statement->closeCursor();
}
function getUser($computingID)
{
    global $db;
    $query = "select * from `User` where computing_id=:computingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $computingID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}
function getStudent($computingID)
{
    global $db;
    $query = "select * from `Student` where computing_id=:computingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $computingID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}
function getFaculty($computingID)
{
    global $db;
    $query = "select * from `Faculty` where computing_id=:computingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $computingID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}
function getClub($id){
    global $db;
    $query = "select * from `Club` where Club_ID=:id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}
function getLoginInformation($computingID, $password)
{
    global $db;
    $query = "select * from `User` where computing_id=:computingID and Password=:password";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $computingID);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}
function updateUser($computingID, $name, $bio, $picture)
{
    global $db;
    $query = "update `User` set Name=:name, Bio=:bio, Profile_Picture=:picture where computing_id=:computingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $computingID);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':bio', $bio);
    $statement->bindValue(':picture', $picture);
    $statement->execute();
    $statement->closeCursor();
}
function updateStudent($computingID, $major, $year)
{
    global $db;
    $query = "update `Student` set Major=:major, Year=:year where computing_id=:computingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $computingID);
    $statement->bindValue(':major', $major);
    $statement->bindValue(':year', $year);
    $statement->execute();
    $statement->closeCursor();
}
function updateFaculty($computingID, $department)
{
    global $db;
    $query = "update `Faculty` set Department=:department where computing_id=:computingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $computingID);
    $statement->bindValue(':department', $department);
    $statement->execute();
    $statement->closeCursor();
}
function deleteUser($computingID){
    global $db;
    $query = "delete from `User` where computing_id=:computingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $computingID);
    $statement->execute();
    $statement->closeCursor();
}
function deleteStudent($computingID){
    global $db;
    $query = "delete from `Student` where computing_id=:computingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $computingID);
    $statement->execute();
    $statement->closeCursor();
}
function deleteFaculty($computingID){
    global $db;
    $query = "delete from `Faculty` where computing_id=:computingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $computingID);
    $statement->execute();
    $statement->closeCursor();
}
function deleteSponsor($computingID, $clubID){
    global $db;
    $query = "delete from `Sponsors` where computing_id=:computingID and Club_ID=:clubID";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $computingID);
    $statement->bindValue(':clubID', $clubID);
    $statement->execute();
    $statement->closeCursor();
}
function getSponsor($computingID, $clubID){
    global $db;
    $query = "select * from `Sponsors` where computing_id=:computingID and Club_ID=:clubID";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $computingID);
    $statement->bindValue(':clubID', $clubID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}
function getAllSponsors($id){
    global $db;
    $query = "select computing_id from `Sponsors` where Club_ID=:id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}
function getLeaders($id){
    global $db;
    $query = "select computing_id, Exec_Role from `Leads` where Club_ID=:id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}
?>
