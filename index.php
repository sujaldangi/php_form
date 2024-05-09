<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $mail = $_POST['email'];
  $pass = $_POST['pass'];
  $servername = "localhost";
  $username = "root";
  $password = "";
  // $dbname = "data";
  $conn = mysqli_connect($servername, $username, $password);
  if (!$conn) {
    die("" . mysqli_connect_error());
  } else {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Connected to database</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
  }
  // create database
  $sql = 'CREATE DATABASE IF NOT EXISTS data';
  $result = mysqli_query($conn, $sql);
  if (!$result) {
    die('' . mysqli_error($conn));
  } else {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Database created</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
  }
  // create table in database
  $sql_1 = "CREATE TABLE IF NOT EXISTS `data`.`data_test` (`email` VARCHAR(50) NOT NULL , `password` VARCHAR(50) NOT NULL , PRIMARY KEY (`email`)) ENGINE = InnoDB;
  ";
  $result_sql_1 = mysqli_query($conn, $sql_1);
  if ($result_sql_1) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Table created</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
  }
  // Check if email already exists
  $check_sql = "SELECT * FROM `data`.`data_test` WHERE `email` = '$mail'";
  $check_result = mysqli_query($conn, $check_sql);
  $numer_row = mysqli_num_rows($check_result);
  if ($numer_row > 0) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Email already exists</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
  } else {
    // Insert data into the table
    $insert_sql = "INSERT INTO `data`.`data_test` (`email`, `password`) VALUES ('$mail', '$pass')";
    $insert_result = mysqli_query($conn, $insert_sql);
    if (!$insert_result) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>An error occurred:</strong> ' . mysqli_error($conn) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    } else {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Data inserted</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
  }

}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <form action='index.php' method='post'>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Email address</label>
      <input type="email" class="form-control" id="exampleInputEmail1" name="email" required aria-describedby="emailHelp">
      <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Password</label>
      <input type="password" class="form-control" name="pass" id="exampleInputPassword1" required>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<?php 
  echo "<table class='table'><thead><tr><th scope='col'>E-mail</th><th scope='col'>password</th></tr></thead>";
  $sql = 'SELECT * FROM `data`.`data_test`';
  $result = mysqli_query($conn, $sql);
  
  $num = mysqli_num_rows($result);
  if ($num > 0) {
    
    while($row = mysqli_fetch_assoc($result)){
      $m = $row["email"];
      $p = $row["password"];
      echo "<tbody><tr><td>$m</td><td>$p</td></tr>";

    }
  }

?>



</body>

</html>