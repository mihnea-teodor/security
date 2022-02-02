<?php
// Definde connection info
$con=mysqli_connect("localhost","root","", "security");
// Check connection 1/2
if(!$con){
   die('Nu sunt conectat'.mysql_error());
}
// Check connection 2/2
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// Define variables
$firstname = mysqli_real_escape_string($con, $_POST['nume']);
$lastname = mysqli_real_escape_string($con, $_POST['prenume']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$username = mysqli_real_escape_string($con, $_POST['utilizator']);
$password = mysqli_real_escape_string($con, $_POST['parola']);
// Definde SQL script for INSERT new users
$sql="INSERT INTO users (firstname, surname, email, username, password)
VALUES ('$firstname', '$lastname', '$email', '$username', MD5('$password'))";
// Check if SQL script was executed
if (!mysqli_query($con,$sql)) {
  die('Error: ' . mysqli_error($con));
}
// Close database connection
mysqli_close($con);
// Inform user that he/she was registered
echo 'Inregistrat cu succes ';
// Redirect user to login page
echo "<!-- redirect --><script>
window.setTimeout(function() {window.location.href = 'login.html';}, 3000);
</script><!-- redirect -->";
?>