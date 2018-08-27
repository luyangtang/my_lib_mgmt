<?php
include('side_bars.html');
 ?>


// destroy the session
 <?php
    $_SESSION = array();
    session_destroy();
  ?>

 <div class = "w3-margin-left w3-margin-top">
   You are logged out.
 </div>
