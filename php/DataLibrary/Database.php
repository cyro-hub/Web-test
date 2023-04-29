<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'IDatabase.php';
class Database implements IDatabase
{
  protected $host = 'localhost';
  protected $user = 'root';
  protected $password = 'root';
  protected $dbname = 'test';
  public $connection;

  public function __construct()
  {
    $con = mysqli_connect($this->host, $this->user, $this->password, $this->dbname);

    if ($con->connect_error) {
      die("Connection failed: " . $con->connect_error);
    }
    $this->connection = $con;
  }

  public function Load($sql)
  {
    $result = $this->connection->query($sql);
    $this->connection->close();

    if ($result->num_rows > 0) {
      $data = [];
      while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
      }
      return $data;
    }

    return [];
  }
  public function Save($stmt)
  {
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
  //utility function for recursive deletion of products
  public function delete($indexer, $stmt, $data)
  {
      $id = $data[$indexer];
      $stmt->bind_param("s", $id);
      $result = $this->Save($stmt);
      $indexer++;
      if ($indexer < sizeof($data)) {
          $this->delete($indexer, $stmt, $data);
      }
      return (array) [$result, $indexer + 1];
  }
}
// password = T4>aG&WhJIjs>@r
// user = id20671278_bartley
// dbname = id20671278_test
// host = localhost
?>
