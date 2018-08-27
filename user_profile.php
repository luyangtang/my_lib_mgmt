<link rel="stylesheet"
      href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet"
      href="https://fonts.googleapis.com/icon?family=Material+Icons">




<!-- side bars -->

<?php
include('side_bars.html');
 ?>

 <!-- check if Logged in-->
 <div class = 'w3-margin-left'>
      <?php
      if (isset($_SESSION['userID']))
          {
            echo '<div>
                    <p>Welcome to the library!
                    </p>
                  </div>';
          }
      else {
        die('
          <div class="w3-panel w3-pale-red">
            <h3>
              Restricted page.
            </h3>
            <a href = "login.php">
              You will want to log in first
            </a>
          </div>');
          }
       ?>

 </div>


 <div>
   <div class="w3-card">

    <!-- Header for user name -->
    <header class="w3-container w3-light-grey">
      <h3>John Doe</h3>
    </header>

    <!-- button to log out -->


      <div class="w3-container">
        <!-- Contact info -->
        <div class = "w3-margin-left">
          <h5 class="material-icons">smartphone</h5>
            Phone Number
          <div class = "w3-margin-left">
            <p>07793059097</p>
          </div>
        </div>
        <div class = "w3-margin-left w3-margin-top">
          <h5 class="material-icons">home</h5>
            Home address
          <div class = "w3-margin-left w3-margin-top">
            <p>Apartment 262, 41 Essex Street, Birmingham, B5 4TW</p>
          </div>
        </div>
        <!-- Books kept with the user -->
        <div class = "w3-margin-left w3-margin-top">
          <h5 class="material-icons">assignment</h5>
            Books borrowed
          <div>
            <ul class="w3-ul w3-hoverable">
              <li>Book1</li>
              <li>Book2</li>
              <li>Book3</li>
            </ul>
          </div>
        </div>
      </div>
     </div>
    </div>
