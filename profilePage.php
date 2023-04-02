<?php 
    require("connect-db.php");
    require("club-db.php");
    $user = null;
    if(!empty($_GET['user'])){
        $user = getUser($_GET['user']);
        echo $_GET['user'];
        echo $user['computing_id'];
        echo $user['Bio'];
    }
    else{
        echo "HTTP/1.0 404 Not Found";
       
    }
?>