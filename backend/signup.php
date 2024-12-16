<?php
include("config.php");

$message = "Signup Successfully";

$name=$_POST["name"];

$username = $_POST['username'];

$mobilenumber = $_POST['mobile'];

$password = $_POST['password'];




$sql = "INSERT INTO signup (name,username, mobile, password, usertype) VALUES('$name', '$username','$mobilenumber','$password',2)";


if ($conn->query($sql) === TRUE) {

  echo "<script type='text/javascript'>alert('$message');window.location.href='../usersignin.html';</script>";

} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>