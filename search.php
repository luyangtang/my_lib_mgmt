<link rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
<link rel="stylesheet"
      href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet"
      href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!-- ///////////
  Side bar
///////////  -->

<div class="w3-sidebar
            w3-animate-left
            w3-bar-block
            w3-collapse
            w3-card"
      style="width:60px;"
      id="mySidebar">

  <button class="w3-bar-item w3-button w3-hide-large"
          onclick="w3_close()"><i class="material-icons">close</i>
  </button>
    <a href="index.php#"
        class="w3-bar-item w3-button w3-hover-red">
        <i class="material-icons">home</i>
    </a>
    <a href="search.php#"
        class="w3-bar-item w3-button w3-hover-red">
        <i class="material-icons">search</i>
    </a>
    <a href="#"
        class="w3-bar-item w3-button w3-hover-red">
        <i class="material-icons">person</i>
    </a>
</div>

<div class="w3-main" style="margin-left:200px">

  <div class="w3-red">
  <button class="w3-button w3-red w3-xlarge" onclick="w3_open()">&#9776;</button>
    <div class="w3-container">
      <h1>加加和小鹿的图书馆</h1>
    </div>
  </div>
</div>

<script>
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
}
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
}
</script>


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
