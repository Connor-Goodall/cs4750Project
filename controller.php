<?php
session_start();
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
   case '/':                   // URL (without file name) to a default screen
      require 'index.php';
      break; 
   case '/index.php':     // if you plan to also allow a URL with the file name 
      require 'index.php';
      break;              
   case '/login.php':
      require 'login.php';
      break;
    case '/clubSearch.php':
        require 'clubSearch.php';
        break;
    case '/createClub.php':
        require 'createClub.php';
        break;
    case '/clubPage.php':
        require 'clubPage.php';
        break;
    case '/clubInformation.php':
        require 'clubInformation.php';
        break;
    case '/updateClub.php':
        require 'updateClub.php';
        break;
    case '/userClubs.php':
        require 'userClubs.php';
        break;
    case '/deleteClub.php':
        require 'deleteClub.php';
        break;
    case '/editMembers.php':
        require 'editMembers.php';
        break;
    case '/addLeaders.php':
        require 'addLeaders.php';
        break;
    case '/logout.php':
        require 'logout.php';
        break;
    case '/createPost.php':
        require 'createPost.php';
        break;
    case '/bulletin.php':
        require 'bulletin.php';
        break;
    case '/facultySearch.php':
        require 'facultySearch.php';
        break;
    case '/register.php':
        require 'register.php';
        break;
    case '/profilePage.php':
        require 'profilePage.php';
        break;
    case '/userProfile.php':
        require 'userProfile.php';
        break;
    case '/updateProfile.php':
        require 'updateProfile.php';
        break;
    case '/deleteUser.php':
        require 'deleteUser.php';
        break;
    case '/updatePost.php':
        require 'updatePost.php';
        break;
    case '/rsvp.php':
        require 'rsvp.php';
        break;
    case '/updateRSVP.php':
        require 'updateRSVP.php';
        break;
    case '/deletePost.php':
        require 'deletePost.php';
        break;
    default:
      http_response_code(404);
      exit('Not Found');
}  
?>