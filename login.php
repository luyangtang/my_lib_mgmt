<?php
include("side_bars.html");
 ?>


 <div class="w3-container w3-white w3-text-grey">
   <h2>Please log in</h2>
 </div>

<div  class = "w3-margin-left">
 <form class="w3-container"
        method = "post"
        action = "login.php">
   <label class="w3-text-grey">
     <b>User name
     </b>
   </label>
   <input class="w3-input
                w3-border
                w3-light-grey"
          type="text"
          name = 'collectedUsername'>

   <label class="w3-text-grey">
     <b>Password
     </b>
   </label>
   <input class="w3-input
                w3-border
                w3-light-grey"
          type="text"
          name = 'collectedPassword'>

   <button class="w3-btn w3-blue-grey w3-margin-top"
            type = 'submit'>
     Login
   </button><a class="w3-button
                  w3-hover-transparent
                  w3-pale-grey w3-margin-top"
              href = 'registration_form.php'>
     Signup
   </a>
 </form>
</div>

// login and create a session
 <?php
   session_start();
   $_SESSION['collectedUsername'] = $_POST['collectedUsername'];
   $_SESSION['userID'] = $_POST['collectedUsername'];
   //echo 'hell0'.$_SESSION['collectedUsername'];
   echo isset($_SESSION['userID']);

   // go to the profile page if login is successful
   if (isset($_SESSION['userID'])) {
      header('Location: user_profile.php');
    }
  ?>
