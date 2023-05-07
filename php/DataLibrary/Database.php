<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include 'IDatabase.php';
class Database implements IDatabase
{
  private $host = 'localhost';
  private $user = 'root';
  private $password = 'root';
  private $dbname = 'test';

  public function Connect()
  {
    $con = mysqli_connect($this->host, $this->user, $this->password, $this->dbname);

    if ($con->connect_error) {
      die("Connection failed: " . $con->connect_error);
    }
    return $con;
  }
}
// password = T4>aG&WhJIjs>@r
// user = id20671278_bartley
// dbname = id20671278_test
// host = localhost
?>