<!DOCTYPE html>
<html>
<header>  
    <style>
      .navbar{
        background-color: #E57200;
      }
    </style>
    <nav class="navbar navbar-expand-md navbar-light navbar border border-dark">
      <div class="container-fluid">            
        <a class="navbar-brand" href="index.php" style = "color: #232D4B;">Club Hub</a>
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
                    <a class="nav-link active" href="index.php" style = "color: #232D4B;">Home</a>
                  </li>            
                  <li class="nav-item">
                      <a class="nav-link active" href="clubSearch.php" style = "color: #232D4B;">Search for Clubs</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link active" href="facultySearch.php" style = "color: #232D4B;">Search for Sponsors</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link active" href="createClub.php" style = "color: #232D4B;">Add Your Club</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link active" href="createPost.php" style = "color: #232D4B;">Create a Post</a>
                  </li>
            </ul>    
            <ul class="navbar-nav ms-auto">
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" style = "color: #232D4B;">
                    Profile
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="profileDropdown" style = "background-color: #E57200;">
                    <li><a class="dropdown-item" href = "userProfile.php" style = "color: #232D4B;">My Profile</a></li>
                    <li><a class="dropdown-item" href = "userClubs.php" style = "color: #232D4B;">My Clubs</a></li>
                  </ul>
              </li>
              <li class="nav-item">
                  <a class="nav-link active" href="logout.php" style = "color: #232D4B;">Logout</a>
              </li>
            </ul>
        </div>
      </div>
    </nav>
  </div>
  </header>
  </html>