<link rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
<link rel="stylesheet"
      href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet"
      href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!-- ///////////
  Side bar
///////////  -->
<?php include('side_bars.html'); ?>

<!-- ///////////
  Page content
//////////////-->

<!-- give a left margin -->
<div class = "w3-margin-left">

<!-- Submit the search-->

  <div class="w3-margin-top">
    <label>What are you looking for?</label>
  </div>

  <div class="w3-margin-top">
    <form method = "post">
      <!-- Input field -->
      <div>
        <input class="w3-input w3-animate-input"
              type="text"
              name = "keyword"
              style="width:30%">
      </div>

      <!-- Submit button -->
      <div class="w3-margin-top">
        <button class = "submit_btn"
                type = "Search"
                value = "Search">
            Search
        </button>
      </div>
    </form>
  </div>

  <!-- get the results from db -->
  <div>
    <?php
      require "search_book.php"
    ?>
  </div>
  <!-- Books for borrowing -->
  <div>
    <form method = "post" action = "test.php">
      <div class="w3-panel w3-leftbar w3-border-red">
        <p>The following items are available for borrowing
        </p>
      </div>
      <div class = "w3-margin-left">
        <ul class="w3-ul">
          <?php
            echo $bookInCollection->displayShortCollection($conn);
           ?>
        </ul>
      </div>
  </div>
  <!-- books unavailable -->
  <div>
    <form method = "post" action = "test.php">
      <div class="w3-panel w3-leftbar w3-border-red">
        <p>The following items are currently unavailable
        </p>
      </div>
      <div class = "w3-margin-left">
        <ul class="w3-ul">
          <?php
            echo $bookOutCollection->displayShortCollection($conn);
           ?>
        </ul>
      </div>
  </div>
</div>
