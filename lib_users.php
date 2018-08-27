<?php

// $testUser = new libraryUser;
// $testUser->name = 'Q Tang';
// $testUser->isNewUser($conn);
// // echo $testUser->newUser? 'true': 'false';
// $testUser->findUser($conn);
// $testUser->isNewUser($conn);
// echo $testUser->findUser($conn);


class libraryUser
// a class which deals with library users
{
  public $name, $id;
  public $newUser = False;

  function isNewUser($conn)
  // check if the user is in the table
  // based on username
  {
    $isNewUser = False;
    $query = "
      SELECT UserName, UserId FROM LibraryUsers
      WHERE UserName =
    '". $this->name."'";
    $result = $conn->query($query);

    if($result->num_rows == 0)
      {
        $this->newUser = True;
      }
    else {
        $this->newUser = False;
    };
    return $this->newUser;
  }

  function findUser($conn)
  // add the user to the database
  {
    if ($this->isNewUser($conn))
    {
      $query = "INSERT INTO LibraryUsers (UserName)
                VALUES ('". $this->name . "');";
      $conn -> query($query);
    }

    // get the userId for this user
    $query = "SELECT UserId FROM LibraryUsers
            WHERE UserName LIKE '" .$this->name."'";
    $result = $conn->query($query);
    $result -> data_seek(0);
    $result = $result->fetch_assoc()['UserId'];

    return $result;
  }


}

?>
