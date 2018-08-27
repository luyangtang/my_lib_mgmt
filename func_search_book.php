<?php
  if(isset($_POST['keyword']))
  {
    $keyword = $_POST['keyword'];
  }
  else {
    $keyword = '%';
  }

require_once 'db_conn.php';
require 'func_book_inventory.php';

$conn = new mysqli($hn,$un,$pw,$db);
if ($conn -> connect_error) die("fatal error");


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
