<?php
$con=mysqli_connect("mysql.hostinger.ro","u630346707_admin","a1b2c3d4", "u630346707_mydb");
// Check connection
if(!$con){
   die('Nu sunt conectat'.mysql_error());
}

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$nume = mysqli_real_escape_string($con, $_POST['nume']);
$prenume = mysqli_real_escape_string($con, $_POST['prenume']);
$telefon = mysqli_real_escape_string($con, $_POST['telefon']);

$sql="INSERT INTO Utilizatori (nume, prenume, telefon)
VALUES ('unNume', 'unPrenume', '07400001')";
mysql_query($sql);

mysqli_close($con);
//header( 'Location: http://ourproject.esy.es/video.html' ) ;

?>