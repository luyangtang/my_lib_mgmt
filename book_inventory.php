<?php
class Book
{
  public $name, $category, $press, $price, $id;

  function getBookInfo($conn)
  // initialise a book
  {
    // read id and look up in the database
    // $this->id = $id;
    $query = 'SELECT * FROM BookInventory
              WHERE BookInventory.BookId = '.$this->id;

    // roll out the information from BookInventory table
    $result = $conn->query($query);
    $result -> data_seek(0);
    $result_content = $result->fetch_assoc();

    // assign the attributes to the book
    $this->name = $result_content['BookName'];
    $this->category = $result_content['Category'];
    $this->press = $result_content['Press'];
    $this->price = $result_content['Price'];

  }

  function checkAvailability($conn)
  // get the availability for this book and return the statusid and userid
  // output in an array
  {
    $query = "SELECT Status,
                    UserName,
                    BookAvailability.StatusId,
                    BookAvailability.UserId
            FROM BookAvailability
            JOIN BookStatus
              ON BookAvailability.StatusId = BookStatus.StatusId
            JOIN LibraryUsers
              ON BookAvailability.UserId = LibraryUsers.UserId
            WHERE BookId = ".$this->id;

    $result = $conn->query($query);
    $result->data_seek(0);
    $result_content = $result->fetch_assoc();
    return array($result_content['Status'],
                $result_content['UserName'],
                $result_content['StatusId'],
                $result_content['UserId']);
  }

  function displayFullInfo($conn)
  // display bookname, category, press and price
  {
    return '[BookId '.$this->id.'] '.$this->name.
      ' ('.$this->press.') was purchased at £'.$this->price.'.'
      .'<br> This is currently '.$this->checkAvailability($conn)[0]
      .' with '.$this->checkAvailability($conn)[1].'.<br>';
    //echo "codes go here";
  }

  function displayShortInfo($conn)
  //display book name and press only
  {
    return $this->name.' ('.$this->press.')';
  }
}




// $testBookIn = new BookOut;
// $testBookIn->id = 2;
// $testBookIn->getBookInfo($conn);
// echo print_r($testBookIn);
//
// $testBookIn->returnIn($conn);

// for those books available, define a child class of books

class BookIn extends Book
{
  function lendOut($owner,$conn)
  {
    // find who this owner is
    $requestingUser = new LibraryUser;
    $requestingUser->name = $owner;
    $requestingUserId = $requestingUser->findUser($conn);


    // Update the status BookAvailability
    $query = "UPDATE BookAvailability SET StatusId = 2,
        UserId = ".$requestingUserId."
        WHERE BookId = ".
      $this->id;
    $conn->query($query);

    // store the action in the log
  }
}

// for those books unavailable, define a child class of books

class BookOut extends Book
{
  function returnIn($conn)
  {
    // Update the status in MySQL table
    // if a book if returned then it is with Kiki

    $query = "UPDATE BookAvailability
              SET StatusId = 1, UserId = 1
              WHERE BookId = ".
      $this->id;
    $conn->query($query);
  }
}
// for a collection of books

class BookCollection
{
  public $collectionName = 'defaultName';
  public $booksInCollection = array(); // container for book objects

  function addBook($bookid,$conn)
  // add book based on book id
  {
    // get the book information from database
    $thisBook = new Book;
    $thisBook->id = $bookid;
    $thisBook->getBookInfo($conn);
    if ($thisBook->checkAvailability($conn)[2] == 2)
      {
        $tmpBook = new BookOut;
        $tmpBook->id = $bookid;
        $tmpBook->getBookInfo($conn);
      }
    else {
      $tmpBook = new BookIn;
      $tmpBook->id = $bookid;
      $tmpBook->getBookInfo($conn);
    }

    // make it bookin or bookout
    // depending on its availability

    //push a book to the collection array
    $this->booksInCollection[] = $tmpBook;
  }

  function displayFullCollection($conn)
  //connection to database is used for getting availability info
  {
    $collectionInfo = '';
    foreach ($this->booksInCollection as $book)
    {
      $collectionInfo = $collectionInfo.
        '<li class="w3-hover-red">'
        .$book->displayFullInfo($conn)
        .'</li>';
    }
    return $collectionInfo;
  }

  function displayCardInformation($conn)
  {
    $collectionInfo = '';
    foreach ($this->booksInCollection as $book)
    {$collectionInfo = $collectionInfo.
      '<li class="w3-hover-red ">
        <div class="w3-dropdown-hover w3-transparent">'.
          $book->displayShortInfo($conn)
        .'
          <div class="w3-dropdown-content
                      w3-card-4"
               style="width:400px">
            <div class="w3-container">
              <header class="w3-container w3-pale-red">
                <p>'.$book->name.'</p>
              </header>
              <p>'
                .$book->displayFullInfo($conn).'
              </p>
            </div>
          </div>
        </div>
      </li>';
    }
    return $collectionInfo;
  }

  function displayShortCollection($conn)
  {
    $collectionInfo = '';
    foreach($this->booksInCollection as $book)
    {
      $collectionInfo = $collectionInfo.'<li class="w3-hover-red">
                                        <a href = "#"
                                            class = "w3-button  w3-hover-red">'
        .$book->displayShortInfo($conn).'</a></li>';
    }
    return $collectionInfo;
  }

  function showCollectionInFormList()
  // to show the collection in the dropdown list
  {
    foreach ($this->booksInCollection as $book)
    {
      echo "<option value= ".$book->id.">".
        $book->name."</option>";
    }
  }
}

 ?>
