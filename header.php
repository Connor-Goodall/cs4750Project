<?php 
    require("connect-db.php");
    session_start();
?>
<!DOCTYPE html>
<html>
<header>  
    <nav class="navbar navbar-expand-md navbar-light navbar border border-dark">
      <div class="container-fluid">            
        <a class="navbar-brand" href="index.php">Club Finder</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar" aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class ="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                  </li>            
                  <li class="nav-item">
                      <a class="nav-link active" href="#">Bulletin</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link active" href="#">Search</a>
                  </li>
            </ul>
        <?php echo !isset($_SESSION['user']) ;?>    
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
            <li class="nav-item">
                <a class="nav-link active" href="updateProfile.php">Profile</a>
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