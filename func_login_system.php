<?php
$allowedUsername = 'admin';
$allowedPassword = 'letmein';

$username = 'admin';
$password = 'letmein';

$_SERVER['PHP_AUTH_USER'] = $username;
$_SERVER['PHP_AUTH_PW'] = $password;


// check if password and username are entered
if (isset($_SERVER['PHP_AUTH_USER']) &&
    isset($_SERVER['PHP_AUTH_PW']))
    {
      // check if password and username are correct
      if ($_SERVER['PHP_AUTH_USER'] === $allowedUsername &&
          $_SERVER['PHP_AUTH_PW'] === $allowedPassword)
          {
            starting_session($username);
          }
      else
      {
        die("Invalid username/password combination");
      }
    }
else {
  header('WWW-Authenticate: Basic realm = "Restricted Area"');
  header('HTTP/1.0 401 Unauthorised');
  die("Please enter your username and password");
}


///////////////////////////
// Session configuration //
///////////////////////////

// start a session

function starting_session($username){
  session_start();
  $_SESSION['username'] = $username;
  echo htmlspecialchars('You are logged in!');
  die("<p>
        <a href='index.php'>
          Click here to undirect
        </a>
      <p>");
}

// retrieve a session

function retrieving_session(){
  session_start();
  if (isset($_SESSION['username']))
  {
    echo "Welcome back!";
  }
  else {
    echo "please login";
  }
}


// destroy a session
function destroying_session()
{
  session_start();
  $_SESSION = array();
  //destroy the cookie
  setcookie(session_name(),'',time()-2592000,'/');
  session_destroy();
}
?>
