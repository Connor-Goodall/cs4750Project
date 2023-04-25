<?php 
    require("connect-db.php");
    session_start();
?>
<!DOCTYPE html>
<html>
<header>  
    <nav class="navbar navbar-expand-md navbar-light navbar border border-dark">
      <div class="container-fluid">            
        <a class="navbar-brand" href="index.php" >Club Finder</a>
        <button class="navbar-toggler" type="button" style="border-right: 1px solid #000;" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar" aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <style>
            .navbar-nav>li{
              border-right: 1px solid #000;
            }
            .navbar-nav>li:first-child{
              border-left: 1px solid #000;
            }
            </style>
            <ul class ="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                  </li>            
                  <li class="nav-item">
                      <a class="nav-link active" href="bulletin.php">Bulletin</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link active" href="clubSearch.php">Search for Clubs</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link active" href="facultySearch.php">Search for Sponsors</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link active" href="createClub.php">Add your Club</a>
                  </li>
            </ul>    
        <?php if(!isset($_SESSION['user'])) : ?>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link active" href="login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="register.php">Register</a>
            </li>
          </ul>
        <?php else : ?>
            <ul class="navbar-nav ms-auto">
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Profile
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href = "userProfile.php">My Profile</a></li>
                    <li><a class="dropdown-item" href = "userClubs.php">My Clubs</a></li>
                  </ul>
              </li>
              <li class="nav-item">
                  <a class="nav-link active" href="logout.php">Logout</a>
              </li>
            </ul>
        <?php endif; ?>
        </div>
      </div>
    </nav>
  </header>
  </html>