

<html>
  <head>
    <title>LYT's library</title>

    Yo! Welcome to my library!
    What book are you looking for?<br><br>

  </head>

  <body>
    <form method = "post">

        <input type = "text" name = "keyword">
        <button type = "submit" value = "Search">
            Search
        </button>
    </form>
  </body>
</html>

<?php
  if(isset($_POST['keyword']))
  {
    $keyword = $_POST['keyword'];
  }
  else {
    $keyword = '%';
  }
 ?>

<?php
require_once 'db_conn.php';
require 'book_inventory.php';

$conn = new mysqli($hn,$un,$pw,$db);
if ($conn -> connect_error) die("fatal error")
?>
<?php

  // create a book collection
    // for books in the library
  $bookInCollection = new BookCollection;
    // for books lent out
  $bookOutCollection = new BookCollection;

  // query data from mysql server

  $query = "SELECT BookInventory.*,
                StatusId
            FROM BookInventory
            JOIN BookAvailability
              ON BookInventory.BookId
                = BookAvailability.BookId
            WHERE BookName LIKE '%".$keyword."%'
              OR Category LIKE '%".$keyword."%'
              OR Press LIKE '%".$keyword."%'
  ";
  $result = $conn -> query($query);
  if(!$result) die ("fatal error");
  $rows = $result -> num_rows;

  for ($j = 0; $j < $rows; ++$j)
  {
    $result -> data_seek($j);

    $recordContent = $result->fetch_assoc();

    if ($recordContent['StatusId'] == 1)
    {
      // define a new book based on the record from the query output
      $bookInCollection
        ->addBook($recordContent['BookId'],$conn);
    }
    else {
      // move the book to $bookOutCollection
      $bookOutCollection
        ->addBook($recordContent['BookId'],$conn);
    };
  };

 ?>

 <!--/////////////////////////////////////////////
 // display the bookInCollection on the page//
 /////////////////////////////////////////////-->

<form method = "post" action = "test.php"><pre>
  <p>Books available for borrowing: <br><br>
    <?php
      echo $bookInCollection->displayCollection($conn);
     ?> Name:
  </p></pre>
  <input type = "text"
        name = "borrowerName"
        value = "Visitor">
  <p> would like to borrow </p>
   <select name = "BookToBeBorrowed" size = "1">
    <?php //list test
      echo $bookInCollection -> showCollectionInFormList();
     ?>
   </select>
  <input type = "submit" value = "Confirm order">
  <?php
    // echo $_POST['BookToBeBorrowed'];
    if (isset($_POST['BookToBeBorrowed']))
    {$bookSelected = new BookIn;
      $bookSelected->id = $_POST['BookToBeBorrowed'];
      $bookSelected->getBookInfo($conn);
      $bookSelected->lendOut($_POST['borrowerName'],
                            $conn);}

   ?>

  <!-- Update in the database and show confirmation-->

</form>


<!--//////////////////////////////////////////////
// display the return on the page//
//////////////////////////////////////////////-->

<form method = "post" action = "test.php"><pre>
  <p>Books not currently in the library: <br><br>
    <?php
      echo $bookOutCollection->displayCollection($conn);
     ?>
  </p></pre>
  <p>I would like to return </p>
   <select name = "BookToBeReturned" size = "1">
    <?php //list test
      echo $bookOutCollection -> showCollectionInFormList();
     ?>
   </select>
  <input type = "submit" value = "Confirm">
  <?php
    if (isset($_POST['BookToBeReturned'])){
      $bookSelected = new BookOut;
      $bookSelected->id = $_POST['BookToBeReturned'];
      $bookSelected->getBookInfo($conn);
      $bookSelected->returnIn($conn);
    }
   ?>
</form>
