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
?>