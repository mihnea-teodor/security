<?php
$con=mysqli_connect("mysql.hostinger.ro","u630346707_admin","a1b2c3d4", "u630346707_mydb");
// Check connection
if(!$con){
   die('Nu sunt conectat'.mysql_error());
}

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$nume = $_GET["nume"];
$prenume = $_GET["prenume"];
$email = $_GET["email"];
$utilizator = $_GET["utilizator"];
$parola = $_GET["parola"];
$online = 0;//offline

mysql_query("INSERT INTO Utilizatori (nume, prenume, email, utilizator, parola, online)
VALUES ('$nume', '$prenume', '$email', '$utilizator', '$parola', '$online')");
//or die ("Nu s-au putut introduce datele");

echo "inregistrat cu succes";
echo $nume;
echo $prenume;
echo $email;
echo $utilizator;
echo $parola;

mysqli_close($con);
//header( 'Location: http://ourproject.esy.es/video.html' ) ;

?>